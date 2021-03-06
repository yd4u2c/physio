<?php declare(strict_types = 1);
namespace TheSeer\Tokenizer;

use  PHPUnit\Framework\TestCase;

/**
 * @covers \TheSeer\Tokenizer\XMLSerializer
 */
class XMLSerializerTest extends TestCase {

    /** @var TokenCollection $tokens */
    private $tokens;

    protected function setUp() {
        $this->tokens = unserialize(
            file_get_contents(__DIR__ . '/_files/test.php.tokens'),
            [TokenCollection::class]
        );
    }

    public function testCanBeSerializedToXml() {
        $expected = file_get_contents(__DIR__ . '/_files/test.php.xml');

        $serializer = new XMLSerializer();
        $this->assertEquals($expected, $serializer->toXML($this->tokens));
    }

    public function testCanBeSerializedToDomDocument() {
        $serializer = new XMLSerializer();
        $result = $serializer->toDom($this->tokens);

        $this->assertInstanceOf(\DOMDocument::class, $result);
        $this->assertEquals('source', $result->documentElement->localName);
    }

    public function testCanBeSerializedToXmlWithCustomNamespace() {
        $expected = file_get_contents(__DIR__ . '/_files/customns.xml');

        $serializer = new XMLSerializer(new NamespaceUri('custom:xml:namespace'));
        $this->assertEquals($expected, $serializer->toXML($this->tokens));
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       INDX( 	 �^�             (      �                             �4     � j     �4      �h.qk� �s���P���<� �h.qk�       �               N a m e s p a c e U r i T e s t . p h p       �4     � p     �4     �`k.qk� �s���vu���<��`k.qk�       �               T o k e n C o l l e c t i o n T e s t . p h p �4     x d     �4     )�m.qk� �s��������<�)�m.qk�8      5               T o k e n i z e r T e s t . p h p     �4     p \     �4     �t.qk� �s��������<��t.qk�       �              T o k e n T e s t . p h p     �4     � l     �4     �y.qk� �s���W:���<��y.qk�                      X M L S e r i a l i z e r T e s t . p h p     �4     ` N     �4     �y.qk�M�!%�@|.qk��y.qk�                        _ f i l e s                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?xml version="1.0"?>
<source xmlns="custom:xml:namespace">
 <line no="1">
  <token name="T_OPEN_TAG">&lt;?php </token>
  <token name="T_DECLARE">declare</token>
  <token name="T_OPEN_BRACKET">(</token>
  <token name="T_STRING">strict_types</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_EQUAL">=</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_LNUMBER">1</token>
  <token name="T_CLOSE_BRACKET">)</token>
  <token name="T_SEMICOLON">;</token>
 </line>
 <line no="2">
  <token name="T_NAMESPACE">namespace</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">foo</token>
  <token name="T_SEMICOLON">;</token>
 </line>
 <line no="3"/>
 <line no="4">
  <token name="T_CLASS">class</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">bar</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_OPEN_CURLY">{</token>
 </line>
 <line no="5">
  <token name="T_WHITESPACE">    </token>
  <token name="T_CONST">const</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">x</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_EQUAL">=</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_CONSTANT_ENCAPSED_STRING">'abc'</token>
  <token name="T_SEMICOLON">;</token>
 </line>
 <line no="6"/>
 <line no="7">
  <token name="T_WHITESPACE">    </token>
  <token name="T_DOC_COMMENT">/** @var int */</token>
 </line>
 <line no="8">
  <token name="T_WHITESPACE">    </token>
  <token name="T_PRIVATE">private</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_VARIABLE">$y</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_EQUAL">=</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_LNUMBER">1</token>
  <token name="T_SEMICOLON">;</token>
 </line>
 <line no="9"/>
 <line no="10">
  <token name="T_WHITESPACE">    </token>
  <token name="T_PUBLIC">public</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_FUNCTION">function</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">__construct</token>
  <token name="T_OPEN_BRACKET">(</token>
  <token name="T_CLOSE_BRACKET">)</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_OPEN_CURLY">{</token>
 </line>
 <line no="11">
  <token name="T_WHITESPACE">        </token>
  <token name="T_COMMENT">// do something</token>
 </line>
 <line no="12">
  <token name="T_WHITESPACE">    </token>
  <token name="T_CLOSE_CURLY">}</token>
 </line>
 <line no="13"/>
 <line no="14">
  <token name="T_WHITESPACE">    </token>
  <token name="T_PUBLIC">public</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_FUNCTION">function</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">getY</token>
  <token name="T_OPEN_BRACKET">(</token>
  <token name="T_CLOSE_BRACKET">)</token>
  <token name="T_COLON">:</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">int</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_OPEN_CURLY">{</token>
 </line>
 <line no="15">
  <token name="T_WHITESPACE">        </token>
  <token name="T_RETURN">return</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_VARIABLE">$this</token>
  <token name="T_OBJECT_OPERATOR">-&gt;</token>
  <token name="T_STRING">y</token>
  <token name="T_SEMICOLON">;</token>
 </line>
 <line no="16">
  <token name="T_WHITESPACE">    </token>
  <token name="T_CLOSE_CURLY">}</token>
 </line>
 <line no="17"/>
 <line no="18">
  <token name="T_WHITESPACE">    </token>
  <token name="T_PUBLIC">public</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_FUNCTION">function</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">getSomeX</token>
  <token name="T_OPEN_BRACKET">(</token>
  <token name="T_CLOSE_BRACKET">)</token>
  <token name="T_COLON">:</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">string</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_OPEN_CURLY">{</token>
 </line>
 <line no="19">
  <token name="T_WHITESPACE">        </token>
  <token name="T_RETURN">return</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">self</token>
  <token name="T_DOUBLE_COLON">::</token>
  <token name="T_STRING">x</token>
  <token name="T_SEMICOLON">;</token>
 </line>
 <line no="20">
  <token name="T_WHITESPACE">    </token>
  <token name="T_CLOSE_CURLY">}</token>
 </line>
 <line no="21"/>
 <line no="22">
  <token name="T_WHITESPACE">    </token>
  <token name="T_PUBLIC">public</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_FUNCTION">function</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_STRING">some</token>
  <token name="T_OPEN_BRACKET">(</token>
  <token name="T_STRING">bar</token>
  <token name="T_WHITESPACE"> </token>
  <token name="T_VARIABLE">$b</token>
  <token name="T_CLOSE_BRACKET">)</token>
  <token name="T_COLON