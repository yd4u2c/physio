ders: {
                accept: "application/x-www-form-urlencoded"
            }
        }

        let curlified = curl(Im.fromJS(req))

        expect(curlified).toEqual("curl -X DELETE \"http://example.com\" -H  \"accept: application/x-www-form-urlencoded\"")
    })

    it("should print a curl with formData", function() {
        var req = {
            url: "http://example.com",
            method: "POST",
            headers: { "content-type": "multipart/form-data" },
            body: {
              id: "123",
              name: "Sahar"
            }
        }

        let curlified = curl(Im.fromJS(req))

        expect(curlified).toEqual("curl -X POST \"http://example.com\" -H  \"content-type: multipart/form-data\" -F \"id=123\" -F \"name=Sahar\"")
    })

    it("should print a curl with formData and file", function() {
        var file = new win.File()
        file.name = "file.txt"
        file.type = "text/plain"

        var req = {
            url: "http://example.com",
            method: "POST",
            headers: { "content-type": "multipart/form-data" },
            body: {
              id: "123",
              file
            }
        }

        let curlified = curl(Im.fromJS(req))

        expect(curlified).toEqual("curl -X POST \"http://example.com\" -H  \"content-type: multipart/form-data\" -F \"id=123\" -F \"file=@file.txt;type=text/plain\"")
    })

    it("should print a curl without form data type if type is unknown", function() {
      var file = new win.File()
      file.name = "file.txt"
      file.type = ""

      var req = {
        url: "http://example.com",
        method: "POST",
        headers: { "content-type": "multipart/form-data" },
        body: {
          id: "123",
          file
        }
      }

      let curlified = curl(Im.fromJS(req))

      expect(curlified).toEqual("curl -X POST \"http://example.com\" -H  \"content-type: multipart/form-data\" -F \"id=123\" -F \"file=@file.txt\"")
    })

    it("prints a curl post statement from an object", function() {
        var req = {
            url: "http://example.com",
            method: "POST",
            headers: {
                accept: "application/json"
            },
            body: {
                id: 10101
            }
        }

        let curlified = curl(Im.fromJS(req))

        expect(curlified).toEqual("curl -X POST \"http://example.com\" -H  \"accept: application/json\" -d {\"id\":10101}")
    })

    it("prints a curl post statement from a string containing a single quote", function() {
        var req = {
            url: "http://example.com",
            method: "POST",
            headers: {
                accept: "application/json"
            },
            body: "{\"id\":\"foo'bar\"}"
        }

        let curlified = curl(Im.fromJS(req))

        expect(curlified).toEqual("curl -X POST \"http://example.com\" -H  \"accept: application/json\" -d \"{\\\"id\\\":\\\"foo'bar\\\"}\"")
    })

})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               /* eslint-env mocha */
import expect, { createSpy } from "expect"
import { fromJS } from "immutable"
import win from "core/window"
import oauth2Authorize from "core/oauth2-authorize"

describe("oauth2", function () {

  let mockSchema = {
    flow: "accessCode",
    authorizationUrl: "https://testAuthorizationUrl"
  }

  let authConfig = {
    auth: { schema: { get: (key)=> mockSchema[key] } }, 
    authActions: {}, 
    errActions: {}, 
    configs: { oauth2RedirectUrl: "" }, 
    authConfigs: {}
  }

  describe("authorize redirect", function () {

    it("should build authorize url", function() {
      win.open = createSpy()
      oauth2Authorize(authConfig)
      expect(win.open.calls.length).toEqual(1)
      expect(win.open.calls[0].arguments[0]).toMatch("https://testAuthorizationUrl?response_type=code&redirect_uri=&state=")
    })

    it("should append query parameters to authorizeUrl with query parameters", function() {
      win.open = createSpy()
      mockSchema.authorizationUrl = "https://testAuthorizationUrl?param=1"
      oauth2Authorize(authConfig)
      expect(win.open.calls.length).toEqual(1)
      expect(win.open.calls[0].arguments[0]).toMatch("https://testAuthorizationUrl?param=1&response_type=code&redirect_uri=&state=")
    })
  })
})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               