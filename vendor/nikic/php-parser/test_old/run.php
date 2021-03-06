# Manifest

Component for reading [phar.io](https://phar.io/) manifest information from a [PHP Archive (PHAR)](http://php.net/phar).

[![Build Status](https://travis-ci.org/phar-io/manifest.svg?branch=master)](https://travis-ci.org/phar-io/manifest)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phar-io/manifest/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phar-io/manifest/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d8cc6035-69ad-477d-bd1a-ccc605480fd7/mini.png)](https://insight.sensiolabs.com/projects/d8cc6035-69ad-477d-bd1a-ccc605480fd7)

## Installation

You can add this library as a local, per-project dependency to your project using [Composer](https://getcomposer.org/):

    composer require phar-io/manifest

If you only need this library during development, for instance to run your project's test suite, then you should add it as a development-time dependency:

    composer require --dev phar-io/manifest

## Usage

```php
use PharIo\Manifest\ManifestLoader;
use PharIo\Manifest\ManifestSerializer;

$manifest = ManifestLoader::fromFile('manifest.xml');

var_dump($manifest);

echo (new ManifestSerializer)->serializeToString($manifest);
```
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php
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
use PharIo\Version\Exception as VersionException;
use PharIo\Version\VersionConstraintParser;

class ManifestDocumentMapper {
    /**
     * @param ManifestDocument $document
     *
     * @returns Manifest
     *
     * @throws ManifestDocumentMapperException
     */
    public function map(ManifestDocument $document) {
        try {
            $contains          = $document->getContainsElement();
            $type              = $this->mapType($contains);
            $copyright         = $this->mapCopyright($document->getCopyrightElement());
            $requirements      = $this->mapRequirements($document->getRequiresElement());
            $bundledComponents = $this->mapBundledComponents($document);

            return new Manifest(
                new ApplicationName($contains->getName()),
                new Version($contains->getVersion()),
                $type,
                $copyright,
                $requirements,
                $bundledComponents
            );
        } catch (VersionException $e) {
            throw new ManifestDocumentMapperException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            throw new ManifestDocumentMapperException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param ContainsElement $contains
     *
     * @return Type
     *
     * @throws ManifestDocumentMapperException
     */
    private function mapType(ContainsElement $contains) {
        switch ($contains->getType()) {
            case 'application':
                return Type::application();
            case 'library':
                return Type::library();
            case 'extension':
                return $this->mapExtension($contains->getExtensionElement());
        }

        throw new ManifestDocumentMapperException(
            sprintf('Unsupported type %s', $contains->getType())
        );
    }

    /**
     * @param CopyrightElement $copyright
     *
     * @return CopyrightInformation
     *
     * @throws InvalidUrlException
     * @throws InvalidEmailException
     */
    private function mapCopyright(CopyrightElement $copyright) {
        $authors = new AuthorCollection();

        foreach($copyright->getAuthorElements() as $authorElement) {
            $authors->add(
                new Author(
                    $authorElement->getName(),
                    new Email($authorElement->getEmail())
                )
            );
        }

        $licenseElement = $copyright->getLicenseElement();
        $license        = new License(
            $licenseElement->getType(),
            new Url($licenseElement->getUrl())
        );

        return new CopyrightInformation(
            $authors,
            $license
        );
    }

    /**
     * @param RequiresElement $requires
     *
     * @return RequirementCollection
     *
     * @throws ManifestDocumentMapperException
     */
    private function mapRequirements(RequiresElement $requires) {
        $collection = new RequirementCollection();
        $phpElement = $requires->getPHPElement();
        $parser     = new VersionConstraintParser;

        try {
            $versionConstraint = $parser->parse($phpElement->getVersion());
        } catch (VersionException $e) {
            throw new ManifestDocumentMapperException(
                sprintf('Unsupported version constraint - %s', $e->getMessage()),
                $e->getCode(),
                $e
            );