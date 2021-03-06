nTraceWithArgs()
    {
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped('Not supported in HHVM since it detects errors differently');
        }

        // This happens i.e. in React promises or Guzzle streams where stream wrappers are registered
        // and no file or line are included in the trace because it's treated as internal function
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            // This will contain $resource and $wrappedResource as arguments in the trace item
            $resource = fopen('php://memory', 'rw+');
            fwrite($resource, 'test_resource');
            $wrappedResource = new TestFooNorm;
            $wrappedResource->foo = $resource;
            // Just do something stupid with a resource/wrapped resource as argument
            array_keys($wrappedResource);
        } catch (\Exception $e) {
            restore_error_handler();
        }

        $formatter = new NormalizerFormatter();
        $record = array('context' => array('exception' => $e));
        $result = $formatter->format($record);

        $this->assertRegExp(
            '%"resource":"\[resource\] \(stream\)"%',
            $result['context']['exception']['trace'][0]
        );

        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            $pattern = '%"wrappedResource":"\[object\] \(Monolog\\\\\\\\Formatter\\\\\\\\TestFooNorm: \)"%';
        } else {
            $pattern = '%\\\\"foo\\\\":null%';
        }

        // Tests that the wrapped resource is ignored while encoding, only works for PHP <= 5.4
        $this->assertRegExp(
            $pattern,
            $result['context']['exception']['trace'][0]
        );
    }

    public function testExceptionTraceDoesNotLeakCallUserFuncArgs()
    {
        try {
            $arg = new TestInfoLeak;
            call_user_func(array($this, 'throwHelper'), $arg, $dt = new \DateTime());
        } catch (\Exception $e) {
        }

        $formatter = new NormalizerFormatter();
        $record = array('context' => array('exception' => $e));
        $result = $formatter->format($record);

        $this->assertSame(
            '{"function":"throwHelper","class":"Monolog\\\\Formatter\\\\NormalizerFormatterTest","type":"->","args":["[object] (Monolog\\\\Formatter\\\\TestInfoLeak)","'.$dt->format('Y-m-d H:i:s').'"]}',
            $result['context']['exception']['trace'][0]
        );
    }

    private function throwHelper($arg)
    {
        throw new \RuntimeException('Thrown');
    }
}

class TestFooNorm
{
    public $foo = 'foo';
}

class TestBarNorm
{
    public function __toString()
    {
        return 'bar';
    }
}

class TestStreamFoo
{
    public $foo;
    public $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
        $this->foo = 'BAR';
    }

    public function __toString()
    {
        fseek($this->resource, 0);

        return $this->foo . ' - ' . (string) stream_get_contents($this->resource);
    }
}

class TestToStringError
{
    public function __toString()
    {
        throw new \RuntimeException('Could not convert to string');
    }
}

class TestInfoLeak
{
    public function __toString()
    {
        return 'Sensitive information';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Formatter;

class ScalarFormatterTest extends \PHPUnit_Framework_TestCase
{
    private $formatter;

    public function setUp()
    {
        $this->formatter = new ScalarFormatter();
    }

    public function buildTrace(\Exception $e)
    {
        $data = array();
        $trace = $e->getTrace();
        foreach ($trace as $frame) {
            if (isset($frame['file'])) {
                $data[] = $frame['file'].':'.$frame['line'];
            } else {
                $data[] = json_encode($frame);
            }
        }

        return $data;
    }

    public function encodeJson($data)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return json_