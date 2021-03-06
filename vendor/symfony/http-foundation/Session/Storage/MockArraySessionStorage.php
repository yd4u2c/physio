', HeaderUtils::unquote('"foo bar"'));
        $this->assertEquals('foo [bar]', HeaderUtils::unquote('"foo [bar]"'));
        $this->assertEquals('foo "bar"', HeaderUtils::unquote('"foo \"bar\""'));
        $this->assertEquals('foo "bar"', HeaderUtils::unquote('"foo \"\b\a\r\""'));
        $this->assertEquals('foo \\ bar', HeaderUtils::unquote('"foo \\\\ bar"'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeDispositionInvalidDisposition()
    {
        HeaderUtils::makeDisposition('invalid', 'foo.html');
    }

    /**
     * @dataProvider provideMakeDisposition
     */
    public function testMakeDisposition($disposition, $filename, $filenameFallback, $expected)
    {
        $this->assertEquals($expected, HeaderUtils::makeDisposition($disposition, $filename, $filenameFallback));
    }

    public function provideMakeDisposition()
    {
        return [
            ['attachment', 'foo.html', 'foo.html', 'attachment; filename=foo.html'],
            ['attachment', 'foo.html', '', 'attachment; filename=foo.html'],
            ['attachment', 'foo bar.html', '', 'attachment; filename="foo bar.html"'],
            ['attachment', 'foo "bar".html', '', 'attachment; filename="foo \\"bar\\".html"'],
            ['attachment', 'foo%20bar.html', 'foo bar.html', 'attachment; filename="foo bar.html"; filename*=utf-8\'\'foo%2520bar.html'],
            ['attachment', 'föö.html', 'foo.html', 'attachment; filename=foo.html; filename*=utf-8\'\'f%C3%B6%C3%B6.html'],
        ];
    }

    /**
     * @dataProvider provideMakeDispositionFail
     * @expectedException \InvalidArgumentException
     */
    public function testMakeDispositionFail($disposition, $filename)
    {
        HeaderUtils::makeDisposition($disposition, $filename);
    }

    public function provideMakeDispositionFail()
    {
        return [
            ['attachment', 'foo%20bar.html'],
            ['attachment', 'foo/bar.html'],
            ['attachment', '/foo.html'],
            ['attachment', 'foo\bar.html'],
            ['attachment', '\foo.html'],
            ['attachment', 'föö.html'],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\IpUtils;

class IpUtilsTest extends TestCase
{
    /**
     * @dataProvider getIpv4Data
     */
    public function testIpv4($matches, $remoteAddr, $cidr)
    {
        $this->assertSame($matches, IpUtils::checkIp($remoteAddr, $cidr));
    }

    public function getIpv4Data()
    {
        return [
            [true, '192.168.1.1', '192.168.1.1'],
            [true, '192.168.1.1', '192.168.1.1/1'],
            [true, '192.168.1.1', '192.168.1.0/24'],
            [false, '192.168.1.1', '1.2.3.4/1'],
            [false, '192.168.1.1', '192.168.1.1/33'], // invalid subnet
            [true, '192.168.1.1', ['1.2.3.4/1', '192.168.1.0