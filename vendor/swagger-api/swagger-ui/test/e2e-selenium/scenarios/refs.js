swagger: "2.0"

consumes: 
- application/json
- multipart/form-data
paths:
  /regularParams:
    get:
      parameters: 
      - name: int
        in: query
        type: integer
      - name: str
        in: query
        type: string
      - name: num
        in: query
        type: number
      - name: bool
        in: query
        type: boolean
      - name: arr
        in: query
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
        type: integer
        allowEmptyValue: true 
      - name: str
        in: query
        type: string
        allowEmptyValue: true 
      - name: num
        in: query
        type: number
        allowEmptyValue: true 
      - name: bool
        in: query
      