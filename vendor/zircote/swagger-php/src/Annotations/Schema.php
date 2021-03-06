tegory"
                },
                "name": {
                    "type": "string",
                    "example": "doggie"
                },
                "photoUrls": {
                    "type": "array",
                    "xml": {
                        "name": "photoUrl",
                        "wrapped": true
                    },
                    "items": {
                        "type": "string"
                    }
                },
                "tags": {
                    "type": "array",
                    "xml": {
                        "name": "tag",
                        "wrapped": true
                    },
                    "items": {
                        "$ref": "#/definitions/Tag"
                    }
                },
                "status": {
                    "type": "string",
                    "description": "pet status in the store",
                    "enum": ["available", "pending", "sold"]
                }
            },
            "xml": {
                "name": "Pet"
            }
        },
        "ApiResponse": {
            "type": "object",
            "properties": {
                "code": {
                    "type": "integer",
                    "format": "int32"
                },
                "type": {
                    "type": "string"
                },
                "message": {
                    "type": "string"
                }
            }
        }
    },
    "externalDocs": {
        "description": "Find out more about Swagger",
        "url": "http://swagger.io"
    }
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             INDX( 	 �h�             (   8  �       �                    `5     � n     _5     %%�5qk� ����j�W�E��<�%%�5qk�       �
               d y n a m i c - r e f e r e n c e . j s o n   a5     � j     _5     ߆�5qk� ����j��?H��<�߆�5qk�        E               p e t s t o r e - s i m p l e . j s o n       b5     � �     _5     ��5qk� ����j��J��<���5qk�        �                p e t s t o r e - w i t h - e x t e r n a l - d o c s . j s o n       c5     p \     _5     1L�5qk� ����j �J��<�1L�5qk�       �               p e t s t o r e . j s o n     d5     � r     _5     D�5qk� ����j�sM��<�D�5qk� �      Cv               p e t s t o r e . s w a g g e r . i o . j s o n       e5     p `     _5     As�5qk� ����j��fO��<�As�5qk�       �               u s i n g - r e f s . j s o n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              