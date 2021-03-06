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

use PharIo\Version\Version;
use PHPUnit\Framework\TestCase;

/**
 * @covers PharIo\Manifest\BundledComponent
 *
 * @uses \PharIo\Version\Version
 */
class BundledComponentTest extends TestCase {
    /**
     * @var BundledComponent
     */
    private $bundledComponent;

    protected function setUp() {
        $this->bundledComponent = new BundledComponent('phpunit/php-code-coverage', new Version('4.0.2'));
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(BundledComponent::class, $this->bundledComponent);
    }

    public function testNameCanBeRetrieved() {
        $this->assertEquals('phpunit/php-code-coverage', $this->bundledComponent->getName());
    }

    public function testVersionCanBeRetrieved() {
        $this->assertEquals('4.0.2', $this->bundledComponent->getVersion()->getVersionString());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php
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
 * @covers PharIo\Manifest\CopyrightInformation
 *
 * @uses PharIo\Manifest\AuthorCollection
 * @uses PharIo\Manifest\AuthorCollectionIterator
 * @uses PharIo\Manifest\Author
 * @uses PharIo\Manifest\Email
 * @uses PharIo\Manifest\License
 * @uses PharIo\Manifest\Url
 */
class CopyrightInformationTest extends TestCase {
    /**
     * @var CopyrightInformation
     */
    private $copyrightInformation;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var License
     */
    private $license;

    protected function setUp() {
        $this->author  = new Author('Joe Developer', new Email('user@example.com'));
        $this->license = new License('BSD-3-Clause', new Url('https://github.com/sebastianbergmann/phpunit/blob/master/LICENSE'));

        $authors = new AuthorCollection;
        $authors->add($this->author);

        $this->copyrightInformation = new CopyrightInformation($authors, $this->license);
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(CopyrightInformation::class, $this->copyrightInformation);
    }

    public function testAuthorsCanBeRetrieved() {
        $this->assertContains($this->author, $this->copyrightInformation->getAuthors());
    }

    public function testLicenseCanBeRetrieved() {
        $this->assertEquals($this->license, $this->copyrightInformation->getLicense());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php
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
 * @covers PharIo\Manifest\Email
 */
class EmailTest extends TestCase {
    public function testCanBeCreatedForValidEmail() {
        $this->assertInstanceOf(Email::class, new Email('user@example.com'));
    }

    public function testCanBeUsedAsString() {
        $this->assertEquals('user@example.com', new Email('user@example.com'));
    }

    /**
     * @covers PharIo\Manifest\InvalidEmailException
     */
    public function testCannotBeCreatedForInvalidEmail() {
        $this->expectException(InvalidEmailException::class);

        new Email('invalid');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PharIo\Manifest;

use PharIo\Version\AnyVersionConstraint;
use PharIo\Version\Version;
use PharIo\Version\VersionConstraint;
use PharIo\Version\VersionConstraintParser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PharIo\Manifest\Extension
 * @covers \PharIo\Manifest\Type
 *
 * @uses \PharIo\Version\VersionConstraint
 * @uses \PharIo\Manifest\ApplicationName
 */
class ExtensionTest extends TestCase {
    /**
     * @var Extension
     */
    private $type;

    /**
     * @var ApplicationName|\PHPUnit_Framework_MockObject_MockObject
     */
    private $name;

    protected function setUp() {
        $this->name = $this->createMock(ApplicationName::class);
        $this->type = Type::extension($this->name, new AnyVersionConstraint);
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(Extension::class, $this->type);
    }

    public function testIsNotApplication() {
        $this->assertFalse($this->type->isApplication());
    }

    public function testIsNotLibrary() {
        $this->assertFalse($this->type->isLibrary());
    }

    public function testIsExtension() {
        $this->assertTrue($this->type->isExtension());
    }

    public function testApplicationCanBeRetrieved()
    {
        $this->assertInstanceOf(ApplicationName::class, $this->type->getApplicationName());
    }

    public function testVersionConstraintCanBeRetrieved() {
        $this->assertInstanceOf(
            VersionConstraint::class,
            $this->type->getVersionConstraint()
        );
    }

    public function testApplicationCanBeQueried()
    {
        $this->name->method('isEqual')->willReturn(true);
        $this->assertTrue(
            $this->type->isExtensionFor($this->createMock(ApplicationName::class))
        );
    }

    public function testCompatibleWithReturnsTrueForMatchingVersionConstraintAndApplicaiton() {
        $app = new ApplicationName('foo/bar');
        $extension = Type::extension($app, (new VersionConstraintParser)->parse('^1.0'));
        $version = new Version('1.0.0');

        $this->assertTrue(
            $extension->isCompatibleWith($app, $version)
        );
    }

    public function testCompatibleWithReturnsFalseForNotMatchingVersionConstraint() {
        $app = new ApplicationName('foo/bar');
        $extension = Type::extension($app, (new VersionConstraintParser)->parse('^1.0'));
        $version = new Version('2.0.0');

        $this->assertFalse(
            $extension->isCompatibleWith($app, $version)
        );
    }

    public function testCompatibleWithReturnsFalseForNotMatchingApplication() {
        $app1 = new ApplicationName('foo/bar');
        $app2 = new ApplicationName('foo/foo');
        $extension = Type::extension($app1, (new VersionConstraintParser)->parse('^1.0'));
        $version = new Version('1.0.0');

        $this->assertFalse(
            $extension->isCompatibleWith($app2, $version)
        );
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php
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
 * @covers PharIo\Manifest\Library
 * @covers PharIo\Manifest\Type
 */
class LibraryTest extends TestCase {
    /**
     * @var Library
     */
    private $type;

    protected function setUp() {
        $this->type = Type::library();
    }

    public function testCanBeCreated() {
        $this->assertInstanceOf(Library::class, $this->type);
    }

    public function testIsNotApplication() {
        $this->assertFalse($this->type->isApplication());
    }

    public function testIsLibrary() {
        $this->assertTrue($this->type->isLibrary());
    }

    public function testIsNotExtension() {
        $this->assertFalse($this->type->isExtension());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           