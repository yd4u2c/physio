INDX( 	 �|�             (   H  �       ���                �3     � l     �3     S��&qk� ��9` �i[���<�S��&qk�       �               C s v F i l e L o a d e r T e s t . p h p     �3     � r     �3     %��&qk� ��9` �i[���<�%��&qk�       N	               I c u D a t F i l e L o a d e r T e s t . p h p       �3     � r     �3     6��&qk� ��9` �¼���<�6��&qk�       2               I c u R e s F i l e L o a d e r T e s t . p h p       �3     � l     �3     �y�&qk� ��9` �!���< �y�&qk�       {               I n i F i l e L o a d e r T e s t . p h p     �3     � n     �3     |?�&qk� ��9` �!���<�|?�&qk�                      J s o n F i l e L o a d e r T e s t . p h p   �3     � l     �3     ���&qk� ��9` �p����<����&qk�                      L o c a l i z e d T e s t C a s e . p h p     �3     � j     �3     ��&qk� ��9` ������<���&qk�       �	               M o F i l e L o a d e r T e s t . p h p       �3     � l     �3     j��&qk� ��9` �AG���< j��&qk�                      P h p F i l e L o a d e r T e s t . p h p     �3     � j     �3     sQ�&qk� ��9` �AG���<�sQ�&qk�       }               P o F i l e L o a d e r T e s t . p h p       �3     � j     �3     �&qk� ��9` ������<��&qk�       �	               Q t F i l e L o a d e r T e s t . p h p       �3     � p     �3     ,=�&qk� ��9` ��
���<�,=�&qk� 0      U(               X l i f f F i l e L o a d e r T e s t . p h p �3     � n     �3     �d�&qk� ��9` ��
���< �d�&qk�       	               Y a m l F i l e L o a d e r T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Translation\Loader\MoFileLoader;

class MoFileLoaderTest extends TestCase
{
    public function testLoad()
    {
        $loader = new MoFileLoader();
        $resource = __DIR__.'/../fixtures/resources.mo';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $this->assertEquals(['foo' => 'bar'], $catalogue->all('domain1'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }

    public function testLoadPlurals()
    {
        $loader = new MoFileLoader();
        $resource = __DIR__.'/../fixtures/plurals.mo';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $this->assertEquals(['foo' => 'bar', 'foos' => '{0} bar|{1} bars'], $catalogue->all('domain1'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }

    /**
     * @expectedException \Symfony\Component\Translation\Exception\NotFoundResourceException
     */
    public function testLoadNonExistingResource()
    {
        $loader = new MoFileLoader();
        $resource = __DIR__.'/../fixtures/non-existing.mo';
        $loader->load($resource, 'en', 'domain1');
    }

    /**
     * @expectedException \Symfony\Component\Translation\Exception\InvalidResourceException
     */
    public function testLoadInvalidResource()
    {
        $loader = new MoFileLoader();
        $resource = __DIR__.'/../fixtures/empty.mo';
        $loader->load($resource, 'en', 'domain1');
    }

    public function testLoadEmptyTranslation()
    {
        $loader = new MoFileLoader();
        $resource = __DIR__.'/../fixtures/empty-translation.mo';
        $catalogue = $loader->load($resource, 'en', 'message');

        $this->assertEquals([], $catalogue->all('message'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Translation\Loader\PhpFileLoader;

class PhpFileLoaderTest extends TestCase
{
    public function testLoad()
    {
        $loader = new PhpFileLoader();
        $resource = __DIR__.'/../fixtures/resources.php';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $this->assertEquals(['foo' => 'bar'], $catalogue->all('domain1'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }

    /**
     * @expectedException \Symfony\Component\Translation\Exception\NotFoundResourceException
     */
    public function testLoadNonExistingResource()
    {
        $loader = new PhpFileLoader();
        $resource = __DIR__.'/../fixtures/non-existing.php';
        $loader->load($resource, 'en', 'domain1');
    }

    /**
     * @expectedException \Symfony\Component\Translation\Exception\InvalidResourceException
     */
    public function testLoadThrowsAnExceptionIfFileNotLocal()
    {
        $loader = new PhpFileLoader();
        $resource = 'http://example.com/resources.php';
        $loader->load($resource, 'en', 'domain1');
    }
}
                                                    