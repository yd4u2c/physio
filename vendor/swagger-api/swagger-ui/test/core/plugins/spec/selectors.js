,
        correctFragment,
        correctHref: "#/my%20Tag/my%20Operation"
      })
      
      const legacyFragment = "#/my_Tag/my_Operation"

      it("should expand the operation when reloaded and provided the legacy fragment", () => {
        cy.visit(`${openAPI3BaseUrl}${legacyFragment}`)
          .reload()
          .get(`${elementToGet}.is-open`)
          .should("exist")
      })


      it.skip("should rewrite to the correct fragment when provided the legacy fragment", () => {
        cy.visit(`${openAPI3BaseUrl}${legacyFragment}`)
          .reload()
          .window()
          .should("have.deep.property", "location.hash", correctFragment)
      })
    })

    describe("Operation with underscores in tag+id", () => {
      OperationDeeplinkTestFactory({
        baseUrl: openAPI3BaseUrl,
        elementToGet: ".opblock-patch",
        correctElementId: "operations-underscore_Tag-underscore_Operation",
        correctFragment: "#/underscore_Tag/underscore_Operation",
        correctHref: "#/underscore_Tag/underscore_Operation"
      })
    })

    describe("Operation with UTF-16 characters", () => {
      OperationDeeplinkTestFactory({
        baseUrl: openAPI3BaseUrl,
        elementToGet: ".opblock-head",
        correctElementId: "operations-шеллы-пошел",
        correctFragment: "#/%D1%88%D0%B5%D0%BB%D0%BB%D1%8B/%D0%BF%D0%BE%D1%88%D0%B5%D0%BB",
        correctHref: "#/шеллы/пошел"
      })
    })

    describe("Operation with no operationId", () => {
      OperationDeeplinkTestFactory({
        baseUrl: openAPI3BaseUrl,
        elementToGet: ".opblock-put",
        correctElementId: "operations-tagTwo-put_noOperationId",
        correctFragment: "#/tagTwo/put_noOperationId",
        correctHref: "#/tagTwo/put_noOperationId"
      })
    })

    describe("regular Tag", () => {
      TagDeeplinkTestFactory({
        isTagCase: true,
        baseUrl: openAPI3BaseUrl,
        elementToGet: `.opblock-tag[data-tag="myTag"][data-is-open="true"]`,
        correctElementId: "operations-tag-myTag",
        correctFragment: "#/myTag",
        correctHref: "#/myTag"
      })
    })

    describe("Tag with whitespace", () => {
      TagDeeplinkTestFactory({
        isTagCase: true,
        baseUrl: openAPI3BaseUrl,
        elementToGet: `.opblock-tag[data-tag="my Tag"][data-is-open="true"]`,
        correctElementId: "operations-tag-my_Tag",
        correctFragment: "#/my%20Tag",
        correctHref: "#/my%20Tag"
      })
    })
  })
})

function OperationDeeplinkTestFactory({ baseUrl, elementToGet, correctElementId, correctFragment, correctHref }) {  
  it("should generate a correct element ID", () => {
    cy.visit(baseUrl)
      .get(elementToGet)
      .should("have.id", correctElementId)
  })

  it("should add the correct element fragment to the URL when expanded", () => {
    cy.visit(baseUrl)
      .get(elementToGet)
      .click()
      .window()
      .should("have.deep.property", "location.hash", correctFragment)
  })

  it("should provide an anchor link that has the correct fragment as href", () => {
    cy.visit(baseUrl)
      .get(elementToGet)
      .find("a")
      .should("have.attr", "href", correctHref)
      .click()
      .window()
      .should("have.deep.property", "location.hash", correctFragment)
  })

  it("should expand the operation when reloaded", () => {
    cy.visit(`${baseUrl}${correctFragment}`)
      .get(`${elementToGet}.is-open`)
      .should("exist")
  })

  it("should retain the correct fragment when reloaded", () => {
    cy.visit(`${baseUrl}${correctFragment}`)
      .reload()
      .should("exist")
      .window()
      .should("have.deep.property", "location.hash", correctFragment)
  })

  it("should expand a tag with docExpansion disabled", () => {
    cy.visit(`${baseUrl}&docExpansion=none${correctFragment}`)
      .get(`.opblock-tag-section.is-open`)
      .should("have.length", 1)
  })

  it("should expand an operation with docExpansion disabled", () => {
    cy.visit(`${baseUrl}&docExpansion=none${correctFragment}`)
      .get(`.opblock.is-open`)
      .should("have.length", 1)
  })
}

function TagDeeplinkTestFactory({ baseUrl, elementToGet, correctElementId, correctFragment, correctHref, isTagCase = false }) {
  it("should generate a correct element ID", () => {
    cy.visit(baseUrl)
      .get(elementToGet)
      .should("have.id", correctElementId)
  })

  it("should add the correct element fragment to the URL when expanded", () => {
    cy.visit(baseUrl)
      .get(elementToGet)
      .click()
      .click() // tags need two clicks because they're expanded by default
      .window()
      .should("have.deep.property", "location.hash", correctFragment)
  })

  it("should provide an anchor link that has the correct fragment as href", () => {
    cy.visit(baseUrl)
      .get(elementToGet)
      .find("a")
      .should("have.attr", "href", correctHref)
  })

  it("should expand the tag when reloaded", () => {
    cy.visit(`${baseUrl}${correctFragment}`)
      .get(`${elementToGet}[data-is-open="true"]`)
      .should("exist")
  })

  it("should retain the correct fragment when reloaded", () => {
    cy.visit(`${baseUrl}${correctFragment}`)
      .reload()
      .should("exist")
      .window()
      .should("have.deep.property", "location.hash", correctFragment)
  })

  it("should expand a tag with docExpansion disabled", () => {
    cy.visit(`${baseUrl}&docExpansion=none${correctFragment}`)
      .get(`.opblock-tag-section.is-open`)
      .should("have.length", 1)
  })
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     describe("configuration options: `urls` and `urls.primaryName`", () => {
  describe("`urls` only", () => {
    it("should render a list of URLs correctly", () => {
      cy.visit("/?configUrl=/configs/urls.yaml")
        .get("select")
        .children()
        .should("have.length", 2)
        .get("select > option")
        .eq(0)
        .should("have.text", "One")
        .should("have.attr", "value", "/documents/features/urls/1.yaml")
        .get("select > option")
        .eq(1)
        .should("have.text", "Two")
        .should("have.attr", "value", "/documents/features/urls/2.yaml")
    })

    it("should render the first URL in the list", () => {
      cy.visit("/?configUrl=/configs/urls.yaml")
        .get("h2.title")
        .should("have.text", "One")
        .window()
        .then(win => win.ui.specSelectors.url())
        .should("equal", "/documents/features/urls/1.yaml")
    })
  })

  it("should respect a `urls.primaryName`", () => {
    cy.visit("/?configUrl=/configs/urls-primary-name.yaml")
      .get("select")
      .should("have.value", "/documents/features/urls/2.yaml")
      .get("h2.title")
      .should("have.text", "Two")
      .window()
      .then(win => win.ui.specSelectors.url())
      .should("equal", "/documents/features/urls/2.yaml")
  })
})
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            describe("OAuth2 Application flow", function() {
  beforeEach(() => {
    cy.server()
    cy.route({
      url: "**/oauth/*",
      method: "POST"
    }).as("tokenRequest")
  })

  it("should make an application flow Authorization header request", () => {
    cy
      .visit("/?url=http://localhost:3231/swagger.yaml")
      .get(".btn.authorize")
      .click()

      .get("div.modal-ux-content > div:nth-child(2)").within(() => {
        cy.get("#client_id")
          .clear()
          .type("confidentialApplication")

          .get("#client_secret")
          .clear()
          .type("topSecret")

          .get("button.btn.modal-btn.auth.authorize.button")
          .click()
      })

    cy.get("button.close-modal")
      .click()

      .get("#operations-default-get_application")
      .click()

      .get(".btn.try-out__btn")
      .click()

      .get(".btn.execute")
      .click()

    cy.get("@tokenRequest")
      .its("request")
      .its("body")
      .should("equal", "grant_type=client_credentials")

    cy.get("@tokenRequest")
      .its("request")
      .its("headers")
      .its("authorization")
      .should("equal", "Basic Y29uZmlkZW50aWFsQXBwbGljYXRpb246dG9wU2VjcmV0")

      .get(".live-responses-table .response-col_status")
      .contains("200")
  })
})                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 describe("OAuth2 Password flow", function() {
  beforeEach(() => {
    cy.server()
    cy.route({
      url: "**/oauth/*",
      method: "POST"
    }).as("tokenRequest")
  })

  it("should make a password flow Authorization header request", () => {
    cy
      .visit("/?url=http://localhost:3231/swagger.yaml")
      .get(".btn.authorize")
      .click()

      .get("#oauth_username")
      .type("swagger")

      .get("#oauth_password")
      .type("password")

      .get("#password_type")
      .select("basic")

      .get("#client_id")
      .clear()
      .type("application")

      .get("#client_secret")
      .clear()
      .type("secret")

      .get("div.modal-ux-content > div:nth-child(1) > div > div:nth-child(2) > div > div.auth-btn-wrapper > button.btn.modal-btn.auth.authorize.button")
      .click()

      .get("button.close-modal")
      .click()

      .get("#operations-default-get_password")
      .click()

      .get(".btn.try-out__btn")
      .click()

      .get(".btn.execute")
      .click()

    cy.get("@tokenRequest")
      .its("request")
      .its("body")
      .should("include", "grant_type=password")
      .should("include", "username=swagger")
      .should("include", "password=password")
      .should("not.include", "client_id")
      .should("not.include", "client_secret")

    cy.get("@tokenRequest")
      .its("request")
      .its("headers")
      .its("authorization")
      .should("equal", "Basic YXBwbGljYXRpb246c2VjcmV0")

      .get(".live-responses-table .response-col_status")
      .contains("200")
  })

  it("should make a Password flow request-body request", () => {
    cy
      .visit("/?url=http://localhost:3231/swagger.yaml")
      .get(".btn.authorize")
      .click()

      .get("#oauth_username")
      .type("swagger")

      .get("#oauth_password")
      .type("password")

      .get("#password_type")
      .select("request-body")

      .get("#client_id")
      .clear()
      .type("application")

      .get("#client_secret")
      .clear()
      .type("secret")

      .get("div.modal-ux-content > div:nth-child(1) > div > div:nth-child(2) > div > div.auth-btn-wrapper > button.btn.modal-btn.auth.authorize.button")
      .click()

      .get("button.close-modal")
      .click()

      .get("#operations-default-get_password")
      .click()

      .get(".btn.try-out__btn")
      .click()

      .get(".btn.execute")
      .click()

    cy.get("@tokenRequest")
      .its("request")
      .its("body")
      .should("include", "grant_type=password")
      .should("include", "username=swagger")
      .should("include", "password=password")
      .should("include", "client_id=application")
      .should("include", "client_secret=secret")

    cy.get("@tokenRequest")
      .its("request")
      .its("headers")
      .should("not.have.property", "authorization")

      .get(".live-responses-table .response-col_status")
      .contains("200")
  })
})                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      {
  "pet": [
    {
      "id": 1,
      "category": {
        "id": 0,
        "name": "string"
      },
      "name": "doggie",
      "photoUrls": [
        "string"
      ],
      "tags": [
        {
          "id": 0,
          "name": "string"
        }
      ],
      "status": "available"
    },
    {
      "id": 2,
      "category": {
        "id": 0,
        "name": "string"
      },
      "name": "doggie",
      "photoUrls": [
        "string"
      ],
      "tags": [
        {
          "id": 0,
          "name": "string"
        }
      ],
      "status": "available"
    },
    {
      "id": 3,
      "category": {
        "id": 0,
        "name": "string"
      },
      "name": "doggie",
      "photoUrls": [
        "string"
      ],
      "tags": [
        {
          "id": 0,
          "name": "string"
        }
      ],
      "status": "available"
    },
    {
      "id": 4,
      "category": {
        "id": 0,
        "name": "string"
      },
      "name": "doggie",
      "photoUrls": [
        "string"
      ],
      "tags": [
        {
          "id": 0,
          "name": "string"
        }
      ],
      "status": "available"
    },
    {
      "id": 5,
      "category": {
        "id": 0,
        "name": "string"
      },
      "name": "doggie",
      "photoUrls": [
        "string"
      ],
      "tags": [
        {
          "id": 0,
          "name": "string"
        }
      ],
      "status": "available"
    },
    {
      "id": 6,
      "category": {
        "id": 0,
        "name": "string"
      },
      "name": "doggie",
      "photoUrls": [
        "string"
      ],
      "tags": [
        {
          "id": 0,
          "name": "string"
        }
      ],
      "status": "available"
    },
    {
      "id": 7,
      "category": {
        "id": 0,
        "name": "string"
      },
      "name": "doggie",
      "photoUrls": [
        "string"
      ],
      "tags": [
        {
          "id": 0,
          "name": "string"
        }
      ],
      "status": "available"
    }
  ]
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        {
  "src_folders" : ["test/e2e-selenium/scenarios"],
  "output_folder" : "reports",
  "live_output": true,
  "custom_commands_path" : "",
  "custom_assertions_path" : "",
  "page_objects_path" : "test/e2e-selenium/pages",
  "globals_path" : "",

  "test_runner" : {
    "type" : "mocha",
    "options" : {
      "ui" : "bdd",
      "reporter" : "list"
    }
  },

  "selenium" : {
    "start_process" : true,
    "server_path" : "node_modules/selenium-server-standalone-jar/jar/selenium-server-standalone-3.12.0.jar",
    "log_path" : "",
    "host" : "127.0.0.1",
    "port" : 4444,
    "cli_args" : {
      "webdriver.chrome.driver" : "node_modules/chromedriver/bin/chromedriver",
      "webdriver.firefox.profile" : "",
      "webdriver.ie.driver" : ""
    }
  },

  "test_settings" : {
    "default" : {
      "launch_url" : "http://localhost",
      "selenium_port"  : 4444,
      "selenium_host"  : "localhost",
      "silent": true,
      "screenshots" : {
        "enabled" : false,
        "path" : ""
      },
      "desiredCapabilities": {
        "browserName": "chrome",
        "marionette": true
      }
    },

    "chrome" : {
      "desiredCapabilities": {
        "browserName": "chrome"
      }
    },

    "edge" : {
      "desiredCapabilities": {
        "browserName": "MicrosoftEdge"
      }
    }
  }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     