
      deprecated: true
  "/pet/{petId}":
    get:
      tags:
      - pet
      summary: Find pet by ID
      description: Returns a single pet
      operationId: getPetById
      produces:
      - application/xml
      - application/json
      parameters:
      - name: petId
        in: path
        description: ID of pet to return
        required: true
        type: integer
        format: int64
      responses:
        '200':
          description: successful operation
          schema:
            "$ref": "#/definitions/Pet"
        '400':
          description: Invalid ID supplied
        '404':
          description: Pet not found
      security:
      - api_key: []
    post:
      tags:
      - pet
      summary: Updates a pet in the store with form data
      description: ''
      operationId: updatePetWithForm
      consumes:
      - applicatio