
  }

  if (type === "array") {
    if (items) {
      items.xml = items.xml || xml || {}
      items.xml.name = items.xml.name || xml.name

      if (xml.wrapped) {
        res[displayName] = []
        if (Array.isArray(example)) {
          example.forEach((v)=>{
            items.example = v
            res[displayName].push(sampleXmlFromSchema(items, config))
          })
        } else if (Array.isArray(defaultValue)) {
          defaultValue.forEach((v)=>{
            items.default = v
            res[displayName].push(sampleXmlFromSchema(items, config))
          })
        } else {
          res[displayName] = [sampleXmlFromSchema(items, config)]
        }

        if (_attr) {
          res[displayName].push({_attr: _attr})
        }
        return res
      }

      let _res = []

      if (Array.isArray(example)) {
        example.forEach((v)=>{
          items.example = v
          _res.push(sampleXmlFromSchema(items, config))
        })
        return _res
      } else if (Array.isArray(defaultValue)) {
        defaultValue.forEach((v)=>{
          items.default = v
          _res.push(sampleXmlFromSchema(items, config))
        })
        return _res
      }

      return sampleXmlFromSchema(items, config)
    }
  }

  if (type === "object") {
    let props = objectify(properties)
    res[displayName] = []
    example = example || {}

    for (let propName in props) {
      if (!props.hasOwnProperty(propName)) {
        continue
      }
      if ( props[propName].readOnly && !includeReadOnly ) {
        continue
      }
      if ( props[propName].writeOnly && !includeWriteOnly ) {
        continue
      }

      props[propName].xml = props[propName].xml || {}

      if (props[propName].xml.attribute) {
        let enumAttrVal = Array.isArray(props[propName].enum) && props[propName].enum[0]
        let attrExample = props[propName].example
        let attrDefault = props[propName].default
        _attr[props[propName].xml.name || propName] = attrExample!== undefined && attrExample
          || example[propName] !== undefined && example[propName] || attrDefault !== undefined && attrDefault
          || enumAttrVal || primitive(props[propName])
      } else {
        props[propName].xml.name = props[propName].xml.name || propName
        if(props[propName].example === undefined && example[propName] !== undefined) {
          props[propName].example = example[propName]
        }
        let t = sampleXmlFromSchema(props[propName])
        if (Array.isArray(t)) {
          res[displayName] = res[displayName].concat(t)
        } else {
          res[displayName].push(t)
        }

      }
    }

    if (additionalProperties === true) {
      res[displayName].push({additionalProp: "Anything can be here"})
    } else if (additionalProperties) {
      res[displayName].push({additionalProp: primitive(additionalProperties)})
    }

    if (_attr) {
      res[displayName].push({_attr: _attr})
    }
    return res
  }

  if (example !== undefined) {
    value = example
  } else if (defaultValue !== undefined) {
    //display example if exists
    value = defaultValue
  } else if (Array.isArray(enumValue)) {
    //display enum first value
    value = enumValue[0]
  } else {
    //set default value
    value = primitive(schema)
  }

  res[displayName] = _attr ? [{_attr: _attr}, value] : value

  return res
}

export function createXMLExample(schema, config) {
  let json = sampleXmlFromSchema(schema, config)
  if (!json) { return }

  return XML(json, { declaration: true, indent: "\t" })
}

export const memoizedCreateXMLExample = memoizee(createXMLExample)

export const memoizedSampleFromSchema = memoizee(sampleFromSchema)
                                                                                                                                                                                           