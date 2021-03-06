\copy($this->templatePath . 'js/popper.min.js', $dir . 'popper.min.js');
        \copy($this->templatePath . 'js/d3.min.js', $dir . 'd3.min.js');
        \copy($this->templatePath . 'js/jquery.min.js', $dir . 'jquery.min.js');
        \copy($this->templatePath . 'js/nv.d3.min.js', $dir . 'nv.d3.min.js');
        \copy($this->templatePath . 'js/file.js', $dir . 'file.js');
    }

    /**
     * @throws RuntimeException
     */
    private function getDirectory(string $directory): string
    {
        if (\substr($directory, -1, 1) != \DIRECTORY_SEPARATOR) {
            $directory .= \DIRECTORY_SEPARATOR;
        }

        if (!$this->createDirectory($directory)) {
            throw new RuntimeException(
                \sprintf(
                    'Directory "%s" does not exist.',
                    $directory
                )
            );
        }

        return $directory;
    }

    private function createDirectory(string $directory): bool
    {
        return !(!\is_dir($directory) && !@\mkdir($directory, 0777, true) && !\is_dir($directory));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
/*
 * This file is part of the php-code-coverage package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\CodeCoverage\Report\Html;

use SebastianBergmann\CodeCoverage\Node\AbstractNode;
use SebastianBergmann\CodeCoverage\Node\Directory as DirectoryNode;
use SebastianBergmann\CodeCoverage\Node\File as FileNode;
use SebastianBergmann\CodeCoverage\Version;
use SebastianBergmann\Environment\Runtime;

/**
 * Base class for node renderers.
 */
abstract class Renderer
{
    /**
     * @var string
     */
    protected $templatePath;

    /**
     * @var string
     */
    protected $generator;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var int
     */
    protected $lowUpperBound;

    /**
     * @var int
     */
    protected $highLowerBound;

    /**
     * @var string
     */
    protected $version;

    public function __construct(string $templatePath, string $generator, string $date, int $lowUpperBound, int $highLowerBound)
    {
        $this->templatePath   = $templatePath;
        $this->generator      = $generator;
        $this->date           = $date;
        $this->lowUpperBound  = $lowUpperBound;
        $this->highLowerBound = $highLowerBound;
        $this->version        = Version::id();
    }

    protected function renderItemTemplate(\Text_Template $template, array $data): string
    {
        $numSeparator  = '&nbsp;/&nbsp;';

        if (isset($data['numClasses']) && $data['numClasses'] > 0) {
            $classesLevel = $this->getColorLevel($data['testedClassesPercent']);

            $classesNumber = $data['numTestedClasses'] . $numSeparator .
                $data['numClasses'];

            $classesBar = $this->getCoverageBar(
                $data['testedClassesPercent']
            );
        } else {
            $classesLevel                         = '';
            $classesNumber                        = '0' . $numSeparator . '0';
            $classesBar                           = '';
            $data['testedClassesPercentAsString'] = 'n/a';
        }

        if ($data['numMethods'] > 0) {
            $methodsLevel = $this->getColorLevel($data['testedMethodsPercent']);

            $methodsNumber = $data['numTestedMethods'] . $numSeparator .
                $data['numMethods'];

            $methodsBar = $this->getCoverageBar(
                $data['testedMethodsPercent']
            );
        } else {
            $methodsLevel                         = '';
            $methodsNumber                        = '0' . $numSeparator . '0';
            $methodsBar                           = '';
            $data['testedMethodsPercentAsString'] = 'n/a';
        }

        if ($data['numExecutableLines'] > 0) {
            $linesLevel = $this->getColorLevel($data['linesExecutedPercent']);

            $linesNumber = $data['numExecutedLines'] . $numSeparator .
                $data['numExecutableLines'];

            $linesBar = $this->getCoverageBar(
                $data['linesExecutedPercent']
            );
        } else {
            $linesLevel                           = '';
            $linesNumber                          = '0' . $numSeparator . '0';
            $linesBar                             = '';
            $data['linesExecutedPercentAsString'] = 'n/a';
        }

        $template->setVar(
            [
                'icon'                   => $data['icon'] ?? '',
                'crap'                   => $data['crap'] ?? '',
                'name'                   => $data['name'],
                'lines_b