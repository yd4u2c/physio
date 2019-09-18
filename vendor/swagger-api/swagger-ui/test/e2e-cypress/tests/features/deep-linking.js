:"integer",
                        "format":"int32",
                        "description":"calls per hour allowed by the user"
                     },
                     "X-Expires-After":{
                        "type":"string",
                        "format":"date-time",
                        "description":"date in UTC when token expires"
                     }
                  }
               },
               "400":{
                  "description":"Invalid username/password supplied"
               }
            }
         }
      },
      "/user/logout":{
         "get":{
            "tags":[
               "user"
            ],
            "summary":"Logs out current logged in user session",
            "description":"",
            "operationId":"logoutUser",
            "produces":[
               "application/xml",
               "application/json"
            ],
            "parameters":[

            ],
            "responses":{
               "default":{
                  "description":"successful operation"
               }
            }
         }
      },
      "/user/{username}":{
         "get":{
            "tags":[
               "user"
            ],
            "summary":"Get user by user name",
            "description":"",
            "operationId":"getUserByName",
            "produces":[
               "application/xml",
               "application/json"
            ],
            "parameters":[
               {
                  "name":"username",
                  "in":"path",
                  "description":"The name that needs to be fetched. Use user1 for testing. ",
                  "required":true,
                  "type":"string"
               }
            ],
            "responses":{
               "200":{
                  "description":"successful operation",
                  "schema":{
                     "$ref":"#/definitions/User"
                  }
               },
               "400":{
                  "description":"Invalid username supplied"
               },
               "404":{
                  "description":"User not found"
               }
            }
         },
         "put":{
            "tags":[
               "user"
            ],
            "summary":"Updated user",
            "description":"This can only be done by the logged in user.",
            "operationId":"updateUser",
            "produces":[
               "application/xml",
               "application/json"
            ],
            "parameters":[
               {
                  "name":"username",
                  "in":"path",
                  "description":"name that need to be updated",
                  "required":true,
                  "type":"string"
               },
               {
                  "in":"body",
                  "name":"body",
                  "description":"Updated user object",
                  "required":true,
                  "schema":{
                     "$ref":"#/definitions/User"
                  }
               }
            ],
            "responses":{
               "400":{
                  "description":"Invalid user supplied"
               },
               "404":{
                  "description":"User not found"
               }
            }
         },
         "delete":{
            "tags":[
               "user"
            ],
            "summary":"Delete user",
            "description":"This can only be done by the logged in user.",
            "operationId":"deleteUser",
            "produces":[
               "application/xml",
               "application/json"
            ],
            "parameters":[
               {
                  "name":"username",
                  "in":"path",
                  "description":"The name that needs to be deleted",
                  "required":true,
                  "type":"string"
               }
            ],
            "responses":{
               "400":{
                  "description":"Invalid username supplied"
               },
               "404":{
                  "description":"User not found"
               }
            }
         }
      }
   },
   "securityDefinitions":{
      "petstore_auth":{
         "type":"oauth2",
         "authorizationUrl":"http://petstore.swagger.io/oauth/dialog",
         "flow":"implicit",
         "scopes":{
            "write:pets":"modify pets in your account",
            "read:pets":"read your pets"
         }
      },
      "api_key":{
         "type":"apiKey",
         "name":"api_key",
         "in":"header"
      }
   },
   "definitions":{
      "Order":{
         "type":"object",
         "properties":{
            "id":{
               "type":"integer",
               "format":"int64"
            },
            "petId":{
               "type":"integer",
               "format":"int64"
            },
            "quantity":{
               "type":"integer",
               "format":"int32"
            },
            "shipDate":{
               "type":"string",
               "format":"date-time"
            },
            "status":{
               "type":"string",
               "description":"Order Status",
               "enum":[
                  "placed",
                  "approved",
                  "delivered"
               ]
            },
            "complete":{
               "type":"boolean",
               "default":false
            }
         },
         "xml":{
            "name":"Order"
         }
      },
      "Category":{
         "type":"object",
         "properties":{
            "id":{
               "type":"integer",
               "format":"int64"
            },
            "name":{
               "type":"string"
            }
         },
         "xml":{
            "name":"Category"
         }
      },
      "User":{
         "type":"object",
         "properties":{
            "id":{
               "type":"integer",
               "format":"int64"
            },
            "username":{
               "type":"string"
            },
            "firstName":{
               "type":"string"
            },
            "lastName":{
               "type":"string"
            },
            "email":{
               "type":"string"
            },
            "password":{
               "type":"string"
            },
            "phone":{
               "type":"string"
            },
            "userStatus":{
               "type":"integer",
               "format":"int32",
               "description":"User Status"
            }
         },
         "xml":{
            "name":"User"
         }
      },
      "Tag":{
         "type":"object",
         "properties":{
            "id":{
               "type":"integer",
               "format":"int64"
            },
            "name":{
               "type":"string"
            }
         },
         "xml":{
            "name":"Tag"
         }
      },
      "Pet":{
         "type":"object",
         "required":[
            "name",
            "photoUrls"
         ],
         "properties":{
            "id":{
               "type":"integer",
               "format":"int64"
            },
            "category":{
               "$ref":"#/definitions/Category"
            },
            "name":{
               "type":"string",
               "example":"doggie"
            },
            "photoUrls":{
               "type":"array",
               "xml":{
                  "name":"photoUrl",
                  "wrapped":true
               },
               "items":{
                  "type":"string"
               }
            },
            "tags":{
               "type":"array",
               "xml":{
                  "name":"tag",
                  "wrapped":true
               },
               "items":{
                  "$ref":"#/definitions/Tag"
               }
            },
            "status":{
               "type":"string",
               "description":"pet status in the store",
               "enum":[
                  "available",
                  "pending",
                  "sold"
               ]
            }
         },
         "xml":{
            "name":"Pet"
         }
      },
      "ApiResponse":{
         "type":"object",
         "properties":{
            "code":{
               "type":"integer",
               "format":"int32"
            },
            "type":{
               "type":"string"
            },
            "message":{
               "type":"string"
            }
         }
      }
   },
   "externalDocs":{
      "description":"Find out more about Swagger",
      "url":"http://swagger.io"
   }
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             