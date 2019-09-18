<?php

namespace PharIo\Manifest;

use DOMDocument;

class CopyrightElementTest extends \PHPUnit\Framework\TestCase {
    /**
     * @var DOMDocument
     */
    private $dom;

    /**
     * @var CopyrightElement
     */
    private $copyright;

    protected function setUp() {
        $this->dom = new DOMDocument();
        $this->dom->loadXML('<?xml version="1.0" ?><copyright xmlns="https://phar.io/xml/manifest/1.0" />');
        $this->copyright = new CopyrightElement($this->dom->documentElement);
    }

    public function testThrowsExceptionWhenGetAuthroElementsIsCalledButNodesAreMissing() {
        $this->expectException(ManifestElementException::class);
        $this->copyright->getAuthorElements();
    }

    public function testThrowsExceptionWhenGetLicenseElementIsCalledButNodeIsMissing() {
        $this->expectException(ManifestElementException::class);
        $this->copyright->getLicenseElement();
    }

    public function testGetAuthorElementsReturnsAuthorElementCollection() {
        $this->dom->documentElement->appendChild(
            $this->dom->createElementNS('https://phar.io/xml/manifest/1.0', 'author')
        );
        $this->assertInstanceOf(
            AuthorElementCollection::class, $this->copyright->getAuthorElements()
        );
    }

    public function testGetLicenseElementReturnsLicenseElement() {
        $this->dom->documentElement->appendChild(
            $this->dom->createElementNS('https://phar.io/xml/manifest/1.0', 'license')
        );
        $this->assertInstanceOf(
            LicenseElement::class, $this->copyright->getLicenseElement()
        );
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace PharIo\Manifest;

class ExtensionElementTest extends \PHPUnit\Framework\TestCase {
    /**
     * @var ExtensionElement
     */
    private $extension;

    protected function setUp() {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" ?><extension xmlns="https://phar.io/xml/manifest/1.0" for="phar-io/phive" compatible="~0.6" />');
        $this->extension = new ExtensionElement($dom->documentElement);
    }

    public function testNForCanBeRetrieved() {
        $this->assertEquals('phar-io/phive', $this->extension->getFor());
    }

    public function testCompatibleVersionConstraintCanBeRetrieved() {
        $this->assertEquals('~0.6', $this->extension->getCompatible());
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    