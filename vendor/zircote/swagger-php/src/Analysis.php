<?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

class AbstractAnnotationTest extends SwaggerTestCase
{
    public function testVendorFields()
    {
        $annotations = $this->parseComment('@SWG\Get(x={"internal-id": 123})');
        $output = $annotations[0]->jsonSerialize();
        $prefixedProperty = 'x-internal-id';
        $this->assertSame(123, $output->$prefixedProperty);
    }

    public function testInvalidField()
    {
        $this->assertSwaggerLogEntryStartsWith('Unexpected field "doesnot" for @SWG\Get(), expecting');
        $this->parseComment('@SWG\Get(doesnot="exist")');
    }

    public function testUmergedAnnotation()
    {
        $swagger = $this->createSwaggerWithInfo();
        $swagger->merge($this->parseComment('@SWG\Items()'));
        $this->assertSwaggerLogEntryStartsWith('Unexpected @SWG\Items(), expected to be inside @SWG\\');
        $swagger->validate();
    }

    public function testConflictedNesting()
    {
        $comment = <<<END
@SWG\Info(
    title="Info only has one contact field..",
    version="test",
    @SWG\Contact(name="first"),
    @SWG\Contact(name="second")
)
END;
        $annotations = $this->parseComment($comment);
        $this->assertSwaggerLogEntryStartsWith('Only one @SWG\Contact() allowed for @SWG\Info() multiple found in:');
        $annotations[0]->validate();
    }

    public function testKey()
    {
        $comment = <<<END
@SWG\Response(
    @SWG\Header(header="X-CSRF-Token",description="Token to prevent Cross Site Request Forgery")
)
END;
        $annotations = $this->parseComment($comment);
        $this->assertEquals('{"headers":{"X-CSRF-Token":{"description":"Token to prevent Cross Site Request Forgery"}}}', json_encode($annotations[0]));
    }

    public function testConflictingKey()
    {
        $comment = <<<END
@SWG\Response(
    description="The headers in response must have unique header values",
    @SWG\Header(header="X-CSRF-Token", type="string", description="first"),
    @SWG\Header(header="X-CSRF-Token", type="string", description="second")
)
END;
        $annotations = $this->parseComment($comment);
        $this->assertSwaggerLogEntryStartsWith('Multiple @SWG\Header() with the same header="X-CSRF-Token":');
        $annotations[0]->validate();
    }

    public function testRequiredFields()
    {
        $annotations = $this->parseComment('@SWG\Info()');
        $info = $annotations[0];
        $this->assertSwaggerLogEntryStartsWith('Missing required field "title" for @SWG\Info() in ');
        $this->assertSwaggerLogEntryStartsWith('Missing required field "version" for @SWG\Info() in ');
        $info->validate();
    }

    public function testTypeValidation()
    {
        $comment = <<<END
@SWG\Parameter(
    name=123,
    type="strig",
    in="dunno",
    required="maybe",
    maximum="twentytwo"
)
END;
        $annotations = $this->parseComment($comment);
        $parameter = $annotations[0];
        $this->assertSwaggerLogEntryStartsWith('@SWG\Parameter(name=123,in="dunno")->name is a "integer", expecting a "string" in ');
        $this->assertSwaggerLogEntryStartsWith('@SWG\Parameter(name=123,in="dunno")->in "dunno" is invalid, expecting "query", "header", "path", "formData", "body" in ');
        $this->assertSwaggerLogEntryStartsWith('@SWG\Parameter(name=123,in="dunno")->required is a "string", expecting a "boolean" in ');
        $this->assertSwaggerLogEntryStartsWith('@SWG\Parameter(name=123,in="dunno")->maximum is a "string", expecting a "number" in ');
        $this->assertSwaggerLogEntryStartsWith('@SWG\Parameter(name=123,in="dunno")->type must be "string", "number", "integer", "boolean", "array", "file" when @SWG\Parameter()->in != "body" in ');
        $parameter->validate();
    }
}
                                                                                                                                                                                                                                                                                                                                    <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Context;
use Swagger\Analyser;

class AnalyserTest extends SwaggerTestCase
{
    public function testParseContents()
    {
        $annotations = $this->parseComment('@SWG\Parameter(description="This is my parameter")');
        $this->assertInternalType('array', $annotations);
        $parameter = $annotations[0];
        $this->assertInstanceOf('Swagger\Annotations\Parameter', $parameter);
        $this->assertSame('This is my parameter', $parameter->description);
    }

    public function testDeprecatedAnnotationWarning()
    {
        $this->assertSwaggerLogEntryStartsWith('The annotation @SWG\\Resource() is deprecated.');
        $annotations = $this->parseComment('@SWG\Resource()');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

use Swagger\Analysis;
use Swagger\StaticAnalyser;

class AnalysisTest extends SwaggerTestCase
{
    public function testRegisterProcessor()
    {
        $counter = 0;
        $analysis = new Analysis();
        $analysis->process();
        $this->assertSame(0, $counter);
        $countProcessor = function (Analysis $a) use (&$counter) {
            $counter++;
        };
        Analysis::registerProcessor($countProcessor);
        $analysis->process();
        $this->assertSame(1, $counter);
        Analysis::unregisterProcessor($countProcessor);
        $analysis->process();
        $this->assertSame(1, $counter);
    }
    
    public function testGetSubclasses()
    {
        $analyser = new StaticAnalyser();
        $analysis = $analyser->fromFile(__DIR__ . '/Fixtures/Child.php');
        $analysis->addAnalysis($analyser->fromFile(__DIR__ . '/Fixtures/GrandAncestor.php'));
        $analysis->addAnalysis($analyser->fromFile(__DIR__ . '/Fixtures/Ancestor.php'));
        
        $this->assertCount(3, $analysis->classes, '3 classes should\'ve been detected');
        
        $subclasses = $analysis->getSubClasses('\SwaggerFixtures\GrandAncestor');
        $this->assertCount(2, $subclasses, 'GrandAncestor has 2 subclasses');
        $this->assertSame(['\SwaggerFixtures\Ancestor', '\AnotherNamespace\Child'], array_keys($subclasses));
        $this->assertSame(['\AnotherNamespace\Child'], array_keys($analysis->getSubClasses('\SwaggerFixtures\Ancestor')));
    }
    
    public function testGetAncestorClasses()
    {
        $analyser = new StaticAnalyser();
        $analysis = $analyser->fromFile(__DIR__ . '/Fixtures/Child.php');
        $analysis->addAnalysis($analyser->fromFile(__DIR__ . '/Fixtures