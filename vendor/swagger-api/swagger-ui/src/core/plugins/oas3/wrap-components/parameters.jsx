).toEqual("true")
      expect(wrapper.find("select option").eq(2).text()).toEqual("false")
      expect(wrapper.find("select option:checked").first().text()).toEqual("--")
    })

    it("should render the correct options for a required enum boolean parameter", function(){

      let props = {
        getComponent: getComponentStub,
        value: "",
        onChange: () => {},
        keyName: "",
        fn: {},
        required: true,
        schema: {
          type: "boolean",
          enum: ["true"]
        }
      }

      let wrapper = render(<JsonSchemaForm {...props}/>)

      expect(wrapper.find("select").length).toEqual(1)
      expect(wrapper.find("select option").length).toEqual(1)
      expect(wrapper.find("select option").eq(0).text()).toEqual("true")
      expect(wrapper.find("select option:checked").first().text()).toEqual("true")
    })
  })
  describe("objects", function() {
    it("should render the correct editor for an OAS3 object parameter", function(){
      let updateQueue = []

      let props = {
        getComponent: getComponentStub,
        value: "",
        onChange: (value) => {
          updateQueue.push({ value })
        },
        keyName: "",
        fn: {},
        errors: List(),
        schema: {
          type: "object",
          properties: {
            id: {
              type: "string",
              example: "abc123"
            }
          }
        }
      }

      let wrapper = mount(<JsonSchemaForm {...props}/>)

      updateQueue.forEach(newProps => wrapper.setProps(newProps))

      expect(wrapper.find("textarea").length).toEqual(1)
      expect(wrapper.find("textarea").text()).toEqual(`{\n  "id": "abc123"\n}`)
    })
  })
  describe("unknown types", function() {
    it("should render unknown types as strings", function(){

      let props = {
        getComponent: getComponentStub,
        value: "yo",
        onChange: () => {},
        keyName: "",
        fn: {},
        schema: {
          type: "NotARealType"
        }
      }


      let wrapper = render(<JsonSchemaForm {...props}/>)

      expect(wrapper.find("input").length).toEqual(1)
      // expect(wrapper.find("select input").length).toEqual(1)
      // expect(wrapper.find("select option").first().text()).toEqual("true")
    })

    it("should render unknown types as strings when a format is passed", function(){

      let props = {
        getComponent: getComponentStub,
        value: "yo",
        onChange: () => {},
        keyName: "",
        fn: {},
        schema: {
          type: "NotARealType",
          format: "NotARealFormat"
        }
      }


      let wrapper = render(<JsonSchemaForm {...props}/>)

      expect(wrapper.find("input").length).toEqual(1)
      // expect(wrapper.find("select input").length).toEqual(1)
      // expect(wrapper.find("select option").first().text()).toEqual("true")
    })
  })
})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 /* eslint-env mocha */
import React from "react"
import { fromJSOrdered } from "core/utils"
import expect, { createSpy } from "expect"
import { shallow } from "enzyme"
import Curl from "components/curl"
import LiveResponse from "components/live-response"
import ResponseBody from "components/response-body"

describe("<LiveResponse/>", function(){
  let request = fromJSOrdered({
    credentials: "same-origin",
    headers: {
      accept: "application/xml"
    },
    url: "http://petstore.swagger.io/v2/pet/1"
  })

  let mutatedRequest = fromJSOrdered({
    credentials: "same-origin",
    headers: {
      accept: "application/xml",
      mutated: "header"
    },
    url: "http://mutated.petstore.swagger.io/v2/pet/1"
  })

  let requests = {
    request: request,
    mutatedRequest: mutatedRequest
  }

  const tests = [
    { showMutatedRequest: true, expected: { request: "mutatedRequest", requestForCalls: 0, mutatedRequestForCalls: 1 } },
    { showMutatedRequest: false, expected: { request: "request", requestForCalls: 1, mutatedRequestForCalls: 0 } }
  ]

  tests.forEach(function(test) {
    it("passes " + test.expected.request + " to Curl when showMutatedRequest = " + test.showMutatedRequest, function() {

      // Given

      let response = fromJSOrdered({
        status: 200,
        url: "http://petstore.swagger.io/v2/pet/1",
        headers: {},
        text: "<response/>",
      })

      let mutatedRequestForSpy = createSpy().andReturn(mutatedRequest)
      let requestForSpy = createSpy().andReturn(request) 

      let components = {
        curl: Curl,
        responseBody: ResponseBody
      }

      let props = {
        response: response, 
        specSelectors: {
          mutatedRequestFor: mutatedRequestForSpy,
          requestFor: requestForSpy,
        },
        pathMethod: [ "/one", "get" ],
        getComponent: (c) => {
          return components[c]
        },
        displayRequestDuration: true,
        getConfigs: () => ({ showMutatedRequest: test.showMutatedRequest })
      }

      // When
      let wrapper = shallow(<LiveResponse {...props}/>)

      // Then
      expect(mutatedRequestForSpy.calls.length).toEqual(test.expected.mutatedRequestForCalls)
      expect(requestForSpy.calls.length).toEqual(test.expected.requestForCalls)

      const curl = wrapper.find(Curl)
      expect(curl.length).toEqual(1)
      expect(curl.props().request).toBe(requests[test.expected.request])

      const expectedUrl = requests[test.expected.request].get("url")
      expect(wrapper.find("div.request-url pre").text()).toEqual(expectedUrl)

    })
  })
})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           