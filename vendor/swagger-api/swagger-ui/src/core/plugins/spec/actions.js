INDX( 	 p-�             (     �       e �  t               �)     h V     �)     �Żpk� �@����*�,��<��Żpk�       �              
 f i l t e r . j s x   �)     x b     �)     Ͷ̻pk� �@�����/��<�Ͷ̻pk�       �               i n f o - w r a p p e r . j s x       �)     � j     �)     �zѻpk� �@����݀1��<��zѻpk�        O               j s o n - s c h e m a - f o r m . j s x       �)     x d     �)     2@ֻpk� �@����n�3��<�2@ֻpk�       3
               l i v e - r  s p o n s e . j s x     �)     p Z     �)     {fݻpk� �@����n�3��<�{fݻpk�        �               m a r k d o w n . j s x       �)     x d     �)     #+�pk� �@�����8��<�#+�pk�       E               m o d e l - e x a m p l e . j s x     �)     h V     �)     ���pk� �@����G
;��<����pk�       P              
 m o d e l s . j s x   �)     x b     �)     6��pk� �@�����l=��<�6��pk�                      o b j e c t - m o d e l . j s x       �)     � v     �)     ��pk  �@������?��<���pk�       �	               o n l i n e - v a l i d a t o r - b a d g e . j s x   �)     p \     �)     ��pk� �@������?��<���pk�       �               o p e r a t i o n . j s x     �)     p ^     �)     Dy�pk� �@����g0B��<�Dy�pk�                       o p e r a t i o n s . j s x   �)     x h     �)     ���pk� �@������D��<����pk�       b               p r i m i t i v e - m o d e l . j s x �)     x d     �)     �>��pk� �@�����F��<��>��pk�                     r e s p o n s e - b o d y . j s x     �)     p Z     �)     ����pk� �@�����F��<�����pk�                      r e s p o n s e . j s x       �)     x h     �)     �e��pk� �@�����WI��<��e��pk�       �	               s c h e m e s - w r a p p e r . j s x �)     h X     �)     B���pk� �@����̹K��<�B���pk�       5               s c h e m e s . j s x �)     � t     �)     �)�pk� �@����̹K��<��)�pk�       @               v e r s i o n - p r a g m a - f i l  e r . j s x                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               /* eslint-env mocha */
import React from "react"
import expect, { createSpy } from "expect"
import { shallow } from "enzyme"
import ModelExample from "components/model-example"
import ModelComponent from "components/model-wrapper"

describe("<ModelExample/>", function(){
  let components, props
  
  let exampleSelectedTestInputs = [
    { defaultModelRendering: "model", isExecute: true },
    { defaultModelRendering: "example", isExecute: true },
    { defaultModelRendering: "example", isExecute: false },
    { defaultModelRendering: "othervalue", isExecute: true },
    { defaultModelRendering: "othervalue", isExecute: false }
  ]
  
  let modelSelectedTestInputs = [
    { defaultModelRendering: "model", isExecute: false }
  ]

  beforeEach(() => {
    components = {
      ModelWrapper: ModelComponent
    }
    
    props = {
      getComponent: (c) => {
          return components[c]
      },
      specSelectors: {},
      schema: {},
      example: "{\"example\": \"value\"}",
      isExecute: false,
      getConfigs: () => ({
        defaultModelRendering: "model",
        defaultModelExpandDepth: 1
      })
    }
  })


  it("renders model and example tabs", function(){
    // When
    let wrapper = shallow(<ModelExample {...props}/>)

    // Then should render tabs
    expect(wrapper.find("div > ul.tab").length).toEqual(1)

    let tabs = wrapper.find("div > ul.tab").children()
    expect(tabs.length).toEqual(2)
    tabs.forEach((node) => {
      expect(node.length).toEqual(1)
      expect(node.name()).toEqual("li")
      expect(node.hasClass("tabitem")).toEqual(true)
    })
    expect(tabs.at(0).text()).toEqual("Example Value")
    expect(tabs.at(1).text()).toEqual("Model")
  })

  exampleSelectedTestInputs.forEach(function(testInputs) {
    it("example tab is selected if isExecute = " + testInputs.isExecute + " and defaultModelRendering = " + testInputs.defaultModelRendering, function(){
      // When
      props.isExecute = testInputs.isExecute
      props.getConfigs = () => ({
        defaultModelRendering: testInputs.defaultModelRendering,
        defaultModelExpandDepth: 1
      })
      let wrapper = shallow(<ModelExample {...props}/>)

      // Then
      let tabs = wrapper.find("div > ul.tab").children()

      let exampleTab = tabs.at(0)
      expect(exampleTab.hasClass("active")).toEqual(true)
      let modelTab = tabs.at(1)
      expect(modelTab.hasClass("active")).toEqual(false)

      expect(wrapper.find("div > div").length).toEqual(1)
      expect(wrapper.find("div > div").text()).toEqual(props.example)
    })
  })

  modelSelectedTestInputs.forEach(function(testInputs) {
    it("model tab is selected if isExecute = " + testInputs.isExecute + " and defaultModelRendering = " + testInputs.defaultModelRendering, function(){
      // When
      props.isExecute = testInputs.isExecute
      props.getConfigs = () => ({
        defaultModelRendering: testInputs.defaultModelRendering,
        defaultModelExpandDepth: 1
      })
      let wrapper = shallow(<ModelExample {...props}/>)

      // Then
      let tabs = wrapper.find("div > ul.tab").children()

      let exampleTab = tabs.at(0)
      expect(exampleTab.hasClass("active")).toEqual(false)
      let modelTab = tabs.at(1)
      expect(modelTab.hasClass("active")).toEqual(true)

      expect(wrapper.find("div > div").length).toEqual(1)
      expect(wrapper.find("div > div").find(ModelComponent).props().expandDepth).toBe(1)
    })
  })

  it("passes defaultModelExpandDepth to ModelComponent", function(){
      // When
      let expandDepth = 0
      props.isExecute = false
      props.getConfigs = () => ({
        defaultModelRendering: "model",
        defaultModelExpandDepth: expandDepth
      })
      let wrapper = shallow(<ModelExample {...props}/>)

      // Then
      expect(wrapper.find("div > div").find(ModelComponent).props().expandDepth).toBe(expandDepth)
  })

})
                                                                                                                                                                                           /* eslint-env mocha */
import React from "react"
import expect, { createSpy } from "expect"
import { shallow } from "enzyme"
import { fromJS, Map } from "immutable"
import Models from "components/models"
import ModelCollpase from "components/model-collapse"
import ModelComponent from "components/model-wrapper"

describe("<Models/>", function(){
  // Given
  let components = {
    Collapse: ModelCollpase,
    ModelWrapper: ModelComponent
  }
  let props = {
    getComponent: (c) => {
        return components[c]
    },
    specSelectors: {
      isOAS3: () => false,
      specJson: () => Map(),
      definitions: function() {
        return fromJS({
          def1: {},
          def2: {}
        })
      },
      specResolvedSubtree: () => {}
    },
    layoutSelectors: {
      isShown: createSpy()
    },
    layoutActions: {},
    getConfigs: () => ({
      docExpansion: "list",
      defaultModelsExpandDepth: 0
    })
  }


  it("passes defaultModelsExpandDepth to ModelWrapper", function(){
    // When
    let wrapper = shallow(<Models {...props}/>)

    // Then should render tabs
    expect(wrapper.find("ModelCollapse").length).toEqual(1)
    expect(wrapper.find("ModelWrapper").length).toBeGreaterThan(0)
    wrapper.find("ModelComponent").forEach((modelWrapper) => {
      expect(modelWrapper.props().expandDepth).toBe(0)
    })
  })

})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                import React from "react"
import expect from "expect"
import { shallow } from "enzyme"
import { fromJS, List } from "immutable"
import ObjectModel from "components/object-model"
import ModelExample from "components/model-example"
import Immutable from "immutable"
import Model from "components/model"
import ModelCollapse from "components/model-collapse"
import { inferSchema } from "corePlugins/samples/fn"

describe("<ObjectModel />", function() {
    const dummyComponent = () => null
    const components = {
      "JumpToPath" : dummyComponent,
      "Markdown" : dummyComponent,
      "Model" : Model,
      "ModelCollapse" : ModelCollapse
    }
    const props = {
      getComponent: c => components[c],
      getConfigs: () => {
        return {
          showExtensions: true
        }
      },
      isRef : false,
      specPath: List(),
      schema: Immutable.fromJS(
        {
          "properties": {
            // Note reverse order: c, b, a
            c: {
              type: "integer",
              name: "c"
            },
            b: {
              type: "boolean",
              name: "b"
            },
            a: {
              type: "string",
              name: "a"
            }
          }
        }
      ),
      specSelectors: {
        isOAS3(){
          return false
        }
      },
      className: "for-test"
    }
    it("renders a collapsible header", function(){
      const wrapper = shallow(<ObjectModel {...props}/>)
      const renderedModelCollapse = wrapper.find(ModelCollapse)
      expect(renderedModelCollapse.length).toEqual(1)
    })

    it("renders the object properties in order", function() {
        const wrapper = shallow(<ObjectModel {...props}/>)
        const rende