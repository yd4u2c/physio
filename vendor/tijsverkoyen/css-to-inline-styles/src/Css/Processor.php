# Getting started

The goal of swagger-php is to generate a swagger.json using phpdoc annotations.

To output:

```json
{
   "swagger": "2.0",
   "schemes": ["http"],
   "host": "example.com",
   "basePath": "/api"
}
```

Write:

```php
/**
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="example.com",
 *   basePath="/api"
 * )
 */
```

Note that Doctrine annotation supports arrays, but uses `{` and `}` instead of `[` and `]`.

And although doctrine also supports objects, but also uses `{` and `}` and requires the property names to be surrounded with `"`.

**DON'T** write:

```php
/**
 * @SWG\Swagger(
 *   info={
 *     "title"="My first swagger documented API",
 *     "version"="1.0.0"
 *   }
 * )
 */
```

But use the annotation with the same name as the property, such as `@SWG\Info` for `info`:

```php
/**
 * @SWG\Swagger(
 *   @SWG\Info(
 *     title="My first swagger documented API",
 *     version="1.0.0"
 *   )
 * )
 */
```

This adds validation, so when you misspell a property or forget a required property it will trigger a php warning.
For example if you'd write `titel="My first ...` swagger-php whould generate a notice with "Unexpected field "titel" for @SWG\Info(), expecting "title", ..."


## Using variables in annotations

You can use constants inside doctrine annotations.

```php
define("API_HOST", ($env === "production") ? "example.com" : "localhost");
```

```php
/**
 * @SWG\Swagger(host=API_HOST)
 */
```

When you're using the CLI you'll need to include the php file with the constants using the `--bootstrap` options:
```
$ swagger --bootstrap constants.php
```


## Annotation placement

You shouldn't place all annotations inside one big @SWG\Swagger() annotation block, but scatter them throughout your codebase.
swagger-php will scan your project and merge all annotations into one @SWG\Swagger annotati