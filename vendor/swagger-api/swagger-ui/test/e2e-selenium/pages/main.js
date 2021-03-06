---
openapi: 3.0.0
servers:
- url: http://localhost:3204/
info:
  description: 'This is a sample server Petstore server.  You can find out more about
    Swagger at [http://swagger.io](http://swagger.io) or on [irc.freenode.net, #swagger](http://swagger.io/irc/).  For
    this sample, you can use the api key `special-key` to test the authorization filters.'
  version: 1.0.0
  title: Swagger Petstore
  termsOfService: http://swagger.io/terms/
  contact:
    email: apiteam@swagger.io
  license:
    name: Apache 2.0
    url: http://www.apache.org/licenses/LICENSE-2.0.html
tags:
- name: pet
  description: Everything about your Pets
  externalDocs:
    description: Find out more
    url: http://swagger.io
- name: store
  description: Access to Petstore orders
- name: user
  description: Operations about user
  externalDocs:
    description: Find out more about our store
    url: http://swagger.io
paths:
  "/pet/findByStatus":
    get:
      tags:
      - pet
      summary: Finds Pets by status
      description: Multiple status values can be provided with comma separated strings
      operationId: findPetsByStatus
      parameters:
      - name: status
        in: query
        description: Status values that need to be considered for filter
        required: true
        explode: true
        schema:
          type: array
          items:
            type: string
            enum:
            - available
            - pending
            - sold
            default: available
      responses:
        '200':
          description: successful operation
          content:
            application/xml:
              schema:
                type: array
                items:
                  "$ref": "#/components/schemas/Pet"
            application/json:
              schema:
                type: array
                items:
                  "$ref": "#/components/schemas/Pet"
        '400':
          description: Invalid status value
      security:
      - petstore_auth:
        - write:pets
        - read:pets
externalDocs:
  description: Find out more about Swagger
  url: http://swagger.io
components:
  schemas:
    Order:
      type: object
      properties:
        id:
          type: integer
          format: int64
        petId:
          type: integer
          format: int64
        quantity:
          type: integer
          format: int32
        shipDate:
          type: string
          format: date-time
        status:
          type: string
          description: Order Status
          enum:
          - placed
          - approved
          - delivered
        complete:
          type: boolean
          default: false
      xml:
        name: Order
    Category:
      type: object
      properties:
        id:
          type: integer
          format: int64
        name:
          type: string
      xml:
        name: Category
    User:
      type: object
      properties:
        id:
          type: integer
          format: int64
        username:
          type: string
        firstName:
          type: string
        lastName:
          type: string
        email:
          type: string
        password:
          type: string
        phone:
          type: string
        userStatus:
          type: integer
          format: int32
          description: User Status
      xml:
        name: User
    Tag:
      type: object
      properties:
        id:
          type: integer
          format: int64
        name:
          type: string
      xml:
        name: Tag
    Pet:
      type: object
      required:
      - name
      - photoUrls
      properties:
        id:
          type: integer
          format: int64
        category:
          "$ref": "#/components/schemas/Category"
        name:
          type: string
          example: doggie
        photoUrls:
          type: array
          xml:
            name: photoUrl
            wrapped: true
          items:
            type: string
        tags:
          type: array
          xml:
            name: tag
            wrapped: true
          items:
            "$ref": "#/components/schemas/Tag"
        status:
          type: string
          description: pet status in the store
          enum:
          - available
          - pending
          - sold
      xml:
        name: Pet
    ApiResponse:
      type: object
      properties:
        code:
          type: integer
          format: int32
        type:
          type: string
        message:
          type: string
  requestBodies:
    Pet:
      content:
        application/json:
          schema:
            "$ref": "#/components/schemas/Pet"
        application/xml:
          schema:
            "$ref": "#/components/schemas/Pet"
      description: Pet object that needs to be added to the store
      required: true
    UserArray:
      content:
        application/json:
          schema:
            type: array
            items:
              "$ref": "#/components/schemas/User"
      description: List of user object
      required: true
  securitySchemes:
    petstore_auth:
      type: oauth2
      flows:
        implicit:
          authorizationUrl: http://petstore.swagger.io/oauth/dialog
          scopes:
            write:pets: modify pets in your account
            read:pets: read your pets
    api_key:
      type: apiKey
      name: api_key
      in: header
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    openapi: 3.0.0
info:
  title: Callback Example
  version: 1.0.0
paths:
  /streams:
    post:
      description: subscribes a client to receive out-of-band data
      parameters:
        - name: callbackUrl
          in: query
          required: true
          description: |
            the location where data will be sent.  Must be network accessible
            by the source server
          schema:
            type: string
            format: uri
            example: https://tonys-server.com
      responses:
        '201':
          description: subscription successfully created
          content:
            application/json:
              schema:
                description: subscription information
                required:
                  - subscriptionId
                properties:
                  subscriptionId:
                    description: this unique identifier allows management of the subscription
                    type: string
                    example: 2531329f-fb09-4ef7-887e-84e648214436
      callbacks:
        # the name `onData` is a convenience locator
        onData:
          $ref: '#/components/callbacks/onData'
components:
  callbacks:
    onData:
      # when data is sent, it will be sent to the `callbackUrl` provided
      # when making the subscription PLUS the suffix `/data`
      '{$request.query.callbackUrl}/data':
        post:
          requestBody:
            description: subscription payload
            content:
              application/json:
                schema:
                  properties:
                    timestamp:
                      type: string
                      format: date-time
                    userData:
                      type: string
          responses:
            '202':
              description: |
                Your server implementation should return this HTTP status code
                if the data was received successfully
            '204':
              description: |
                Your server should return this HTTP status code if no longer interested
                in further updates
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ---
swagger: '2.0'
info:
  version: 0.0.1
  title: DDErl REST interface
  description: RESTful access to IMEM DB and DDErl
schemes:
- http
- https
securityDefinitions:
  basicAuth:
    type: basic
    description: HTTP Basic Authentication Username:Password
basePath: "/dderlrest/0.0.1"
paths:
  "/sql/":
    get:
      tags:
      - sql
      security:
      - basicAuth: []
      summary: execute sql
      operationId: execSql
      description: Prepare and execute SQL statements
      parameters:
      - name: x-irest-conn
        in: header
        required: false
        description: ErlImem connection identifier
        type: string
      produces:
      - application/json
      responses:
        '200':
          description: OK
          schema:
            type: object
          headers:
            x-irest-conn:
              description: ErlImem connection identifier
              type: string
        '403':
          description: Malformed/Invalid
          schema:
            "$ref": "#/definitions/ErrorResponse"
definitions:
  ErrorResponse:
    readOnly: true
    type: object
    required:
    - errorCode
    - errorMessage
    - errorDetails
    properties:
      errorCode:
        description: Error Code
        type: number
        example: 1400
      errorMessage:
        description: Error Message
        type: string
        example: malformed
      errorDetails:
        description: Error Details
        type: string
        example: mandatory properties missing or bad type
  ViewParams:
    readOnly: true
    type: array
    items:
      type: object
      required:
      - typ
      - value
      - name
      properties:
        name:
          description: Name
          type: string
          example: ":atom_user"
        value:
          description: Value
          type: string
          example: system
        typ:
          description: Datatype
          type: string
          enum:
          - atom
          - binary
          - raw
          - blob
          - rowid
          - binstr
          - clob
          - nclob
          - varchar2
          - nvarchar2
          - char
          - nchar
          - boolean
          - datetime
          - decimal
          - float
          - fun
          - integer
          - ipaddr
          - list
          - map
          - number
          - pid
          - ref
          - string
          - term
          - binterm
          - timestamp
          - tuple
          - userid
          example: atom
        dir:
          description: Direction
          type: string
          enum:
          - in
          - out
          default: in
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              INDX( 	 @$�             (   �  �       �                    7*     h T     6*     K���pk� �@�����tH��<�K���pk�       �              	 4 1 9 6 . y a m l     8*     h T     6*     @k��pk� �@����j�J��<�@k��pk�                      	 4 3 7 4 . y a m l     9*     h T     6*     @k��pk� �@����j�J��<�@k��pk�       �              	 4 4 0 9 . y a m l     :*     h T     6*     ��pk� �@�����8M��<���pk�       @              	 4 4 4 5 . y a m l     ?*     ` J     6*     �^��pk A��!%����pk��^��pk�                        4 4 8 5 . y a ;*     h T     6*     >N��pk� �@����ߚO��<�>N��pk�p       n               	 4 5 3 6 . y a m l     <*     h T     6*     �t��pk� �@����H�Q��<��t��pk�       b
              	 4 5 8 7 . y a m l     =*     h T     6*     �׽�pk� �@����H�Q��<��׽�pk�       �              	 4 7 5 6 . y a m l     >*     � p     6*     `��pk� �@�����`T��<�`��pk�       �               f r o z e n - a r r a y - i n p u t . y a m l                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       