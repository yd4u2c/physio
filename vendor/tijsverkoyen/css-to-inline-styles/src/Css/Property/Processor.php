nitions": {
        "product_id": {
            "description": "The unique identifier of a product in our catalog",
            "type": "integer",
            "format": "int64"
        }
    }
}
```

Which doesn't do anything by itself but now you can reference this piece by its path in the json `#/definitions/product_id`

```php
    /**
     * @SWG\Property(ref="#/definitions/product_id")
     */
    public $id;
```

For more tips on refs, browse through the [using-refs example](https://github.com/zircote/swagger-php/tree/master/Examples/using-refs).

Alternatively, you can extend the definition altering specific fields using the `$` in-place of the `#`
```php
    /**
     * @SWG\Property(
     *   ref="$/definitions/product_id",
     *   format="int32"
     * )
     */
    public $id;
``` 

For extensions tips and examples, browse through [using-dynamic-refs example](https://github.com/zircote/swagger-php/tree/master/Examples/dynamic-reference).

## Vendor extensions

The specification allows for [custom properties](http://swagger.io/specification/#vendorExtensions) as long as they start with "x-" therefor all swagger-php annotations have an `x` property which will unfold into "x-" properties.

```php
/**
 * @SWG\Info(
 *   title="Example",
 *   version=1,
 *   x={
 *     "some-name": "a-value",
 *     "another": 2,
 *     "complex-type": {
 *       "supported":{
 *         {"version": "1.0", "level": "baseapi"},
 *         {"version": "2.1", "level": "fullapi"},
 *       }
 *     }
 *   }
 * )
 */
```

Results in:

```json
"info": {
  "title": "Example",
  "version": 1,
  "x-some-name": "a-value",
  "x-another": 2,
  "x-complex-type": {
    "supported": [{
      "version": "1.0",
      "level": "baseapi"
    }, {
      "version": "2.1",
      "level": "fullapi"
    }]
  }
},
```

The [Amazon API Gateway](http://docs.aws.amazon.com/apigateway/latest/developerguide/api-gateway-swagger-extensions.html) for example, makes use of these.


## More information about Swagger

To see which output maps to which annotation checkout [swagger-explained](http://bfanger.github.io/swagger-explained/)
Which also contain snippets of the [swagger specification](http://swagger.io/specification/)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    