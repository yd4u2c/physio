<?php
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PharIo\Manifest;

use DOMElement;
use DOMNodeList;

class ManifestElement {
    const XMLNS = 'https://phar.io/xml/manifest/1.0';

    /**
     * @var DOMElement
     */
    private $element;

    /**
     * ContainsElement constructor.
     *
     * @param DOMElement $element
     */
    public function __construct(DOMElement $element) {
        $this->element = $element;
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws ManifestElementException
     */
    protected function getAttributeValue($name) {
        if (!$this->element->hasAttribute($name)) {
            throw new ManifestElementException(
                sprintf(
                    'Attribute %s not set on element %s',
                    $name,
                    $this->element->localName
                )
            );
        }

        return $this->element->getAttribute($name);
    }

    /**
     * @param $elementName
     *
     * @return DOMElement
     *
     * @throws ManifestElementException
     */
    protected function getChildByName($elementName) {
        $element = $this->element->getElementsByTagNameNS(self::XMLNS, $elementName)->item(0);

        if (!$element instanceof DOMElement) {
            throw new ManifestElementException(
                sprintf('Element %s missing', $elementName)
            );
        }

        return $element;
    }

    /**
     * @param $elementName
     *
     * @return DOMNodeList
     *
     * @throws ManifestElementException
     */
    protected function getChildrenByName($elementName) {
        $elementList = $this->element->getElementsByTagNameNS(self::XMLNS, $elementName);

        if ($elementList->length === 0) {
            throw new ManifestElementException(
                sprintf('Element(s) %s missing', $elementName)
            );
        }

        return $elementList;
    }

    /**
     * @param string $elementName
     *
     * @return bool
     */
    protected function hasChild($elementName) {
        return $this->element->getElementsByTagNameNS(self::XMLNS, $elementName)->length !== 0;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace PharIo\Manifest;

/**
 * @covers \PharIo\Manifest\ManifestDocumentMapper
 *
 * @uses \PharIo\Manifest\ApplicationName
 * @uses \PharIo\Manifest\Author
 * @uses \PharIo\Manifest\AuthorCollection
 * @uses \PharIo\Manifest\AuthorCollectionIterator
 * @uses \PharIo\Manifest\AuthorElement
 * @uses \PharIo\Manifest\AuthorElementCollection
 * @uses \PharIo\Manifest\BundledComponent
 * @uses \PharIo\Manifest\BundledComponentCollection
 * @uses \PharIo\Manifest\BundledComponentCollectionIterator
 * @uses \PharIo\Manifest\BundlesElement
 * @uses \PharIo\Manifest\ComponentElement
 * @uses \PharIo\Manifest\ComponentElementCollection
 * @uses \PharIo\Manifest\ContainsElement
 * @uses \PharIo\Manifest\CopyrightElement
 * @uses \PharIo\Manifest\CopyrightInformation
 * @uses \PharIo\Manifest\ElementCollection
 * @uses \PharIo\Manifest\Email
 * @uses \PharIo\Manifest\ExtElement
 * @uses \PharIo\Manifest\ExtElementCollection
 * @uses \PharIo\Manifest\License
 * @uses \PharIo\Manifest\LicenseElement
 * @uses \PharIo\Manifest\Manifest
 * @uses \PharIo\Manifest\ManifestDocument
 * @uses \PharIo\Manifest\ManifestDocumentMapper
 * @uses \PharIo\Manifest\ManifestElement
 * @uses \PharIo\Manifest\ManifestLoader
 * @uses \PharIo\Manifest\PhpElement
 * @uses \PharIo\Manifest\PhpExtensionRequirement
 * @uses \PharIo\Manifest\PhpVersionRequirement
 * @uses \PharIo\Manifest\RequirementCollection
 * @uses \PharIo\Manifest\RequirementCollectionIterator
 * @uses \PharIo\Manifest\RequiresElement
 * @uses \PharIo\Manifest\Type
 * @uses \PharIo\Manifest\Url
 * @uses \PharIo\Version\Version
 * @uses \PharIo\Version\VersionConstraint
 */
class ManifestDocumentMapperTest extends \PHPUnit\Framework\TestCase {
    /**
     * @dataProvider dataProvider
     *
     * @param $expected
     *
     * @uses         \PharIo\Manifest\Application
     * @uses         \PharIo\Manifest\ApplicationName
     * @uses         \PharIo\Manifest\Library
     * @uses         \PharIo\Manifest\Extension
     * @uses         \PharIo\Manifest\ExtensionElement
     */
    public function testCanSerializeToString($expected) {
        $manifestDocument = ManifestDocument::fromFile($expected);
        $mapper           = new ManifestDocumentMapper();

        $this->assertInstanceOf(
            Manifest::class,
            $mapper->map($manifestDocument)
        );
    }

    public function dataProvider() {
        return [
            'application' => [__DIR__ . '/_fixture/phpunit-5.6.5.xml'],
            'library'     => [__DIR__ . '/_fixture/library.xml'],
            'extension'   => [__DIR__ . '/_fixture/extension.xml']
        ];
    }

    public function testThrowsExceptionOnUnsupportedType() {
        $manifestDocument = ManifestDocument::fromFile(__DIR__ . '/_fixture/custom.xml');
        $mapper           = new ManifestDocumentMapper();

        $this->expectException(ManifestDocumentMapperException::class);
        $mapper->map($manifestDocument);
    }

    public function testInvalidVersionInformationThrowsException() {
        $manifestDocument = ManifestDocument::fromFile(__DIR__ . '/_fixture/invalidversion.xml');
        $mapper           = new ManifestDocumentMapper();

        $this->expectException(ManifestDocumentMapperException::class);
        $mapper->map($manifestDocument);
    }

    public function testInvalidVersionConstraintThrowsException() {
        $manifestDocument = ManifestDocument::fromFile(__DIR__ . '/_fixture/invalidversionconstraint.xml');
        $mapper           = new ManifestDocumentMapper();

        $this->expectException(ManifestDocumentMapperException::class);
        $mapper->map($manifestDocument);
    }

    /**
     * @uses \PharIo\Manifest\ExtensionElement
     */
    public function testInvalidCompatibleConstraintThrowsException() {
        $manifestDocument = ManifestDocument::fromFile(__DIR__ . '/_fixture/extension-invalidcompatible.xml');
        $mapper           = new ManifestDocumentMapper();

        $this->expectException(ManifestDocumentMapperException::class);
        $mapper->map($manifestDocument);
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace PharIo\Manifest;

/**
 * @covers \PharIo\Manifest\ManifestLoader
 *
 * @uses \PharIo\Manifest\Author
 * @uses \PharIo\Manifest\AuthorCollection
 * @uses \PharIo\Manifest\AuthorCollectionIterator
 * @uses \PharIo\Manifest\AuthorElement
 * @uses \PharIo\Manifest\AuthorElementCollection
 * @uses \PharIo\Manifest\ApplicationName
 * @uses \PharIo\Manifest\BundledComponent
 * @uses \PharIo\Manifest\BundledComponentCollection
 * @uses \PharIo\Manifest\BundledComponentCollectionIterator
 * @uses \PharIo\Manifest\BundlesElement
 * @uses \PharIo\Manifest\ComponentElement
 * @uses \PharIo\Manifest\ComponentElementCollection
 * @uses \PharIo\Manifest\ContainsElement
 * @uses \PharIo\Manifest\CopyrightElement
 * @uses \PharIo\Manifest\CopyrightInformation
 * @uses \PharIo\Manifest\ElementCollection
 * @uses \PharIo\Manifest\Email
 * @uses \PharIo\Manifest\ExtElement
 * @uses \PharIo\Manifest\ExtElementCollection
 * @uses \PharIo\Manifest\License
 * @uses \PharIo\Manifest\LicenseElement
 * @uses \PharIo\Manifest\Manifest
 * @uses \PharIo\Manifest\ManifestDocument
 * @uses \PharIo\Manifest\ManifestDocumentMapper
 * @uses \PharIo\Manifest\ManifestElement
 * @uses \PharIo\Manifest\ManifestLoader
 * @uses \PharIo\Manifest\PhpElement
 * @uses \PharIo\Manifest\PhpExtensionRequirement
 * @uses \PharIo\Manifest\PhpVersionRequirement
 * @uses \PharIo\Manifest\RequirementCollection
 * @uses \PharIo\Manifest\RequirementCollectionIterator
 * @uses \PharIo\Manifest\RequiresElement
 * @uses \PharIo\Manifest\Type
 * @uses \PharIo\Manifest\Url
 * @uses \PharIo\Version\Version
 * @uses \PharIo\Version\VersionConstraint
 */
class ManifestLoaderTest extends \PHPUnit\Framework\TestCase {
    public function testCanBeLoadedFromFile() {
        $this->assertInstanceOf(
            Manifest::class,
            ManifestLoader::fromFile(__DIR__ . '/_fixture/library.xml')
        );
    }

    public function testCanBeLoadedFromString() {
        $this->assertInstanceOf(
            Manifest::class,
            ManifestLoader::fromString(
                file_get_contents(__DIR__ . '/_fixture/library.xml')
            )
        );
    }

    public function testCanBeLoadedFromPhar() {
        $this->assertInstanceOf(
            Manifest::class,
            ManifestLoader::fromPhar(__DIR__ . '/_fixture/test.phar')
        );

    }

    public function testLoadingNonExistingFileThrowsException() {
        $this->expectException(ManifestLoaderException::class);
        ManifestLoader::fromFile('/not/existing');
    }

    /**
     * @uses \PharIo\Manifest\ManifestDocumentLoadingException
     */
    public function testLoadingInvalidXmlThrowsException() {
        $this->expectException(ManifestLoaderException::class);
        ManifestLoader::fromString('<?xml version="1.0" ?><broken>');
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace PharIo\Manifest;

use PharIo\Version\Version;

/**
 * @covers \PharIo\Manifest\ManifestSerializer
 *
 * @uses \PharIo\Manifest\ApplicationName
 * @uses \PharIo\Manifest\Author
 * @uses \PharIo\Manifest\AuthorCollection
 * @uses \PharIo\Manifest\AuthorCollectionIterator
 * @uses \PharIo\Manifest\AuthorElement
 * @uses \PharIo\Manifest\AuthorElementCollection
 * @uses \PharIo\Manifest\BundledComponent
 * @uses \PharIo\Manifest\BundledComponentCollection
 * @uses \PharIo\Manifest\BundledComponentCollectionIterator
 * @uses \PharIo\Manifest\BundlesElement
 * @uses \PharIo\Manifest\ComponentElement
 * @uses \PharIo\Manifest\ComponentElementCollection
 * @uses \PharIo\Manifest\ContainsElement
 * @uses \PharIo\Manifest\CopyrightElement
 * @uses \PharIo\Manifest\CopyrightInformation
 * @uses \PharIo\Manifest\ElementCollection
 * @uses \PharIo\Manifest\Email
 * @uses \PharIo\Manifest\ExtElement
 * @uses \PharIo\Manifest\ExtElementCollection
 * @uses \PharIo\Manifest\License
 * @uses \PharIo\Manifest\LicenseElement
 * @uses \PharIo\Manifest\Manifest
 * @uses \PharIo\Manifest\ManifestDocument
 * @uses \PharIo\Manifest\ManifestDocumentMapper
 * @uses \PharIo\Manifest\ManifestElement
 * @uses \PharIo\Manifest\ManifestLoader
 * @uses \PharIo\Manifest\PhpElement
 * @uses \PharIo\Manifest\PhpExtensionRequirement
 * @uses \PharIo\Manifest\PhpVersionRequirement
 * @uses \PharIo\Manifest\RequirementCollection
 * @uses \PharIo\Manifest\RequirementCollectionIterator
 * @uses \PharIo\Manifest\RequiresElement
 * @uses \PharIo\Manifest\Type
 * @uses \PharIo\Manifest\Url
 * @uses \PharIo\Version\Version
 * @uses \PharIo\Version\VersionConstraint
 */
class ManifestSerializerTest extends \PHPUnit\Framework\TestCase {
    /**
     * @dataProvider dataProvider
     *
     * @param $expected
     *
     * @uses \PharIo\Manifest\Application
     * @uses \PharIo\Manifest\Library
     * @uses \PharIo\Manifest\Extension
     * @uses \PharIo\Manifest\ExtensionElement
     */
    public function testCanSerializeToString($expected) {
        $manifest = ManifestLoader::fromString($expected);

        $serializer = new ManifestSerializer();

        $this->assertXmlStringEqualsXmlString(
            $expected,
            $serializer->serializeToString($manifest)
        );
    }

    public function dataProvider() {
        return [
            'application' => [file_get_contents(__DIR__ . '/_fixture/phpunit-5.6.5.xml')],
            'library'     => [file_get_contents(__DIR__ . '/_fixture/library.xml')],
            'extension'   => [file_get_contents(__DIR__ . '/_fixture/extension.xml')]
        ];
    }

    /**
     * @uses \PharIo\Manifest\Library
     * @uses \PharIo\Manifest\ApplicationName
     */
    public function testCanSerializeToFile() {
        $src        = __DIR__ . '/_fixture/library.xml';
        $dest       = '/tmp/' . uniqid('serializer', true);
        $manifest   = ManifestLoader::fromFile($src);
        $serializer = new ManifestSerializer();
        $serializer->serializeToFile($manifest, $dest);
        $this->assertXmlFileEqualsXmlFile($src, $dest);
        unlink($dest);
    }

    /**
     * @uses \PharIo\Manifest\ApplicationName
     */
    public function testCanHandleUnknownType() {
        $type     = $this->getMockForAbstractClass(Type::class);
        $manifest = new Manifest(
            new ApplicationName('testvendor/testname'),
            new Version('1.0.0'),
            $type,
            new CopyrightInformation(
                new AuthorCollection(),
                new License('bsd-3', new Url('https://some/uri'))
            ),
            new RequirementCollection(),
            new BundledComponentCollection()
        );

        $serializer = new ManifestSerializer();
        $this->assertXmlStringEqualsXmlFile(
            __DIR__ . '/_fixture/custom.xml',
            $serializer->serializeToString($manifest)
        );
    }
}
                                                                                                                                                                     <?php
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PharIo\Manifest;

use PHPUnit\Framework\TestCase;

class ApplicationNameTest extends TestCase {

    public function testCanBeCreatedWithValidName() {
        $this->assertInstanceOf(
            ApplicationName::class,
            new ApplicationName('foo/bar')
        );
    }

    public function testUsingInvalidFormatForNameThrowsException() {
        $this->expectException(InvalidApplicationNameException::class);
        $this->expectExceptionCode(InvalidApplicationNameException::InvalidFormat);
        new ApplicationName('foo');
    }

    public function testUsingWrongTypeForNameThrowsException() {
        $this->expectException(InvalidApplicationNameException::class);
        $this->expectExceptionCode(InvalidApplicationNameException::NotAString);
        new ApplicationName(123);
    }

    public function testReturnsTrueForEqualNamesWhenCompared() {
        $app = new ApplicationName('foo/bar');
        $this->assertTrue(
            $app->isEqual($app)
        );
    }

    public function testReturnsFalseForNonEqualNamesWhenCompared() {
        $app1 = new ApplicationName('foo/bar');
        $app2 = new ApplicationName('foo/foo');
        $this->assertFalse(
            $app1->isEqual($app2)
        );
    }

    public function testCanBeConvertedToString() {
        $this->assertEquals(
            'foo/bar',
            new ApplicationName('foo/bar')
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PharIo\Manifest;

use PHPUnit\Framework\TestCase;

/**
 * @covers PharIo\Manifest\Application
 * @covers PharIo\Manifest\Type
 */
class ApplicationTest extends TestCase {
    /**
     * @var Application
     */
    private $type;

    protected function setUp() {
        $this->type = Type::application();
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(Application::class, $this->type);
    }

    public function testIsApplication() {
        $this->assertTrue($this->type->isApplication());
    }

    public function testIsNotLibrary() {
        $this->assertFalse($this->type->isLibrary());
    }

    public function testIsNotExtension() {
        $this->assertFalse($this->type->isExtension());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PharIo\Manifest;

use PHPUnit\Framework\TestCase;

/**
 * @covers \PharIo\Manifest\AuthorCollection
 * @covers \PharIo\Manifest\AuthorCollectionIterator
 *
 * @uses \PharIo\Manifest\Author
 * @uses \PharIo\Manifest\Email
 */
class AuthorCollectionTest extends TestCase {
    /**
     * @var AuthorCollection
     */
    private $collection;

    /**
     * @var Author
     */
    private $item;

    protected function setUp() {
        $this->collection = new AuthorCollection;
        $this->item       = new Author('Joe Developer', new Email('user@example.com'));
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(AuthorCollection::class, $this->collection);
    }

    public function testCanBeCounted() {
        $this->collection->add($this->item);

        $this->assertCount(1, $this->collection);
    }

    public function testCanBeIterated() {
        $this->collection->add(
            new Author('Dummy First', new Email('dummy@example.com'))
        );
        $this->collection->add($this->item);
        $this->assertContains($this->item, $this->collection);
    }

    public function testKeyPositionCanBeRetreived() {
        $this->collection->add($this->item);
        foreach($this->collection as $key => $item) {
            $this->assertEquals(0, $key);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PharIo\Manifest;

use PHPUnit\Framework\TestCase;

/**
 * @covers PharIo\Manifest\Author
 *
 * @uses PharIo\Manifest\Email
 */
class AuthorTest extends TestCase {
    /**
     * @var Author
     */
    private $author;

    protected function setUp() {
        $this->author = new Author('Joe Developer', new Email('user@example.com'));
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(Author::class, $this->author);
    }

    public function testNameCanBeRetrieved() {
        $this->assertEquals('Joe Developer', $this->author->getName());
    }

    public function testEmailCanBeRetrieved() {
        $this->assertEquals('user@example.com', $this->author->getEmail());
    }

    public function testCanBeUsedAsString() {
        $this->assertEquals('Joe Developer <user@example.com>', $this->author);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         