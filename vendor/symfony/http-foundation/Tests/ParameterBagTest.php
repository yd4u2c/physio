INDX( 	 �1�             (   �  �                             1/     x d     0/     ̂j�pk� ;n< ������<�̂j�pk�                       . u n k n o w n e x t e n s i o n     2/     � |     0/     ̂j�pk� ;n< ������<�̂j�pk�        �               c a s e - s e n s i t i v e - m i m e - t y p e . x l s m     6/     h T     0/     �Fo�pk���*� %��Fo�pk��Fo�pk�                       	 d i r e c t o r y e . 3/     x f     0/     ��l�pk� ;n< ������<���l�pk�                        o t h e r - f i l e . e x a m p l e   4/     ` J     0/     ��l�pk� ;n< ������<���l�pk�(       #                t e s t       5/     h R     0/     �Fo�pk� ;n< �\���<��Fo�pk�(       #                t e s t . g i f                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\File\MimeType;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\MimeType\FileBinaryMimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

/**
 * @requires extension fileinfo
 */
class MimeTypeTest extends TestCase
{
    protected $path;

    public function testGuessImageWithoutExtension()
    {
        $this->assertEquals('image/gif', MimeTypeGuesser::getInstance()->guess(__DIR__.'/../Fixtures/test'));
    }

    public function testGuessImageWithDirectory()
    {
        $this->{method_exists($this, $_ = 'expectException') ? $_ : 'setExpectedException'}('Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException');

        MimeTypeGuesser::getInstance()->guess(__DIR__.'/../Fixtures/directory');
    }

    public function testGuessImageWithFileBinaryMimeTypeGuesser()
    {
        $guesser = MimeTypeGuesser::getInstance();
        $guesser->register(new FileBinaryMimeTypeGuesser());
        $this->assertEquals('image/gif', MimeTypeGuesser::getInstance()->guess(__DIR__.'/../Fixtures/test'));
    }

    public function testGuessImageWithKnownExtension()
    {
        $this->assertEquals('image/gif', MimeTypeGuesser::getInstance()->guess(__DIR__.'/../Fixtures/test.gif'));
    }

    public function testGuessFileWithUnknownExtension()
    {
        $this->assertEquals('application/octet-stream', MimeTypeGuesser::getInstance()->guess(__DIR__.'/../Fixtures/.unknownextension'));
    }

    public function testGuessWithIncorrectPath()
    {
        $this->{method_exists($this, $_ = 'expectException') ? $_ : 'setExpectedException'}('Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException');
        MimeTypeGuesser::getInstance()->guess(__DIR__.'/../Fixtures/not_here');
    }

    public function testGuessWithNonReadablePath()
    {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('Can not verify chmod operations on Windows');
        }

        if (!getenv('USER') || 'root' === getenv('USER')) {
            $this->markTestSkipped('This test will fail if run under superuser');
        }

        $path = __DIR__.'/../Fixtures/to_delete';
        touch($path);
        @chmod($path, 0333);

        if ('0333' == substr(sprintf('%o', fileperms($path)), -4)) {
            $this->{method_exists($this, $_ = 'expectException') ? $_ : 'setExpectedException'}('Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException');
            MimeTypeGuesser::getInstance()->guess($path);
        } else {
            $this->markTestSkipped('Can not verify chmod operations, change of file permissions failed');
        }
    }

    public static function tearDownAfterClass()
    {
        $path = __DIR__.'/../Fixtures/to_delete';
        if (file_exists($path)) {
            @chmod($path, 0666);
            @unlink($path);
        }
