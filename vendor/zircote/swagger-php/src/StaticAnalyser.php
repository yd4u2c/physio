<?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Analyser;
use Swagger\StaticAnalyser;

class ConstantsTest extends SwaggerTestCase
{
    const URL = 'http://example.com';

    private static $counter = 0;

    public function testConstant()
    {
        self::$counter++;
        $const = 'SWAGGER_TEST_'.self::$counter;
        $this->assertFalse(defined($const));
        $this->assertSwaggerLogEntryStartsWith("[Semantical Error] Couldn't find constant ".$const);
        $this->parseComment('@SWG\Contact(email='.$const.')');

        define($const, 'me@domain.org');
        $annotations = $this->parseComment('@SWG\Contact(email='.$const.')');
        $this->assertSame('me@domain.org', $annotations[0]->email);
    }

    public function testFQCNConstant()
    {
        $annotations = $this->parseComment('@SWG\Contact(url=SwaggerTests\ConstantsTest::URL)');
        $this->assertSame('http://example.com', $annotations[0]->url);

        $annotations = $this->parseComment('@SWG\Contact(url=\SwaggerTests\ConstantsTest::URL)');
        $this->assertSame('http://example.com', $annotations[0]->url);
    }

    public function testInvalidClass()
    {
        $this->assertSwaggerLogEntryStartsWith("[Semantical Error] Couldn't find constant ConstantsTest::URL");
        $this->parseComment('@SWG\Contact(url=ConstantsTest::URL)');
    }

    public function testAutoloadConstant()
    {
        if (class_exists('Zend\Validator\Timezone', false)) {
            $this->markTestSkipped();
            $annotations = $this->parseComment('@SWG\Contact(name=Zend\Validator\Timezone::INVALID_TIMEZONE_LOCATION)');
            $this->assertSame('invalidTimezoneLocation', $annotations[0]->name);
        }
    }

    public function testDynamicImports()
    {
        $backup = Analyser::$whitelist;
        Analyser::$whitelist = false;
        $analyser = new StaticAnalyser();
        $analysis = $analyser->fromFile(__DIR__ . '/Fixtures/Customer.php');
        // @todo Only tests that $whitelist=false doesn't trigger errors,
        // No constants are used, because by default only class constants in the whitelisted namespace are allowed and no class in Swagger\Annotation namespace has a constant.

        // Scanning without whitelisting causes issues, to check uncomment next.
        // $analyser->fromFile(__DIR__ . '/Fixtures/ThirdPartyAnnotations.php');
        Analyser::$whitelist = $backup;
    }

    public function testDefaultImports()
    {
        $backup = Analyser::$defaultImports;
        Analyser::$defaultImports = [
            'contact' => 'Swagger\Annotations\Contact', // use Swagger\Annotations\Contact;
            'ctest' => 'sWaGGerTests\ConstantsTesT' // use sWaGGerTests\ConstantsTesT as CTest;
        ];
        $annotations = $this->parseComment('@Contact(url=CTest::URL)');
        $this->assertSame('http://example.com', $annotations[0]->url);
        Analyser::$defaultImports = $backup;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Context;

class ContextTest extends SwaggerTestCase
{
    public function testDetect()
    {
        $context = Context::detect();
        $line = __LINE__ - 1;
        $this->assertSame('ContextTest', $context->class);
        $this->assertSame('\SwaggerTests\ContextTest', $context->fullyQualifiedName($context->class));
        $this->assertSame('testDetect', $context->method);
        $this->assertSame(__FILE__, $context->filename);
        $this->assertSame($line, $context->line);
        $this->assertSame('SwaggerTests', $context->namespace);
//        $this->assertCount(1, $context->uses); // Context::detect() doesn't pick up USE statements (yet)
    }

    public function testFullyQualifiedName()
    {
        $swagger = \Swagger\scan(__DIR__.'/Fixtures/Customer.php');
        $context = $swagger->definitions[0]->_context;
        // resolve with namespace
        $this->assertSame('\FullyQualified', $context->fullyQualifiedName('\FullyQualified'));
        $this->assertSame('\SwaggerFixures\Unqualified', $context->fullyQualifiedName('Unqualified'));
        $this->assertSame('\SwaggerFixures\Namespace\Qualified', $context->fullyQualifiedName('Namespace\Qualified'));
        // respect use statements
        $this->assertSame('\Exception', $context->fullyQualifiedName('Exception'));
        $this->assertSame('\SwaggerFixures\Customer', $context->fullyQualifiedName('Customer'));
        $this->assertSame('\Swagger\Logger', $context->fullyQualifiedName('Logger'));
        $this->assertSame('\Swagger\Logger', $context->fullyQualifiedName('lOgGeR')); // php has case-insensitive class names :-(
        $this->assertSame('\Swagger\Logger', $context->fullyQualifiedName('SwgLogger'));
        $this->assertSame('\Swagger\Annotations\QualifiedAlias', $context->fullyQualifiedName('SWG\QualifiedAlias'));
    }

    public function testPhpdocContent()
    {
        $singleLine = new Context(['comment' => <<<END
    /**
     * A single line.
     *
     * @SWG\Get(path="api/test1", @SWG\Response(response="200", description="a response"))
     */
END
        ]);
        $this->assertEquals('A single line.', $singleLine->phpdocContent());

        $multiline = new Context(['comment' => <<<END
/**
 * A description spread across
 * multiple lines.
 *           
 * even blank lines
 *
 * @SWG\Get(path="api/test1", @SWG\Response(response="200", description="a response"))
 */
END
        ]);
        $this->assertEquals("A description spread across\nmultiple lines.\n\neven blank lines", $multiline->phpdocContent());

        $escapedLinebreak = new Context(['comment' => <<<END
/**
 * A single line spread across \
 * multiple lines.
 *
 * @SWG\Get(path="api/test1", @SWG\Response(response="200", description="a response"))
 */
END
        ]);
        $this->assertEquals("A single line spread across multiple lines.", $escapedLinebreak->phpdocContent());
    }

    /**
     * https://phpdoc.org/docs/latest/guides/docblocks.html
     */
    public function testPhpdocSummaryAndDescription()
    {
        $single = new Context(['comment' => '/** This is a single line DocComment. */']);
        $this->assertEquals('This is a single line DocComment.', $single->phpdocContent());
        $multi = new Context(['comment' => "/**\n * This is a multi-line DocComment.\n */"]);
        $this->assertEquals('This is a multi-line DocComment.', $multi->phpdocContent());

        $emptyWhiteline = new Context(['comment' => <<<END
/**
 * This is a summary
 *
 * This is a description
 */
END
        ]);
        $this->assertEquals('This is a summary', $emptyWhiteline->phpdocSummary());
        $periodNewline = new Context(['comment' => <<<END
     /**
     * This is a summary.
     * This is a description
     */
END
        ]);
        $this->assertEquals('This is a summary.', $periodNewline->phpdocSummary());
        $multilineSummary = new Context(['comment' => <<<END
     /**
     * This is a summary
     * but this is part of the summary
     */
END
        ]);
    }
}
            <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

class ExamplesTest extends SwaggerTestCase
{

    /**
     * Test the processed Examples against json files in ExamplesOutput.
     *
     * @dataProvider getExamples
     * @param string $example Example path
     * @param string $output Expected output (path to a json file)
     */
    public function testExample($example, $output)
    {
        $swagger = \Swagger\scan(__DIR__ . '/../Examples/' . $example);
        $this->assertSwaggerEqualsFile(__DIR__ . '/ExamplesOutput/' . $output, $swagger);
    }

    /**
     * dataProvider for testExample
     * @return array
     */
    public function getExamples()
    {
        return [
            ['petstore.swagger.io', 'petstore.swagger.io.json'],
            ['swagger-spec/petstore', 'petstore.json'],
            ['swagger-spec/petstore-simple', 'petstore-simple.json'],
            ['swagger-spec/petstore-with-external-docs', 'petstore-with-external-docs.json'],
            ['using-refs', 'using-refs.json'],
            ['dynamic-reference', 'dynamic-reference.json'],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Annotations\Schema;

class HandleReferencesTest extends SwaggerTestCase
{
    public function testRef()
    {
        $swagger = \Swagger\scan(__DIR__ . '/Fixtures/DynamicReference.php');

        /** @var Schema $schema */
        $schema = $swagger->paths[0]->post->responses[0]->schema;
        $props = $schema->properties;

        $this->assertEquals('success', $props[0]->property, 'The @SWG\Schema should contain properties from the extended @SWG\Response');
        $this->assertEquals('data', $props[1]->property, 'The @SWG\Schema should contain properties from the extended @SWG\Response');
        $this->assertEquals('#/definitions/Product', $props[1]->ref, 'The @SWG\Schema should contain the original property from the child. This property will override the parent property from @SWG\Response');
        $this->assertEquals('errors', $props[2]->property, 'The @SWG\Schema should contain properties from the extended @SWG\Response');
        $this->assertEquals('token', $props[3]->property, 'The @SWG\Schema should contain properties from the extended @SWG\Response');
        $this->assertEquals('status', $props[4]->property, 'The @SWG\Schema should contain properties from the extended @SWG\Response');
        $this->assertEquals('test', $props[5]->property, 'The @SWG\Schema should contain properties from the extended @SWG\Response');
        $this->assertEquals