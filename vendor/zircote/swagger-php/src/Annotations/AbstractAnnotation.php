<?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Annotations\Info;
use Swagger\Annotations\Swagger;
use Swagger\Analysis;
use Swagger\Processors\MergeIntoSwagger;

class MergeIntoSwaggerTest extends SwaggerTestCase
{
    public function testProcessor()
    {
        $swagger = new Swagger([]);
        $info = new Info([]);
        $analysis = new Analysis([
            $swagger,
            $info
        ]);
        $this->assertNull($analysis->swagger);
        $this->assertNull($swagger->info);
        $analysis->process(new MergeIntoSwagger());
        $this->assertInstanceOf('Swagger\Annotations\Swagger', $analysis->swagger);
        $this->assertSame($info, $swagger->info);
        $this->assertCount(0, $analysis->unmerged()->annotations);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Processors\AugmentDefinitions;
use Swagger\Processors\AugmentProperties;
use Swagger\Processors\MergeIntoSwagger;
use Swagger\StaticAnalyser;

class NestedPropertyTest extends SwaggerTestCase
{
    public function testNestedProperties()
    {
        $analyser = new StaticAnalyser();
        $analysis = $analyser->fromFile(__DIR__ . '/Fixtures/NestedProperty.php');
        $analysis->process(new MergeIntoSwagger());
        $analysis->process(new AugmentDefinitions());
        $analysis->process(new AugmentProperties());
        
        $this->assertCount(1, $analysis->swagger->definitions);
        $definition = $analysis->swagger->definitions[0];
        $this->assertEquals('NestedProperty', $definition->definition);
        $this->assertCount(1, $definition->properties);

        $parentProperty = $definition->properties[0];
        $this->assertEquals('parentProperty', $parentProperty->property);
        $this->assertCount(1, $parentProperty->properties);

        $babyProperty = $parentProperty->properties[0];
        $this->assertEquals('babyProperty', $babyProperty->property);
        $this->assertCount(1, $babyProperty->properties);

        $theBabyOfBaby = $babyProperty->properties[0];
        $this->assertEquals('theBabyOfBaby', $theBabyOfBaby->property);
        $this->assertCount(1, $theBabyOfBaby->properties);
     
        // verbose not-recommend notations
        $theBabyOfBabyBaby = $theBabyOfBaby->properties[0];
        $this->assertEquals('theBabyOfBabyBaby', $theBabyOfBabyBaby->property);
        $this->assertNull($theBabyOfBabyBaby->properties);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Analysis;
use Swagger\Annotations\Info;
use Swagger\Annotations\Response;
use Swagger\Context;

class RefTest extends SwaggerTestCase
{
    public function testRef()
    {
        $swagger = $this->createSwaggerWithInfo();
        $info = $swagger->ref('#/info');
        $this->assertInstanceOf(Info::class, $info);

        $comment = <<<END
@SWG\Get(
    path="/api/~/endpoint",
    @SWG\Response(response="default", description="A response")
)
END;
        $swagger->merge($this->parseComment($comment));
        $analysis = new Analysis();
        $analysis->addAnnotation($swagger, Context::detect());
        $analysis->process();
        
        $analysis->validate();
        // escape / as ~1
        // escape ~ as ~0
        $response = $swagger->ref('#/paths/~1api~1~0~1endpoint/get/responses/default');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('A response', $response->description);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace Swaggertests;

use Swagger\Annotations;
use Swagger\Serializer;

class SerializerTest extends SwaggerTestCase
{
    private function getExpected()
    {
        $path = new Annotations\Path([]);
        $path->path = '/products';
        $path->post = new Annotations\Post([]);
        $path->post->tags = ['products'];
        $path->post->summary = 's1';
        $path->post->description = 'd1';
        $path->post->consumes = ['application/json'];
        $path->post->produces = ['application/json'];

        $param = new Annotations\Parameter([]);
        $param->in = 'body';
        $param->description = 'data in body';
        $param->required = true;
        $param->type = 'object';
        $param->x = [];
        $param->x['repository'] = 'abc';
        $path->post->parameters = [$param];

        $resp = new Annotations\Response([]);
        $resp->response = '200';
        $resp->x = [];
        $resp->x['repository'] = 'def';
        $schema = new Annotations\Schema([]);
        $schema->ref = '#/definitions/Pet';
        $resp->schema = $schema;
        $path->post->responses = [$resp];

        $expected = new Annotations\Swagger([]);
        $expected->swagger = '2.0';
        $expected->paths = [
            $path,
        ];

        $definition = new Annotations\Definition([]);
        $definition->definition = 'Pet';
        $definition->required = ['name', 'photoUrls'];

        $expected->definitions = [$definition];

        return $expected;
    }

    public function testDeserializeAnnotation()
    {
        $serializer = new Serializer();

        $json = <<<JSON
{
  "swagger": "2.0",
  "paths": {
    "/products": {
      "post": {
        "tags": [
          "products"
        ],
        "summary": "s1",
        "description": "d1",
        "consumes": [
          "application/json"
        ],
        "produces": [
          "application/json"
        ],
        "parameters": [
          {
            "in": "body",
            "description": "data in body",
            "required": true,
            "type": "object",
            "x-repository": "abc"
          }
        ],
        "responses": {
          "200": {
            "x-repository": "def",
            "schema": {
                "\$ref": "#/definitions/Pet"
            }
          }
        }
      }
    }
  },
  "definitions": {
    "Pet": {
      "required": [
        "name",
        "photoUrls"
      ]
    }
  }
}
JSON;

        $annotation = $serializer->deserialize($json, 'Swagger\Annotations\Swagger');

        $this->assertInstanceOf('Swagger\Annotations\Swagger', $annotation);
        $this->assertJsonStringEqualsJsonString(
            $annotation->__toString(),
            $this->getExpected()->__toString()
        );
    }

    public function testPetstoreExample()
    {
        $serializer = new Serializer();
        $swagger = $serializer->deserializeFile(__DIR__.'/ExamplesOutput/petstore.swagger.io.json');
        $this->assertInstanceOf('Swagger\Annotations\Swagger', $swagger);
        $this->assertSwaggerEqualsFile(__DIR__ . '/ExamplesOutput/petstore.swagger.io.json', $swagger);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Analyser;
use Swagger\Context;
use Swagger\StaticAnalyser;

class StaticAnalyserTest extends SwaggerTestCase
{
    public function testWrongCommentType()
    {
        $analyser = new StaticAnalyser();
        $this->assertSwaggerLogEntryStartsWith('Annotations are only parsed inside `/**` DocBlocks');
        $analyser->fromCode("<?php\n/*\n * @SWG\Parameter() */", new Context([]));
    }

    public function testIndentationCorrection()
    {
        $analyser = new StaticAnalyser();
        $analysis = $analyser->fromFile(__DIR__ . '/Fixtures/routes.php');
        $this->assertCount(18, $analysis->annotations);
    }
    
    public function testTrait()
    {
        $analyser = new StaticAnalyser();
        $analysis = $analyser->fromFile(__DIR__ . '/Fixtures/HelloTrait.php');
        $this->assertCount(2, $analysis->annotations);
        $property = $analysis->getAnnotationsOfType('Swagger\Annotations\Property')[0];
        $this->assertSame('Hello', $property->_context->trait);
    }
    
    public function testThirdPartyAnnotations()
    {
        $backup = Analyser::$whitelist;
        Analyser::$whitelist = ['Swagger\Annotations\\'];
        $analyser = new StaticAnalyser();
        $defaultAnalysis = $analyser->fromFile(__DIR__ . '/Fixtures/ThirdPartyAnnotations.php');
        $this->assertCount(3, $defaultAnalysis->annotations, 'Only read the @SWG annotations, skip the others.');
        // Allow Swagger to parse 3rd party annotations
        // might contain useful info that could be extracted with a custom processor
        Analyser::$whitelist[] = 'Zend\Form\Annotation';
        $swagger = \Swagger\scan(__DIR__ . '/Fixtures/ThirdPartyAnnotations.php');
        $this->assertSame('api/3rd-party', $swagger->paths[0]->path);
        $this->assertCount(10, $swagger->_unmerged);
        Analyser::$whitelist = $backup;
        $analysis = $swagger->_analysis;
        $annotations = $analysis->getAnnotationsOfType('Zend\Form\Annotation\Name');
        $this->assertCount(1, $annotations);
        $context = $analysis->getContext($annotations[0]);
        $this->assertInstanceOf('Swagger\Context', $context);
        $this->assertSame('ThirdPartyAnnotations', $context->class);
        $this->assertSame('\SwaggerFixtures\ThirdPartyAnnotations', $context->fullyQualifiedName($context->class));
        $this->assertCount(2, $context->annotations);
    }

    public function testAnonymousClassProducesNoError()
    {
        try {
            $analyser = new StaticAnalyser(__DIR__ . '/Fixtures/php7.php');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail("Analyser produced an error: {$e->getMessage()}");
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Closure;
use PHPUnit\Framework\TestCase;
use stdClass;
use Exception;
use Swagger\Annotations\AbstractAnnotation;
use Swagger\Annotations\Swagger;
use Swagger\Context;
use Swagger\Logger;
use Swagger\Analyser;

class SwaggerTestCase extends TestCase
{

    /**
     * @var array
     */
    private $expectedLogMessages;

    /**
     * @var Closure
     */
    private $originalLogger;

    /**
     *
     * @param string $expectedFile File containing the excepted json.
     * @param Swagger $actualSwagger
     * @param string $message
     */
    public function assertSwaggerEqua