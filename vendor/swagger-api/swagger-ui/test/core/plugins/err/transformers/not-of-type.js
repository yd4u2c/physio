#/definitions/Order"
        '400':
          description: Invalid Order
  "/store/order/{orderId}":
    get:
      tags:
      - store
      summary: Find purchase order by ID
      description: For valid response try integer IDs with value >= 1 and <= 10. Other
        values will generated exceptions
      operationId: getOrderById
      produces:
      - application/xml
      - application/json
      parameters:
      - name: orderId
        in: path
        description: ID of pet that needs to be fetched
        required: true
        type: integer
        maximum: 10
        minimum: 1
        format: int64
      responses:
        '200':
          description: successful operation
          schema:
            "$ref": "#/definitions/Order"
        '400':
          description: Invalid ID supplied
        '404':
          description: Order not found
    delete:
      tags:
      - store
      summary: Delete purchase order by ID
      description: For valid response try integer IDs with positive integer value.
        Negative or non-integer values will generate API errors
      operationId: deleteOrder
      produces:
      - application/xml
      - application/json
      parameters:
      - name: orderId
        in: path
        description: ID of the order that needs to be deleted
        required: true
  