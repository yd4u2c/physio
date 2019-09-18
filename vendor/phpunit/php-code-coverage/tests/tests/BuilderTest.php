<?xml version="1.0"?>
<phpunit xmlns="https://schema.phpunit.de/coverage/1.0">
  <file name="source_with_ignore.php" path="%e">
    <totals>
      <lines total="37" comments="12" code="25" executable="2" executed="1" percent="50.00"/>
      <methods count="0" tested="0" percent="0"/>
      <functions count="1" tested="1" percent="100.00"/>
      <classes count="0" tested="0" percent="0"/>
      <traits count="0" tested="0" percent="0"/>
    </totals>
    <class name="Foo" start="11" executable="0" executed="0" crap="1">
      <package full="" name="" sub="" category=""/>
      <namespace name=""/>
      <method name="bar" signature="bar()" start="13" end="15" crap="1" executable="0" executed="0" coverage="100"/>
    </class>
    <class name="Bar" start="18" executable="0" executed="0" crap="1">
      <package full="" name="" sub="" category=""/>
      <namespace name=""/>
      <method name="foo" signature="foo()" start="23" end="25" crap="1" executable="0" executed="0" coverage="100"/>
    </class>
    <function name="baz" signature="baz()" start="28" crap="1" executable="0" executed="0" coverage="100"/>
    <coverage>
      <line nr="2">
        <covered by="FileWithIgnoredLines"/>
      </line>
    </coverage>
    <source>
      <line no="1">
        <token name="T_OPEN_TAG">&lt;?php</token>
      </line>
      <line no="2">
        <token name="T_IF">if</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_OPEN_BRACKET">(</token>
        <token name="T_VARIABLE">$neverHappens</token>
        <token name="T_CLOSE_BRACKET">)</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="3">
        <token name="T_WHITESPACE">    </token>
        <token name="T_COMMENT">// @codeCoverageIgnoreStart</token>
      </line>
      <line no="4">
        <token name="T_WHITESPACE">    </token>
        <token name="T_PRINT">print</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_CONSTANT_ENCAPSED_STRING">'*'</token>
        <token name="T_SEMICOLON">;</token>
      </line>
      <line no="5">
        <token name="T_WHITESPACE">    </token>
        <token name="T_COMMENT">// @codeCoverageIgnoreEnd</token>
      </line>
      <line no="6">
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="7"/>
      <line no="8">
        <token name="T_DOC_COMMENT">/**</token>
      </line>
      <line no="9">
        <token name="T_DOC_COMMENT"> * @codeCoverageIgnore</token>
      </line>
      <line no="10">
        <token name="T_DOC_COMMENT"> */</token>
      </line>
      <line no="11">
        <token name="T_CLASS">class</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">Foo</token>
      </line>
      <line no="12">
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="13">
        <token name="T_WHITESPACE">    </token>
        <token name="T_PUBLIC">public</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_FUNCTION">function</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">bar</token>
        <token name="T_OPEN_BRACKET">(</token>
        <token name="T_CLOSE_BRACKET">)</token>
      </line>
      <line no="14">
        <token name="T_WHITESPACE">    </token>
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="15">
        <token name="T_WHITESPACE">    </token>
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="16">
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="17"/>
      <line no="18">
        <token name="T_CLASS">class</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">Bar</token>
      </line>
      <line no="19">
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="20">
        <token name="T_WHITESPACE">    </token>
        <token name="T_DOC_COMMENT">/**</token>
      </line>
      <line no="21">
        <token name="T_DOC_COMMENT">     * @codeCoverageIgnore</token>
      </line>
      <line no="22">
        <token name="T_DOC_COMMENT">     */</token>
      </line>
      <line no="23">
        <token name="T_WHITESPACE">    </token>
        <token name="T_PUBLIC">public</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_FUNCTION">function</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">foo</token>
        <token name="T_OPEN_BRACKET">(</token>
        <token name="T_CLOSE_BRACKET">)</token>
      </line>
      <line no="24">
        <token name="T_WHITESPACE">    </token>
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="25">
        <token name="T_WHITESPACE">    </token>
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="26">
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="27"/>
      <line no="28">
        <token name="T_FUNCTION">function</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">baz</token>
        <token name="T_OPEN_BRACKET">(</token>
        <token name="T_CLOSE_BRACKET">)</token>
      </line>
      <line no="29">
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="30">
        <token name="T_WHITESPACE">    </token>
        <token name="T_PRINT">print</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_CONSTANT_ENCAPSED_STRING">'*'</token>
        <token name="T_SEMICOLON">;</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_COMMENT">// @codeCoverageIgnore</token>
      </line>
      <line no="31">
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="32"/>
      <line no="33">
        <token name="T_INTERFACE">interface</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">Bor</token>
      </line>
      <line no="34">
        <token name="T_OPEN_CURLY">{</token>
      </line>
      <line no="35">
        <token name="T_WHITESPACE">    </token>
        <token name="T_PUBLIC">public</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_FUNCTION">function</token>
        <token name="T_WHITESPACE"> </token>
        <token name="T_STRING">foo</token>
        <token name="T_OPEN_BRACKET">(</token>
        <token name="T_CLOSE_BRACKET">)</token>
        <token name="T_SEMICOLON">;</token>
      </line>
      <line no="36"/>
      <line no="37">
        <token name="T_CLOSE_CURLY">}</token>
      </line>
      <line no="38"/>
    </source>
  </file>
</phpunit>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php
$header = <<<'EOF'
This file is part of php-file-iterator.

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
