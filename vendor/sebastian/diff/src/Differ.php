 of file
'
        );
    }

    public function testFromAfterClose(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageRegExp(\sprintf('#^%s$#', \preg_quote('Not expected from (\'-\'), already closed by "\ No newline at end of file". Line 6.', '#')));

        $this->assertValidUnifiedDiffFormat(
'--- Original
+++ New
@@ -8,12 +8,12 @@
-A
\ No newline at end of file
-A
\ No newline at end of file
'
        );
    }

    public function testSameAfterFromClose(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageRegExp(\sprintf('#^%s$#', \preg_quote('Not expected same (\' \'), \'-\' already closed by "\ No newline at end of file". Line 6.', '#')));

        $this->assertValidUnifiedDiffFormat(
            '--- Original
+++ New
@@ -8,12 +8,12 @@
-A
\ No newline at end of file
 A
\ No newline at end of file
'
        );
    }

    public function testToAfterClose(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageRegExp(\sprintf('#^%s$#', \preg_quote('Not expected to (\'+\'), already closed by "\ No newline at end of file". Line 6.', '#')));

        $this->assertValidUnifiedDiffFormat(
            '--- Original
+++ New
@@ -8,12 +8,12 @@
+A
\ No newline at end of file
+A
\ No newline at end of file
'
        );
    }

    public function testSameAfterToClose(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageRegExp(\sprintf('#^%s$#', \preg_quote('Not expected same (\' \'), \'+\' already closed by "\ No newline at end of file". Line 6.', '#')));

        $this->assertValidUnifiedDiffFormat(
            '--- Original
+++ New
@@ -8,12 +8,12 @@
+A
\ No newline at end of file
 A
\ No newline at end of file
'
        );
    }

    public function testUnexpectedEOFFromMissingLines(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageRegExp(\sprintf('#^%s$#', \preg_quote('Unexpected EOF, number of lines in hunk "from" (\'-\')) mismatched. Line 7.', '#')));

        $this->assertValidUnifiedDiffFormat(
'--- Original
+++ New
@@ -8,19 +7,2 @@
-A
+B
 ' . '
'
        );
    }

    public function testUnexpectedEOFToMissingLines(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageRegExp(\sprintf('#^%s$#', \preg_quote('Unexpected EOF, number of lines in hunk "to" (\'+\')) mismatched. Line 7.', '#')));

        $this->assertValidUnifiedDiffFormat(
'--- Original
+++ New
@@ -8,2 +7,3 @@
-A
+B
 ' . '
'
        );
    }

    public function testUnexpectedEOFBothFromAndToMissingLines(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageRegExp(\sprintf('#^%s$#', \preg_quote('Unexpected EOF, number of lines in hunk "from" (\'-\')) and "to" (\'+\') mismatched. Line 7.', '#')));

        $this->assertValidUnifiedDiffFormat(
'--- Original
+++ New
@@ -1,12 +1,14 @@
-A
+B
 ' . '
'
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php
$header = <<<'EOF'
This file is part of sebastian/environment.

(c) Sebastian Bergmann <sebastian@phpunit.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(
        [
            'align_multiline_comment' => true,
            'array_indentation' => true,
            'array_syntax' => ['syntax' => 'short'],
            'binary_operator_spaces' => [
                'operators' => [
                    '=' => 'align',
                    '=>' => 'align',
                ],
            ],
            'blank_line_after_namespace' => true,
            'blank_line_before_statement' => [
                'statements' => [
                    'break',
                    'continue',
                    'declare',
                    'do',
                    'for',
                    'foreach',
                    'if',
                    'include',
                    'include_once',
                    'require',
                    'require_once',
                    'return',
                    'switch',
                    'throw',
                    'try',
                    'while',
                    'yield',
                ],
            ],
            'braces' => true,
            'cast_spaces' => true,
            'class_attributes_separation' => ['elements' => ['const', 'method', 'property']],
            'combine_consecutive_issets' => true,
            'combine_consecutive_unsets' => true,
            'combine_nested_dirname' => true,
            'compact_nullable_typehint' => true,
            'concat_space' => ['spacing' => 'one'],
            'declare_equal_normalize' => ['space' => 'none'],
            'declare_strict_types' => true,
            'dir_constant' => true,
            'elseif' => true,
            'encoding' => true,
            'full_opening_tag' => true,
            'function_declaration' => true,
            'header_comment' => ['header' => $header, 'separate' => 'none'],
            'indentation_type' => true,
            'is_null' => true,
            'line_ending' => true,
            'list_syntax' => ['syntax' => 'short'],
            'logical_operators' => true,
            'lowercase_cast' => true,
            'lowercase_constants' => true,
            'lowercase_keywords' => true,
            'lowercase_static_reference' => true,
            'magic_constant_casing' => true,
            'method_argument_space' => ['ensure_fully_multiline' => true],
            'modernize_types_casting' => true,
            'multiline_comment_opening_closing' => true,
            'multiline_whitespace_before_semicolons' => true,
            'native_constant_invocation' => true,
            'native_function_casing' => true,
            'native_function_invocation' => true,
            'new_with_braces' => false,
            'no_alias_functions' => true,
            'no_alternative_syntax' => true,
            'no_blank_lines_after_class_opening' => true,
            'no_blank_lines_after_phpdoc' => true,
            'no_blank_lines_before_namespace' => true,
            'no_closing_tag' => true,
            'no_empty_comment' => true,
            'no_empty_phpdoc' => true,
            'no_empty_statement' => true,
            'no_extra_blank_lines' => true,
            'no_homoglyph_names' => true,
            'no_leading_import_slash' => true,
            'no_leading_namespace_whitespace' => true,
            'no_mixed_echo_print' => ['use' => 'print'],
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_null_property_initialization' => true,
            'no_php4_constructor' => true,
            'no_short_bool_cast' => true,
            'no_short_echo_tag' => true,
            'no_singleline_whitespace_before_semicolons' => true,
            'no_spaces_after_function_name' => true,
            'no_spaces_inside_parenthesis' => true,
            'no_superfluous_elseif' => true,
            'no_superfluous_phpdoc_tags' => true,
            'no_trailing_comma_in_list_call' => true,
            'no_trailing_comma_in_singleline_array' => true,
            'no_trailing_whitespace' => true,
            'no_trailing_whitespace_in_comment' => true,
            'no_unneeded_control_parentheses' => true,
            'no_unneeded_curly_braces' => true,
            'no_unneeded_final_method' => true,
            'no_unreachable_default_argument_value' => true,
            'no_unset_on_property' => true,
            'no_unused_imports' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'no_whitespace_before_comma_in_array' => true,
            'no_whitespace_in_blank_line' => true,
            'non_printable_character' => true,
            'normalize_index_brace' => true,
            'object_operator_without_whitespace' => true,
            'ordered_class_elements' => [
                'order' => [
                    'use_trait',
                    'constant_public',
                    'constant_protected',
                    'constant_private',
                    'property_public_static',
                    'property_protected_static',
                    'property_private_static',
                    'property_public',
                    'property_protected',
               