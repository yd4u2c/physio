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
  "/pet":
    post:
      tags:
      - pet
      summary: Add a new pet to the store
      description: ''
      operationId: addPet
      responses:
        '405':
          description: Invalid input
      security:
      - petstore_auth:
        - write:pets
        - read:pets
      requestBody:
        "$ref": "#/components/requestBodies/Pet"
    put:
      tags:
      - pet
    