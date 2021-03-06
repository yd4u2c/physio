      })

      const state = fromJS({})
      const result = updateParam(state, {
        payload: {
          param,
          path: [path, method],
          value: `{ "a": 123 }`,
          isXml: false
        }
      })

      const value = result.getIn(["meta", "paths", path, method, "parameters", `body.myBody.hash-${param.hashCode()}`, "value"])
      expect(value).toEqual(`{ "a": 123 }`)
    })
  })
  describe("SPEC_UPDATE_EMPTY_PARAM_INCLUSION", function() {
    it("should store parameter values by {in}.{name}", () => {
      const updateParam = reducer["spec_update_empty_param_inclusion"]

      const path = "/pet/post"
      const method = "POST"

      const state = fromJS({})

      const result = updateParam(state, {
        payload: {
          pathMethod: [path, method],
          paramName: "param",
          paramIn: "query",
          includeEmptyValue: true
        }
      })

      const response = result.getIn(["meta", "paths", path, method, "parameter_inclusions", "query.param"])
      expect(response).toEqual(true)
    })
  })
})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          