      $res = GeneratorFieldsInputUtil::prepareValuesArrayStr($arr);
        $expected = '[\'A\', \'B\', \'C\']';

        $this->assertEquals($expected, $res);
    }

    public function testKeyValueArrFromLabelValueStr()
    {
        $arr = ['A', 'B', 'C'];

        $res = GeneratorFieldsInputUtil::prepareKeyValueArrFromLabelValueStr($arr);
        $expected = ['A' => 'A', 'B' => 'B', 'C' => 'C'];

        $this->assertEquals($expected, $res);

        $arr = ['A:aa', 'B:bb', 'C:cc'];

        $res = GeneratorFieldsInputUtil::prepareKeyValueArrFromLabelValueStr($arr);
        $expected = ['A' => 'aa', 'B' => 'bb', 'C' => 'cc'];

        $this->assertEquals($expected, $res);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace Tests\Utils;

use InfyOm\Generator\Utils\ResponseUtil;
use PHPUnit_Framework_TestCase;

class ResponseUtilTest extends PHPUnit_Framework_TestCase
{
    public function testMakeResponse()
    {
        $message = 'Data Received';
        $data = ['field' => 'value'];

        $response = ResponseUtil::makeResponse($message, $data);

        $this->assertTrue($response['success']);
        $this->assertEquals($message, $response['message']);
        $this->assertEquals($data, $response['data']);
    }

    public function testMakeError()
    {
        $message = 'Error Occurred';

        $response = ResponseUtil::makeError($message);

        $this->assertFalse($response['success']);
        $this->assertEquals($message, $response['message']);
        $this->assertArrayNotHasKey('data', $response);
    }

    public function testMakeErrorWithGivenData()
    {
        $message = 'Error Occurred';
        $data = ['code' => '404', 'line' => 20];

        $response = ResponseUtil::makeError($message, $data);

        $this->assertFalse($response['success']);
        $this->assertEquals($message, $response['message']);
        $this->assertEquals($data, $response['data']);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    The MIT License (MIT)

Copyright (c) 2016 InfyOm Labs

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            