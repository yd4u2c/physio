/* eslint-env mocha */
import React from "react"
import expect from "expect"
import { render } from "enzyme"
import { fromJS } from "immutable"
import DeepLink from "components/deep-link"
import Operations from "components/operations"
import {Collapse} from "components/layout-utils"

const components = {
  Collapse,
  DeepLink,
  OperationContainer: ({ path, method }) => <span className="mocked-op" id={`${path}-${method}`} />,
  OperationTag: "div",
}

describe("<Operations/>", function(){
  it("should render a Swagger2 `get` method, but not a `trace` or `foo` method", function(){

    let props = {
      fn: {},
      specActions: {},
      layoutActions: {},
      getComponent: (name)=> {
        return components[name] || null
      },
      getConfigs: () => {
        return {}
      },
      specSelectors: {
        isOAS3() { return false },
        taggedOperations() {
          return fromJS({
          "default": {
            "operations": [
              {
                "path": "/pets/{id}",
                "method": "get"
              },
              {
                "path": "/pets/{id}",
                "method": "trace"
              },
              {
                "path": "/pets/{id}",
                "method": "foo"
              },
            ]
          }
        })
        },
      },
      layoutSelectors: {
        currentFilter() {
          return null
        },
        isShown() {
          return true
        },
        show() {
          return true
        }
      }
    }

    let wrapper = render(<Operations {...props}/>)

    expect(wrapper.find("span.mocked-op").length).toEqual(1)
    expect(wrapper.find("span.mocked-op").eq(0).attr("id")).toEqual("/pets/{id}-get")
  })

  it("should render an OAS3 `get` and `trace` method, but not a `foo` method", function(){

    let props = {
      fn: {},
      specActions: {},
      layoutActions: {},
      getComponent: (name)=> {
        return components[name] || null
      },
      getConfigs: () => {
        return {}
      },
      specSelectors: {
        isOAS3() { return true },
        taggedOperations() {
          return fromJS({
          "default": {
            "operations": [
              {
                "path": "/pets/{id}",
                "method": "get"
              },
              {
                "path": "/pets/{id}",
                "method": "trace"
              },
              {
                "path": "/pets/{id}",
                "method": "foo"
              },
            ]
          }
        })
        },
      },
      layoutSelectors: {
        currentFilter() {
          return null
        },
        isShown() {
          return true
        },
        show() {
          return true
        }
      }
    }

    let wrapper = render(<Operations {...props}/>)

    expect(wrapper.find("span.mocked-op").length).toEqual(2)
    expect(wrapper.find("span.mocked-op").eq(0).attr("id")).toEqual("/pets/{id}-get")
    expect(wrapper.find("span.mocked-op").eq(1).attr("id")).toEqual("/pets/{id}-trace")
  })
})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                /* eslint-env mocha */
import React from "react"
import expect from "expect"
import { shallow } from "enzyme"
import { fromJS } from "immutable"
import PrimitiveModel from "components/primitive-model"

describe("<PrimitiveModel/>", function() {
    describe("Model name", function() {
        const dummyComponent = () => null
        const components = {
            Markdown: dummyComponent,
            EnumModel: dummyComponent
        }
        const props = {
            getComponent: c => components[c],
            getConfigs: () => ({
                showExtensions: false
            }),
            name: "Name from props",
            depth: 1,
            schema: fromJS({
                type: "string",
                title: "Custom model title"
            })
        }

        it("renders the schema's title", function() {
            // When
            const wrapper = shallow(<PrimitiveModel {...props}/>)
            const modelTitleEl = wrapper.find("span.model-title")
            expect(modelTitleEl.length).toEqual(1)

            // Then
            expect( modelTitleEl.text() ).toEqual( "Custom model title" )
        })

        it("falls back to the passed-in `name` prop for the title", function() {
            // When
            props.schema = fromJS({
                type: "string"
            })
            const wrapper = shallow(<PrimitiveModel {...props}/>)
            const modelTitleEl = wrapper.find("span.model-title")
            expect(modelTitleEl.length).toEqual(1)

            // Then
            expect( modelTitleEl.text() ).toEqual( "Name from props" )
        })

    })
} )
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              import React from "react"
import expect from "expect"
import { shallow } from "enzyme"
import ResponseBody from "components/response-body"
import { inferSchema } from "corePlugins/samples/fn"

describe("<ResponseBody />", function() {
    const highlightCodeComponent = () => null
    const components = {
        highlightCode: highlightCodeComponent
    }
    const props = {
        getComponent: c => components[c],
    }

    it("renders ResponseBody as 'application/json'", function() {
        props.contentType = "application/json"
        props.content = "{\"key\": \"a test value\"}"
        const wrapper = shallow(<ResponseBody {...props}/>)
        expect(wrapper.find("highlightCodeComponent").length).toEqual(1)
    })

    it("renders ResponseBody as 'text/html'", function() {
        props.contentType = "application/json"
        props.content = "<b>Result</b>"
        const wrapper = shallow(<ResponseBody {...props}/>)
        expect(wrapper.find("highlightCodeComponent").length).toEqual(1)
    })

    it("renders ResponseBody as 'image/svg'", function() {
        props.contentType = "image/svg"
        const wrapper = shallow(<ResponseBody {...props}/>)
        console.warn(wrapper.debug())
        expect(wrapper.find("highlightCodeComponent").length).toEqual(0)
    })
})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          import React from "react"
import expect from "expect"
import { shallow } from "enzyme"
import { fromJS } from "immutable"
import Response from "components/response"
import ModelExample from "components/model-example"
import { inferSchema } from "corePlugins/samples/fn"

describe("<Response />", function() {
    const dummyComponent = () => null
    const components = {
        headers: dummyComponent,
        highlightCode: dummyComponent,
        modelExample: ModelExample,
        Markdown: dummyComponent,
        operationLink: dummyComponent,
        contentType: dummyComponent
    }
    const props = {
        getComponent: c => components[c],
        specSelectors: {
            isOAS3() {
                return false
            }
        },
        fn: {
            inferSchema
        },
        contentType: "application/json",
        className: "for-test",
        response: fromJS({
            type: "object",
            properties: {
                // Note reverse order: c, b, a
                "c": {
                    type: "integer"
                },
                "b": {
                    type: "boolean"
                },
                "a": {
                    type: "string"
                }
            }
        }),
        code: "200"
    }

    it("renders the model-example schema properties in order", function() {
        const wrapper = shallow(<Response {...props}/>)
        const renderedModelExample = wrapper.find(ModelExample)
        expect(renderedModelExample.length).toEqual(1)

        // Assert the schema's properties have maintained their order
        const modelExampleSchemaProperties = renderedModelExample.props().schema.toJS().properties
        expect( Object.keys(modelExampleSchemaProperties) ).toEqual(["c", "b", "a"])
    })
})                                                                                                                                                                              