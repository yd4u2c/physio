ntType)) {
      if(contentType.includes("svg")) {
        bodyEl = <div> { content } </div>
      } else {
        bodyEl = <img style={{ maxWidth: "100%" }} src={ window.URL.createObjectURL(content) } />
      }

      // Audio
    } else if (/^audio\//i.test(contentType)) {
      bodyEl = <pre><audio controls><source src={ url } type={ contentType } /></audio></pre>
    } else if (typeof content === "string") {
      bodyEl = <HighlightCode downloadable fileName={`${downloadName}.txt`} value={ content } />
    } else if ( content.size > 0 ) {
      // We don't know the contentType, but there was some content returned
      if(parsedContent) {
        // We were able to squeeze something out of content
        // in `updateParsedContent`, so let's display it
        bodyEl = <div>
          <p className="i">
            Unrecognized response type; displaying content as text.
          </p>
          <HighlightCode downloadable fileName={`${downloadName}.txt`} value={ parsedContent } />
        </div>

      } else {
        // Give up
        bodyEl = <p className="i">
          Unrecognized response type; unable to display.
        </p>
      }
    } else {
      // We don't know the contentType and there was no content returned
      bodyEl = null
    }

    return ( !bodyEl ? null : <div>
        <h5>Response body</h5>
        { bodyEl }
      </div>
    )
  }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  import React from "react"
import PropTypes from "prop-types"
import ImPropTypes from "react-immutable-proptypes"
import cx from "classnames"
import { fromJS, Seq, Iterable, List, Map } from "immutable"
import { getSampleSchema, fromJSOrdered, stringify } from "core/utils"

const getExampleComponent = ( sampleResponse, examples, HighlightCode ) => {
  if ( examples && examples.size ) {
    return examples.entrySeq().map( ([ key, example ]) => {
      let exampleValue = stringify(example)

      return (<div key={ key }>
        <h5>{ key }</h5>
        <HighlightCode className="example" value={ exampleValue } />
      </div>)
    }).toArray()
  }

  if ( sampleResponse ) { return <div>
      <HighlightCode className="example" value={ sampleResponse } />
    </div>
  }
  return null
}

export default class Response extends React.Component {
  constructor(props, context) {
    super(props, context)

    this.state = {
      responseContentType: ""
    }
  }

  static propTypes = {
    code: PropTypes.string.isRequired,
    response: PropTypes.instanceOf(Iterable),
    className: PropTypes.string,
    getComponent: PropTypes.func.isRequired,
    getConfigs: PropTypes.func.isRequired,
    specSelectors: PropTypes.object.isRequired,
    specPath: ImPropTypes.list.isRequired,
    fn: PropTypes.object.isRequired,
    contentType: PropTypes.string,
    controlsAcceptHeader: PropTypes.bool,
    onContentTypeChange: PropTypes.func
  }

  static defaultProps = {
    response: fromJS({}),
    onContentTypeChange: () => {}
  };

  _onContentTypeChange = (va