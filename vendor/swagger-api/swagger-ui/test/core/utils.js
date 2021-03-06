const expect = require("expect")
const oauthBlockBuilder = require("../../docker/configurator/oauth")
const dedent = require("dedent")

describe("docker: env translator - oauth block", function() {
  it("should omit the block if there are no valid keys", function () {
    const input = {}

    expect(oauthBlockBuilder(input)).toEqual(``)
  })
  it("should omit the block if there are no valid keys", function () {
    const input = {
      NOT_A_VALID_KEY: "asdf1234"
    }

    expect(oauthBlockBuilder(input)).toEqual(``)
  })
  it("should generate a block from empty values", function() {
    const input = {
      OAUTH_CLIENT_ID: ``,
      OAUTH_CLIENT_SECRET: ``,
      OAUTH_REALM: ``,
      OAUTH_APP_NAME: ``,
      OAUTH_SCOPE_SEPARATOR: "",
      OAUTH_ADDITIONAL_PARAMS: ``,
    }

    expect(oauthBlockBuilder(input)).toEqual(dedent(`
    ui.initOAuth({
      clientId: "",
      clientSecret: "",
      realm: "",
      appName: "",
      scopeSeparator: "",
      additionalQueryStringParams: undefined,
    })`))
  })
  it("should generate a full block", function() {
    const input = {
      OAUTH_CLIENT_ID: `myId`,
      OAUTH_CLIENT_SECRET: `mySecret`,
      OAUTH_REALM: `myRealm`,
      OAUTH_APP_NAME: `myAppName`,
      OAUTH_SCOPE_SEPARATOR: "%21",
      OAUTH_ADDITIONAL_PARAMS: `{ "a": 1234, "b": "stuff" }`,
    }

    expect(oauthBlockBuilder(input)).toEqual(dedent(`
    ui.initOAuth({
      clientId: "myId",
      clientSecret: "mySecret",
      realm: "myRealm",
      appName: "myAppName",
      scopeSeparator: "%21",
      additionalQueryStringParams: { "a": 1234, "b": "stuff" },
    })`))
  })
})                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           const expect = require("expect")
const translator = require("../../docker/configurator/translator")
const dedent = require("dedent")

describe("docker: env translator", function() {
  describe("fundamentals", function() {
    it("should generate an empty baseline config", function () {
      const input = {}

      expect(translator(input)).toEqual(``)
    })

    it("should call an onFound callback", function () {
      const input = {
        MY_THING: "hey"
      }

      const onFoundSpy = expect.createSpy()

      const schema = {
        MY_THING: {
          type: "string",
          name: "myThing",
          onFound: onFoundSpy
        }
      }

      const res = translator(input, {
        schema
      })
      expect(res).toEqual(`myThing: "hey",`)
      expect(onFoundSpy.calls.length).toEqual(1)

    })

    it("should use a regular value over a legacy one, regardless of order", function () {
      const schema = {
        MY_THING: {
          type: "string",
          name: "myThing"
        },
        MY_OTHER_THING: {
          type: "string",
          name: "myThing",
          legacy: true
        }
      }

      // Regular value provided first
      expect(translator({
        MY_THING: "hey",
        MY_OTHER_THING: "hello"
      }, {
        schema
      })).toEqual(`myThing: "hey",`)

      // Legacy value provided first
      expect(translator({
        MY_OTHER_THING: "hello",
        MY_THING: "hey"
      }, {
        schema
      })).toEqual(`myThing: "hey",`)
    })

    it("should use a legacy value over a base one, regardless of order", function () {
      const schema = {
        MY_THING: {
          type: "string",
          name: "myThing",
          legacy: true
        }
      }

      const baseConfig = {
        myThing: {
          value: "base",
          schema: {
            type: "string",
            base: true
          }
        }
      }

      // Regular value provided first
      expect(translator({
        MY_THING: "legacy"
      }, {
        injectBaseConfig: true,
        schema,
        baseConfig
      })).toEqual(`myThing: "legacy",`)
    })
  })
  describe("Swagger UI configuration", function() {
    it("should generate a base config including the base content", function () {
      const input = {}

      expect(translator(input, {
        injectBaseConfig: true
      })).toEqual(dedent(`
    url: "https://petstore.swagger.io/v2/swagger.json",
    "dom_id": "#swagger-ui",
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout",
    `))
    })

    it("should ignore an unknown config", function () {
      const input = {
        ASDF1234: "wow hello"
      }

      expect(translator(input)).toEqual(dedent(``))
    })

    it("should generate a string config", function () {
      const input = {
        URL: "http://petstore.swagger.io/v2/swagger.json",
        FILTER: ""
      }

      expect(translator(input)).toEqual(dedent(`
      url: "http://petstore.swagger.io/v2/swagger.json",
      filter: "",`
      ).trim())
    })

    it("should generate a boolean config", function () {
      const input = {
        DEEP_LINKING: "true",
        SHOW_EXTENSIONS: "false",
        SHOW_COMMON_EXTENSIONS: ""
      }

      expect(translator(input)).toEqual(dedent(`
      deepLinking: true,
      showExtensions: false,
      showCommonExtensions: undefined,`
      ))
    })

    it("should generate an object config", function () {
      const input = {
        SPEC: `{ swagger: "2.0" }`
      }

      expect(translator(input)).toEqual(dedent(`
      spec: { swagger: "2.0" },`
      ).trim())
    })

    it("should generate an array config", function () {
      const input = {
        URLS: `["/one", "/two"]`,
        SUPPORTED_SUBMIT_METHODS: ""
      }

      expect(translator(input)).toEqual(dedent(`
      urls: ["/one", "/two"],
      supportedSubmitMethods: undefined,`
      ).trim())
    })

    it("should properly escape key names when necessary", function () {
      const input = {
        URLS: `["/one", "/two"]`,
        URLS_PRIMARY_NAME: "one",
      }

      expect(translator(input)).toEqual(dedent(`
      urls: ["/one", "/two"],
      "urls.primaryName": "one",`
      ).trim())
    })

    it("should disregard a legacy variable in favor of a regular one", function () {
      const input = {
        // Order is important to this test... legacy vars should be
        // superseded regardless of what is fed in first.
        API_URL: "/old.json",
        URL: "/swagger.json",
        URLS: `["/one", "/two"]`,
        API_URLS: `["/three", "/four"]`,
      }

      expect(translator(input)).toEqual(dedent(`
      url: "/swagger.json",
      urls: ["/one", "/two"],`
      ).trim())
    })


    it("should pick up legacy variables when using base config", function () {
      const input = {
        API_URL: "/swagger.json",
        API_URLS: `["/one", "/two"]`,
      }

      expect(translator(input, { injectBaseConfig: true })).toEqual(dedent(`
      "dom_id": "#swagger-ui",
      deepLinking: true,
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      plugins: [
        SwaggerUIBundle.plugins.DownloadUrl
      ],
      layout: "StandaloneLayout",
      url: "/swagger.json",
      urls: ["/one", "/two"],`

      ).trim())
    })

    it("should generate a full config k:v string", function () {
      const input = {
        API_URL: "/old.yaml",
        API_URLS: `["/old", "/older"]`,
        CONFIG_URL: "/wow",
        DOM_ID: "#swagger_ui",
        SPEC: `{ swagger: "2.0" }`,
        URL: "/swagger.json",
        URLS: `["/one", "/two"]`,
        URLS_PRIMARY_NAME: "one",
        LAYOUT: "BaseLayout",
        DEEP_LINKING: "false",
        DISPLAY_OPERATION_ID: "true",
        DEFAULT_MODELS_EXPAND_DEPTH: "0",
        DEFAULT_MODEL_EXPAND_DEPTH: "1",
        DEFAULT_MODEL_RENDERING: "example",
        DISPLAY_REQUEST_DURATION: "true",
        DOC_EXPANSION: "full",
        FILTER: "wowee",
        MAX_DISPLAYED_TAGS: "4",
        SHOW_EXTENSIONS: "true",
        SHOW_COMMON_EXTENSIONS: "false",
        OAUTH2_REDIRECT_URL: "http://google.com/",
        SHOW_MUTATED_REQUEST: "true",
        SUPPORTED_SUBMIT_METHODS: `["get", "post"]`,
        VALIDATOR_URL: "http://smartbear.com/"
      }

      expect(translator(input)).toEqual(dedent(`
      configUrl: "/wow",
      "dom_id": "#swagger_ui",
      spec: { swagger: "2.0" },
      url: "/swagger.json",
      urls: ["/one", "/two"],
      "urls.primaryName": "one",
      layout: "BaseLayout",
      deepLinking: false,
      displayOperationId: true,
      defaultModelsExpandDepth: 0,
      defaultModelExpandDepth: 1,
      defaultModelRendering: "example",
      displayRequestDuration: true,
      docExpansion: "full",
      filter: "wowee",
      maxDisplayedTags: 4,
      showExtensions: true,
      showCommonExtensions: false,
      oauth2RedirectUrl: "http://google.com/",
      showMutatedRequest: true,
      supportedSubmitMethods: ["get", "post"],
      validatorUrl: "http://smartbear.com/",`
      ).trim())
    })

    it("should generate a full config k:v string including base config", function () {
      const input = {
        API_URL: "/old.yaml",
        API_URLS: `["/old", "/older"]`,
        CONFIG_URL: "/wow",
        DOM_ID: "#swagger_ui",
        SPEC: `{ swagger: "2.0" }`,
        URL: "/swagger.json",
        URLS: `["/one", "/two"]`,
        URLS_PRIMARY_NAME: "one",
        LAYOUT: "BaseLayout",
        DEEP_LINKING: "false",
        DISPLAY_OPERATION_ID: "true",
        DEFAULT_MODELS_EXPAND_DEPTH: "0",
        DEFAULT_MODEL_EXPAND_DEPTH: "1",
        DEFAULT_MODEL_RENDERING: "example",
        DISPLAY_REQUEST_DURATION: "true",
        DOC_EXPANSION: "full",
        FILTER: "wowee",
        MAX_DISPLAYED_TAGS: "4",
        SHOW_EXTENSIONS: "true",
        SHOW_COMMON_EXTENSIONS: "false",
        OAUTH2_REDIRECT_URL: "http://google.com/",
        SHOW_MUTATED_REQUEST: "true",
        SUPPORTED_SUBMIT_METHODS: `["get", "post"]`,
        VALIDATOR_URL: "http://smartbear.com/"
      }

      expect(translator(input, { injectBaseConfig: true })).toEqual(dedent(`
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      plugins: [
        SwaggerUIBundle.plugins.DownloadUrl
      ],
      configUrl: "/wow",
      "dom_id": "#swagger_ui",
      spec: { swagger: "2.0" },
      url: "/swagger.json",
      urls: ["/one", "/two"],
      "urls.primaryName": "one",
      layout: "BaseLayout",
      deepLinking: false,
      displayOperationId: true,
      defaultModelsExpandDepth: 0,
      defaultModelExpandDepth: 1,
      defaultModelRendering: "example",
      displayRequestDuration: true,
      docExpansion: "full",
      filter: "wowee",
      maxDisplayedTags: 4,
      showExtensions: true,
      showCommonExtensions: false,
      oauth2RedirectUrl: "http://google.com/",
      showMutatedRequest: true,
      supportedSubmitMethods: ["get", "post"],
      validatorUrl: "http://smartbear.com/",`
      ).trim())
    })
  })
})                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  INDX( 	 :7�             (   @  �       �                    �)     h T     �)     d���pk� �@�����2#��<�d���pk��       �               	 . e s l i n t r c     �)     ` J     �)     |��pk�6���!%�|��pk�|��pk�                        b u g s p . j �)     h V     �)     W���pk�����!%��,ûpk�W���pk�                       
 c o m p o n e n t s   �)     ` J     �)     ���pk��}X�pk��}X�pk��}X�pk�                        c o r e p . j �)     ` N     �)     ��k�pk�c��!%���k�pk ��k�pk�                        d o c k e r j �)     h X     �)     ��y�pk����pk����pk����pk�                        e 2 e - c y p r e s s *     p Z     �)     '��pk�>���pk�>���pk�>���pk�                        e 2 e - s e l e n i u m       �)     h R     �)     |��pk� �@�����%��<�|��pk��      �               s e t u p . j s       L*     � p     �)     Q��pk��3��!%�Q��pk�Q��pk�                        s w a g g e r - u i - d i s t - p a c k a g e N*     X H    �)      "
�pk�EI�pk�EI�pk�EI�pk�                        x s s                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 // from https://github.com/pedroetb/node-oauth2-server-example

var Http = require("http")
var path = require("path")
var express = require("express")
var bodyParser = require("body-parser")
var oauthserver = require("oauth2-server")
var cors = require("cors")

var app = express()

app.use(cors())

app.use(bodyParser.urlencoded({ extended: true }))

app.use(bodyParser.json())

app.oauth = oauthserver({
  model: require("./model.js"),
  grants: ["password", "client_credentials", "implicit"],
  debug: true
})

app.all("/oauth/token", app.oauth.grant())

app.get("/swagger.yaml", function (req, res) {
  res.sendFile(path.join(__dirname, "swagger.yaml"))
})

app.get("*", app.oauth.authorise(), function (req, res) {
  res.send("Secret secrets are no fun, secret secrets hurt someone.")
})

app.use(app.oauth.errorHandler())

function startServer() {
  var httpServer = Http.createServer(app)
  httpServer.listen("3231")

  return function stopServer() {
    httpServer.close()
  }
}

module.exports = startServer

if (require.main === module) {
  // for debugging
  startServer()
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   // from https://github.com/pedroetb/node-oauth2-server-example

var config = {
  clients: [{
    clientId: "application",
    clientSecret: "secret"
  }],
  confidentialClients: [{
    clientId: "confidentialApplication",
    clientSecret: "topSecret"
  }],
  tokens: [],
  users: [{
    id: "123",
    username: "swagger",
    password: "password"
  }]
}

/**
 * Dump the memory storage content (for debug).
 */

var dump = function () {

  console.log("clients", config.clients)
  console.log("confidentialClients", config.confidentialClients)
  console.log("tokens", config.tokens)
  console.log("users", config.users)
}

/*
 * Methods used by all grant types.
 */

var getAccessToken = function (bearerToken, callback) {

  var tokens = config.tokens.filter(function (token) {

    return token.accessToken === bearerToken
  })

  return callback(false, tokens[0])
}

var getClient = function (clientId, clientSecret, callback) {

  var clients = config.clients.filter(function (client) {

    return client.clientId === clientId && client.clientSecret === clientSecret
  })

  var confidentialClients = config.confidentialClients.filter(function (client) {

    return client.clientId === clientId && client.clientSecret === clientSecret
  })

  callback(false, clients[0] || confidentialClients[0])
}

var grantTypeAllowed = function (clientId, grantType, callback) {

  var clientsSource,
    clients = []

  if (grantType === "password") {
    clientsSource = config.clients
  } else if (grantType === "client_credentials") {
    clientsSource = config.confidentialClients
  }

  if (clientsSource) {
    clients = clientsSource.filter(function (client) {

      return client.clientId === clientId
    })
  }

  callback(false, clients.length)
}

var saveAccessToken = function (accessToken, clientId, expires, user, callback) {

  config.tokens.push({
    accessToken: accessToken,
    expires: expires,
    clientId: clientId,
    user: user
  })

  callback(false)
}

/*
 * Method used only by password grant type.
 */

var getUser = function (username, password, callback) {

  var users = config.users.filter(function (user) {

    return user.username === username && user.password === password
  })

  callback(false, users[0])
}

/*
 * Method used only by client_credentials grant type.
 */

var getUserFromClient = function (clientId, clientSecret, callback) {

  var clients = config.confidentialClients.filter(function (client) {

    return client.clientId === clientId && client.clientSecret === clientSecret
  })

  var user

  if (clients.length) {
    user = {
      username: clientId
    }
  }

  callback(false, user)
}

/**
 * Export model definition object.
 */

module.exports = {
  getAccessToken: getAccessToken,
  getClient: getClient,
  grantTypeAllowed: grantTypeAllowed,
  saveAccessToken: saveAccessToken,
  getUser: getUser,
  getUserFromClient: getUserFromClient
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        swagger: "2.0"
host: localhost:3231
paths:
  /password:
    get:
      summary: OAuth2 Password
      security: 
      - oauthPassword: []
      responses:
        200:
          description: OK
          schema:
            type: string
  /application:
    get:
      summary: OAuth2 Application
      security: 
      - oauthApplication: []
      responses:
        200:
          description: OK
          schema:
            type: string
securityDefinitions:
  oauthPassword:
    type: oauth2
    flow: password
    tokenUrl: /oauth/token
  oauthApplication:
    type: oauth2
    flow: application
    tokenUrl: /oauth/token
  oauthImplicit:
    type: oauth2
    flow: implicit
    authorizationUrl: /oauth/token
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   const startOAuthServer = require("../helpers/oauth2-server")
// ***********************************************************
// This example plugins/index.js can be used to load plugins
//
// You can change the location of this file or turn off loading
// the plugins file with the 'pluginsFile' configuration option.
//
// You can read more here:
// https://on.cypress.io/plugins-guide
// ***********************************************************

// This function is called when a project is opened or re-opened (e.g. due to
// the project's config changing)

module.exports = (on, config) => {
  startOAuthServer()
  // `on` is used to hook into various events Cypress emits
  // `config` is the resolved Cypress config
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <!-- HTML for dev server -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Swagger UI</title>
  <link rel="stylesheet" type="text/css" href="./swagger-ui.css" >
  <link rel="icon" type="image/png" href="./favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="./favicon-16x16.png" sizes="16x16" />
  <style>
    html
    {
      box-sizing: border-box;
      overflow: -moz-scrollbars-vertical;
      overflow-y: scroll;
    }
    *,
    *:before,
    *:after
    {
      box-sizing: inherit;
    }
    body {
      margin:0;
      background: #fafafa;
    }
  </style>
</head>

<body>

<div id="swagger-ui"></div>

<script src="./swagger-ui-bundle.js"> </script>
<script src="./swagger-ui-standalone-preset.js"> </script>
<script>
  window.onload = function() {
    window["SwaggerUIBundle"] = window["swagger-ui-bundle"]
    window["SwaggerUIStandalonePreset"] = window["swagger-ui-standalone-preset"]
    // Build a system
    const ui = SwaggerUIBundle({
      url: "",
      dom_id: '#swagger-ui',
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      plugins: [
        SwaggerUIBundle.plugins.DownloadUrl
      ],
      layout: "StandaloneLayout",
      onComplete: () => {
        if(window.completeCount) {
          window.completeCount++
        } else {
          window.completeCount = 1
        }
      }
    })

    window.ui = ui

    ui.initOAuth({
      clientId: "your-client-id",
      clientSecret: "your-client-secret-if-required",
      realm: "your-realms",
      appName: "your-app-name",
      scopeSeparator: " ",
      