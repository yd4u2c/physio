<?php
/*
 * This file is part of Object Enumerator.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianBergmann\ObjectEnumerator;

use SebastianBergmann\ObjectEnumerator\Fixtures\ExceptionThrower;
use PHPUnit\Framework\TestCase;

/**
 * @covers SebastianBergmann\ObjectEnumerator\Enumerator
 */
class EnumeratorTest extends TestCase
{
    /**
     * @var Enumerator
     */
    private $enumerator;

    protected function setUp()
    {
        $this->enumerator = new Enumerator;
    }

    public function testEnumeratesSingleObject()
    {
        $a = new \stdClass;

        $objects = $this->enumerator->enumerate($a);

        $this->assertCount(1, $objects);
        $this->assertSame($a, $objects[0]);
    }

    public function testEnumeratesArrayWithSingleObject()
    {
        $a = new \stdClass;

        $objects = $this->enumerator->enumerate([$a]);

        $this->assertCount(1, $objects);
        $this->assertSame($a, $objects[0]);
    }

    public function testEnumeratesArrayWithTwoReferencesToTheSameObject()
    {
        $a = new \stdClass;

        $objects = $this->enumerator->enumerate([$a, $a]);

        $this->assertCount(1, $objects);
        $this->assertSame($a, $objects[0]);
    }

    public function testEnumeratesArrayOfObjects()
    {
        $a = new \stdClass;
        $b = new \stdClass;

        $objects = $this->enumerator->enumerate([$a, $b, null]);

        $this->assertCount(2, $objects);
        $this->assertSame($a, $objects[0]);
        $this->assertSame($b, $objects[1]);
    }

    public function testEnumeratesObjectWithAggregatedObject()
    {
        $a = new \stdClass;
        $b = new \stdClass;

        $a->b = $b;
        $a->c = null;

        $objects = $this->enumerator->enumerate($a);

        $this->assertCount(2, $objects);
        $this->assertSame($a, $objects[0]);
        $this->assertSame($b, $objects[1]);
    }

    public function testEnumeratesObjectWithAggregatedObjectsInArray()
    {
        $a = new \stdClass;
        $b = new \stdClass;

        $a->b = [$b];

        $objects = $this->enumerator->enumerate($a);

        $this->assertCount(2, $objects);
        $this->assertSame($a, $objects[0]);
        $this->assertSame($b, $objects[1]);
    }

    public function testEnumeratesObjectsWithCyclicReferences()
    {
        $a = new \stdClass;
        $b = new \stdClass;

        $a->b = $b;
        $b->a = $a;

        $objects = $this->enumerator->enumerate([$a, $b]);

        $this->assertCount(2, $objects);
        $this->assertSame($a, $objects[0]);
        $this->assertSame($b, $objects[1]);
    }

    public function testEnumeratesClassThatThrowsException()
    {
        $thrower = new ExceptionThrower();

        $objects = $this->enumerator->enumerate($thrower);

        $this->assertSame($thrower, $objects[0]);
    }

    public function testExceptionIsRaisedForInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->enumerator->enumerate(null);
    }

    public function testExceptionIsRaisedForInvalidArgument2()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->enumerator->enumerate([], '');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php
$header = <<<'EOF'
This file is part of object-reflector.

(c) Sebastian Bergmann <sebastian@phpunit.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(
        [
            'array_syntax' => ['syntax' => 'short'],
            'binary_operator_spaces' => [
                'align_double_arrow' => true,
                'align_equals' => true
            ],
            'blank_line_after_namespace' => true,
            'blank_line_before_return' => true,
            'braces' => true,
            'cast_spaces' => true,
            'concat_space' => ['spacing' => 'one'],
            'declare_strict_types' => true,
            'elseif' => true,
            'encoding' => true,
            'full_opening_tag' => true,
            'function_declaration' => true,
            #'header_comment' => ['header' => $header, 'separate' => 'none'],
            'indentation_type' => true,
            'line_ending' => true,
            'lowercase_constants' => true,
            'lowercase_keywords' => true,
            'method_argument_space' => true,
            'no_alias_functions' => true,
            'no_blank_lines_after_class_opening' => true,
            'no_blank_lines_after_phpdoc' => true,
            'no_closing_tag' => true,
            'no_empty_phpdoc' => true,
            'no_empty_statement' => true,
            'no_extra_consecutive_blank_lines' => true,
            'no_leading_namespace_whitespace' => true,
            'no_singleline_whitespace_before_semicolons' => true,
            'no_spaces_after_function_name' => true,
            'no_spaces_inside_parenthesis' => true,
            'no_trailing_comma_in_list_call' => true,
            'no_trailing_whitespace' => true,
            'no_unused_imports' => true,
            'no_whitespace_in_blank_line' => true,
            'phpdoc_align' => true,
            'phpdoc_indent' => true,
            'phpdoc_no_access' => true,
            'phpdoc_no_empty_return' => true,
            'phpdoc_no_package' => true,
            'phpdoc_scalar' => true,
            'phpdoc_separation' => true,
            'phpdoc_to_comment' => true,
            'phpdoc_trim' => true,
            'phpdoc_types' => true,
            'phpdoc_var_without_name' => true,
            'self_accessor' => true,
            'simplified_null_return' => true,
            'single_blank_line_at_eof' => true,
            'single_import_per_statement' => true,
            'single_line_after_imports' => true,
            'single_quote' => true,
            'ternary_operator_spaces' => true,
            'trim_array_spaces' => true,
            'visibility_required' => true,
        ]
    )
    ->setFinder(
        PhpCsFixer\Finder::create()
        ->files()
        ->in(__DIR__ . '/src')
        ->in(__DIR__ . '/tests')
        ->name('*.php')
    );
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?xml version="1.0" encoding="UTF-8"?>
<project name="object-reflector" default="setup">
    <target name="setup" depends="clean,composer"/>

    <target name="clean" description="Cleanup build artifacts">
        <delete dir="${basedir}/vendor"/>
        <delete file="${basedir}/composer.lock"/>
    </target>

    <target name="composer" depends="clean" description="Install dependencies with Composer">
        <exec executable="composer" taskname="composer">
            <arg value="update"/>
            <arg value="--no-interaction"/>
            <arg value="--no-progress"/>
            <arg value="--no-ansi"/>
            <arg value="--no-suggest"/>
            <arg value="--optimize-autoloader"/>
            <arg value="--prefer-stable"/>
        </exec>
    </target>
</project>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          