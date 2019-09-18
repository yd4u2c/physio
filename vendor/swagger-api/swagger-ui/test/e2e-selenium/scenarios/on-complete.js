openapi: "3.0.0"

paths:
  /regularParams:
    get:
      parameters: 
      - name: int
        in: query
        schema:
          type: integer
      - name: str
        in: query
        schema:
          type: string
      - name: num
        in: query
        schema:
          type: number
      - name: bool
        in: query
        schema:
          type: boolean
      - name: arr
        in: query
        schema:
          type: array
          items:
            type: string
      responses:
        200:
          description: ok
  /emptyValueParams:
    get:
      parameters: 
      - name: int
        in: query
        schema:
          type: integer
        allowEmptyValue: true 
      - name: str
        in: query
        schema:
     