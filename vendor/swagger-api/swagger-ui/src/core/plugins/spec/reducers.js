/* eslint-env mocha */
import React from "react"
import expect, { createSpy } from "expect"
import { mount } from "enzyme"
import { fromJS, Map } from "immutable"
import OnlineValidatorBadge from "components/online-validator-badge"

describe("<OnlineValidatorBadge/>", function () {
  it("should render a validator link and image correctly for the default validator", function () {
    // When
    const props = {
      getConfigs: () => ({}),
      getComponent: () => null,
      specSelectors: {
        url: () => "swagger.json"
      }
    }
    const wrapper = mount(
     <OnlineValidatorBadge {...props} />
    )

    // Then
    expect(wrapper.find("a").props().href).toEqual(
      "https://online.swagger.io/validator/debug?url=swagger.json"
    )
    expect(wrapper.find("ValidatorImage").length).toEqual(1)
    expect(wrapper.find("ValidatorImage").props().src).toEqual(
      "https://online.swagger.io/validator?url=swagger.json"
    )
  })
  it("should encode a definition URL correctly", function () {
    // When
    const props = {
      getConfigs: () => ({}),
      getComponent: () => null,
      specSelectors: {
        url: () => "http://google.com/swagger.json"
      }
    }
    const wrapper = mount(
      <OnlineValidatorBadge {...props} />
    )

    // Then
    expect(wrapper.find("a").props().href).toEqual(
      "https://online.swagger.io/validator/debug?url=http%3A%2F%2Fgoogle.com%2Fswagger.json"
    )
    expect(wrapper.find("ValidatorImage").length).toEqual(1)
    expect(wrapper.find("ValidatorImage").props().src).toEqual(
      "https://online.swagger.io/validator?url=http%3A%2F%2Fgoogle.com%2Fswagger.json"
    )
  })
  it.skip("should resolve a definition URL against the browser's location", function () {
    // TODO: mock `window`
    // When

    const props = {
      getConfigs: () => ({}),
      getComponent: () => null,
      specSelectors: {
        url: () => "http://google.com/swagger.json"
      }
    }
    const wrapper = mount(
      <OnlineValidatorBadge {...props} />
    )

    // Then
    expect(wrapper.find("a").props().href).toEqual(
      "https://online.swagger.io/validator/debug?url=http%3A%2F%2Fgoogle.com%2Fswagger.json"
    )
    expect(wrapper.find("ValidatorImage").length).toEqual(1)
    expect(wrapper.find("ValidatorImage").props().src).toEqual(
      "https://online.swagger.io/validator?url=http%3A%2F%2Fgoogle.com%2Fswagger.json"
    )
  })
  // should resolve a definition URL against the browser's location

})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             /* eslint-env mocha */
import React from "react"
import expect, { createSpy } from "expect"
import { shallow } from "enzyme"
import Operation from "components/operation"

describe("<Operation/>", function(){
  it.skip("blanket tests", function(){

    let props = {
      operation: {get: ()=>{}},
      getComponent: ()=> "div",
      specSelectors: { security(){} },
      path: "/one",
      method: "get",
      shown: true,
      showOpId: "",
      showOpIdPrefix: "",
      toggleCollapse: createSpy()
    }

    let wrapper = shallow(<Operation {...props}/>)

    expect(wrapper.find(".opblock").length).toEqual(1)
    expect(wrapper.find(".opblock-summary-method").text()).toEqual("GET")
    expect(wrapper.find(".opblock-summary-path").text().trim()).toEqual("/one")
    expect(wrapper.find("[isOpened]").prop("isOpened")).toEqual(true)

    wrapper.find(".opblock-summary").simulate("click")
    expect(props.toggleCollapse).toHaveBeenCalled()
  })
})
                                                                                                                                                                                                                                                                                                                                                 