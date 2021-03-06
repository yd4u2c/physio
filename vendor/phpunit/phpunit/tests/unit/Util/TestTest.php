<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class ExceptionStackTest extends TestCase
{
    public function testPrintingChildException(): void
    {
        try {
            $this->assertEquals([1], [2], 'message');
        } catch (ExpectationFailedException $e) {
            $message = $e->getMessage() . $e->getComparisonFailure()->getDiff();

            throw new PHPUnit\Framework\Exception("Child exception\n$message", 101, $e);
        }
    }

    public function testNestedExceptions(): void
    {
        $exceptionThree = new Exception('Three');
        $exceptionTwo   = new InvalidArgumentException('Two', 0, $exceptionThree);
        $exceptionOne   = new Exception('One', 0, $exceptionTwo);

        throw $exceptionOne;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * Exception message
     *
     * @var string
     */
    public const ERROR_MESSAGE = 'Exception message';

    /**
     * Exception message
     *
     * @var string
     */
    public const ERROR_MESSAGE_REGEX = '#regex#';

    /**
     * Exception code
     *
     * @var int
     */
    public const ERROR_CODE = 500;

    /**
     * @expectedException FooBarBaz
     */
    public function testOne(): void
    {
    }

    /**
     * @expectedException Foo_Bar_Baz
     */
    public function testTwo(): void
    {
    }

    /**
     * @expectedException Foo\Bar\Baz
     */
    public function testThree(): void
    {
    }

    /**
     * @expectedException ほげ
     */
    public function testFour(): void
    {
    }

    /**
     * @expectedException Class Message 1234
     */
    public function testFive(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionMessage Message
     * @expectedExceptionCode 1234
     */
    public function testSix(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionMessage Message
     * @expectedExceptionCode ExceptionCode
     */
    public function testSeven(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionMessage Message
     * @expectedExceptionCode 0
     */
    public function testEight(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionMessage ExceptionTest::ERROR_MESSAGE
     * @expectedExceptionCode ExceptionTest::ERROR_CODE
     */
    public function testNine(): void
    {
    }

    /** @expectedException Class */
    public function testSingleLine(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode ExceptionTest::UNKNOWN_CODE_CONSTANT
     * @expectedExceptionMessage ExceptionTest::UNKNOWN_MESSAGE_CONSTANT
     */
    public function testUnknownConstants(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode 1234
     * @expectedExceptionMessage Message
     * @expectedExceptionMessageRegExp #regex#
     */
    public function testWithRegexMessage(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode 1234
     * @expectedExceptionMessage Message
     * @expectedExceptionMessageRegExp ExceptionTest::ERROR_MESSAGE_REGEX
     */
    public function testWithRegexMessageFromClassConstant(): void
    {
    }

    /**
     * @expectedException Class
     * @expectedExceptionCode 1234
     * @expectedExceptionMessage Message
     * @expectedExceptionMessageRegExp ExceptionTest::UNKNOWN_MESSAGE_REGEX_CONSTANT
     */
    public function testWithUnknowRegexMessageFromClassConstant(): void
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;

class FailureTest extends TestCase
{
    public function testAssertArrayEqualsArray(): void
    {
        $this->assertEquals([1], [2], 'message');
    }

    public function testAssertIntegerEqualsInteger(): void
    {
        $this->assertEquals(1, 2, 'message');
    }

    public function testAssertObjectEqualsObject(): void
    {
        $a      = new stdClass;
        $a->foo = 'bar';

        $b      = new stdClass;
        $b->bar = 'foo';

        $this->assertEquals($a, $b, 'message');
    }

    public function testAssertNullEqualsString(): void
    {
        $this->assertEquals(null, 'bar', 'message');
    }

    public function testAssertStringEqualsString(): void
    {
        $this->assertEquals('foo', 'bar', 'message');
    }

    public function testAssertTextEqualsText(): void
    {
        $this->assertEquals("foo\nbar\n", "foo\nbaz\n", 'message');
    }

    public function testAssertStringMatchesFormat(): void
    {
        $this->assertStringMatchesFormat('*%s*', '**', 'message');
    }

    public function testAssertNumericEqualsNumeric(): void
    {
        $this->assertEquals(1, 2, 'message');
    }

    public function testAssertTextSameText(): void
    {
        $this->assertSame('foo', 'bar', 'message');
    }

    public function testAssertObjectSameObject(): void
    {
        $this->assertSame(new stdClass, new stdClass, 'message');
    }

    public function testAssertObjectSameNull(): void
    {
        $this->assertSame(new stdClass, null, 'message');
    }

    public function testAssertFloatSameFloat(): void
    {
        $this->assertSame(1.0, 1.5, 'message');
    }

    // Note that due to the implementation of this assertion it counts as 2 asserts
    public function testAssertStringMatchesFormatFile(): void
    {
        $this->assertStringMatchesFormatFile(__DIR__ . '/expectedFileFormat.txt', '...BAR...');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?xml version="1.0"?>

<!-- WSDL description of the Google Web APIs.
     The Google Web APIs are in beta release. All interfaces are subject to
     change as we refine and extend our APIs. Please see the terms of use
     for more information. -->

<!-- Revision 2002-08-16 -->

<definitions name="GoogleSearch"
             targetNamespace="urn:GoogleSearch"
             xmlns:typens="urn:GoogleSearch"
             xmlns:xsd="http://www.w3.org/2001/XMLSchema"
             xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
             xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
             xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
             xmlns="http://schemas.xmlsoap.org/wsdl/">

  <!-- Types for search - result elements, directory categories -->

  <types>
    <xsd:schema xmlns="http://www.w3.org/2001/XMLSchema"
                targetNamespace="urn:GoogleSearch">

      <xsd:complexType name="GoogleSearchResult">
        <xsd:all>
          <xsd:element name="documentFiltering"           type="xsd:boolean"/>
          <xsd:element name="searchComments"              type="xsd:string"/>
          <xsd:element name="estimatedTotalResultsCount"  type="xsd:int"/>
          <xsd:element name="estimateIsExact"             type="xsd:boolean"/>
          <xsd:element name="resultElements"              type="typens:ResultElementArray"/>
          <xsd:element name="searchQuery"                 type="xsd:string"/>
          <xsd:element name="startIndex"                  type="xsd:int"/>
          <xsd:element name="endIndex"                    type="xsd:int"/>
          <xsd:element name="searchTips"                  type="xsd:string"/>
          <xsd:element name="directoryCategories"         type="typens:DirectoryCategoryArray"/>
          <xsd:element name="searchTime"                  type="xsd:double"/>
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="ResultElement">
        <xsd:all>
          <xsd:element name="summary" type="xsd:string"/>
          <xsd:element name="URL" type="xsd:string"/>
          <xsd:element name="snippet" type="xsd:string"/>
          <xsd:element name="title" type="xsd:string"/>
          <xsd:element name="cachedSize" type="xsd:string"/>
          <xsd:element name="relatedInformationPresent" type="xsd:boolean"/>
          <xsd:element name="hostName" type="xsd:string"/>
          <xsd:element name="directoryCategory" type="typens:DirectoryCategory"/>
          <xsd:element name="directoryTitle" type="xsd:string"/>
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="ResultElementArray">
        <xsd:complexContent>
          <xsd:restriction base="soapenc:Array">
             <xsd:attribute ref="soapenc:arrayType" wsdl:arrayType="typens:ResultElement[]"/>
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="DirectoryCategoryArray">
        <xsd:complexContent>
          <xsd:restriction base="soapenc:Array">
             <xsd:attribute ref="soapenc:arrayType" wsdl:arrayType="typens:DirectoryCategory[]"/>
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="DirectoryCategory">
        <xsd:all>
          <xsd:element name="fullViewableName" type="xsd:string"/>
          <xsd:element name="specialEncoding" type="xsd:string"/>
        </xsd:all>
      </xsd:complexType>

    </xsd:schema>
  </types>

  <!-- Messages for Google Web APIs - cached page, search, spelling. -->

  <message name="doGetCachedPage">
    <part name="key"            type="xsd:string"/>
    <part name="url"            type="xsd:string"/>
  </message>

  <message name="doGetCachedPageResponse">
    <part name="return"         type="xsd:base64Binary"/>
  </message>

  <message name="doSpellingSuggestion">
    <part name="key"            type="xsd:string"/>
    <part name="phrase"         type="xsd:string"/>
  </message>

  <message name="doSpellingSuggestionResponse">
    <part name="return"         type="xsd:string"/>
  </message>

  <!-- note, ie and oe are ignored by server; all traffic is UTF-8. -->

  <message name="doGoogleSearch">
    <part name="key"            type="xsd:string"/>
    <part name="q"              type="xsd:string"/>
    <part name="start"          type="xsd:int"/>
    <part name="maxResults"     type="xsd:int"/>
    <part name="filter"         type="xsd:boolean"/>
    <part name="restrict"       type="xsd:string"/>
    <part name="safeSearch"     type="xsd:boolean"/>
    <part name="lr"             type="xsd:string"/>
    <part name="ie"             type="xsd:string"/>
    <part name="oe"             type="xsd:string"/>
  </message>

  <message name="doGoogleSearchResponse">
    <part name="return"         type="typens:GoogleSearchResult"/>
  </message>

  <!-- Port for Google Web APIs, "GoogleSearch" -->

  <portType name="GoogleSearchPort">

    <operation name="doGetCachedPage">
      <input message="typens:doGetCachedPage"/>
      <output message="typens:doGetCachedPageResponse"/>
    </operation>

    <operation name="doSpellingSuggestion">
      <input message="typens:doSpellingSuggestion"/>
      <output message="typens:doSpellingSuggestionResponse"/>
    </operation>

    <operation name="doGoogleSearch">
      <input message="typens:doGoogleSearch"/>
      <output message="typens:doGoogleSearchResponse"/>
    </operation>

  </portType>


  <!-- Binding for Google Web APIs - RPC, SOAP over HTTP -->

  <binding name="GoogleSearchBinding" type="typens:GoogleSearchPort">
    <soap:binding style="rpc"
                  transport="http://schemas.xmlsoap.org/soap/http"/>

    <operation name="doGetCachedPage">
      <soap:operation soapAction="urn:GoogleSearchAction"/>
      <input>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </input>
      <output>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </output>
    </operation>

    <operation name="doSpellingSuggestion">
      <soap:operation soapAction="urn:GoogleSearchAction"/>
      <input>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </input>
      <output>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </output>
    </operation>

    <operation name="doGoogleSearch">
      <soap:operation soapAction="urn:GoogleSearchAction"/>
      <input>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </input>
      <output>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </output>
    </operation>
  </binding>

  <!-- Endpoint for Google Web APIs -->
  <service name="GoogleSearchService">
    <port name="GoogleSearchPort" binding="typens:GoogleSearchBinding">
      <soap:address location="http://api.google.com/search/beta2"/>
    </port>
  </service>

</definitions>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                INDX( 	 ��            (   �  �       �   �           �$     � x     $     >�ُpk� O�
���C���<�>�ُpk�       %               E x c e p t i o n I n T e a r D o w n T e s t . p h p �$     x h     $     Woޏpk� O�
�������<�Woޏpk�       �               E x c e p t i o n I n T e s t . p h p �$     � �     $     ����pk� O�
�������<�����pk��      �              % E x c e p t i o n I n T e s t D e t e c t e d I n T e a r d o w n . p h p     �$     � v     $     S��pk  O�
��a���<�S��pk�       A               E x c e p t i o n N a m e s p a c e T e s t . p h p   �$     � n     $     ���pk� O�
���k���<����pk�       �               E x c e p t i o n S t a c k T e s t . p h p   �$     x d     $     @��pk� O�
���̡��<�@��pk�       �               E x c e p t i o n T e s t . p h p     �$     � v     $     � �pk� O�
���̡��<�� �pk�                      E x c e p t i o n W i t h T h r o w a b l e . p h p   �$     � n     $     Ă�pk� O�
���/���<�Ă�pk�                       e x p e c t e d F i l e F o r m a t . t x t   �$     h X     $     ���pk� O�
��G����<����pk�x      r               F a i l u r e . p h p �$     p `     $     wG��pk� O�
��G����<�wG��pk�       c               F a i l u r e T e s t . p h p �$     x h     $     n��pk� O�
������<�n��pk�(      "               F a l s y C o n s t r a i n t . p h p �$     p \     $     �2�pk� O�
��uW���<��2�pk��      �              F a t a l T e s t . p h p     �$     p ^     $     v��pk� O�
��uW���<�v��pk��      �               F i n a l C l a s s . p h p   �$     ` P     $     �Z	�pk� O�
��f�̰�<��Z	�pk�P      P               F o o . p h p �$     ` P     $     $��pk� O�
���ϰ�<�$��pk�                       f o o . x m l �$     � j     $     ��pk� O�
��e|Ѱ�<���pk��      �               F u n c t i o n C a l l b a c k . p h p                     $     ���pk� O�
� ��Ӱ�<����pk�                        G o   o g l e - S e a . r c h . w s d l       �$     x d     $     PF�pk� O�
����Ӱ�<�PF�pk�                        G o o g l e S e a r c h . w s d l     �$     � x     $     �l�pk� O�
���Aְ�<��l�pk��      �               I g n o r e C o d e C o v e r a g e C l a s s . p h p �$     � �     $     G2!�pk� O�
��=�ذ�<�G2!�pk�h      d               I g n o r e C o d e C o v e r a g e C l a s s T e s t . p h p �$     x f     $     "�%�pk� O�
��=�ذ�<�"�%�pk��      �               I n c o m p l e t e T e s t . p h p   �$     � l     $     {X(�pk� O�
���۰�<�{X(�pk�H      B               I n h e r i t e d T e s t C a s e . p h p     �$     h X     $     --�pk� O�
��hݰ�<�--�pk��      �               I n i T e s t . p h p �$     � �     $     �/�pk� O�
��^�߰�<��/�pk�8      3              ' I n t e r f a c e W i t h S e m i R e s e r v e d M e t h o d N a m e . p h p �$     � |     $     9D4�pk� O�
��^�߰�<�9D4�pk�8      7               I n t e r f a c e W i t h S t a t i c M e t h o d . p h p     �$     x d     $     ��6�pk� O�
���-��<���6�pk�(      !               I s o l a t i o n T e s t . p h p     �$     x f     $     �0@�pk� O�
�����<��0@�pk�H      H               M e t h o d C a l l b a c k . p h p   �$     � |     $     `�B�pk� O�
�����<�`�B�pk��      �               M e t h o d C a l l b a c k B y R e f e r e n c e . p h p     �$     p Z     $     g�I�pk� O�
��[���<�g�I�pk�       �               M o c k a b l e . p h p       �$     p ^     $     L�pk� O�
���S��<�L�pk�x      q               M o c k R u n n e r . p h p   �$     � l     $     7~N�pk� O�
�����<�7~N�pk�X      U               M o c k T e s t I n t e r f a c e . p h p     �$     � p     $     �CS�pk� O�
�����<��CS�pk�       �               M u l t i D e p e n d e n c y T e s t . p h p                                      INDX( 	 7_�     	       (   �  �       �i t a �s           �$     x d     $     PF�pk� O�
����Ӱ�<�PF�pk�                        G o o g l e S e a r c h . w s d l     �$     � x     $     �l�pk� O�
���Aְ�<��l�pk��      �               I g n o r e C o d e C o v e r a g e C l a s s . p h p �$     � �     $     G2!�pk� O�
��=�ذ�<�G2!�pk�h      d               I g n o r e C o d e C o v e r a g e C l a s s T e s t . p h p �$     x f     $     "�%�pk� O�
��=�ذ�< "�%�pk��      �               I n c o m p l e t e T e s t . p h p   %     h X     $     ;ۑ�pk����pk����pk�;ۑ�pk�                        I n h e r i t a n c e �$     � l     $     {X(�pk� O�
���۰�<�{X(�pk�H      B               I n h e r i t e d T e s t C a s e . p h p     �$     h X     $     --�pk� O�
��hݰ�<�--�pk��      �               I n i T e s t . p h p �$     � �     $     �/�pk� O�
��^�߰�<��/�pk�8      3              ' I n t e r f a c e W  t h S e m i R e s e r v e d M e t h o d N a m e . p h p �$     � |     $     9D4�pk� O�
��^�߰�<�9D4�pk�8      7               I n t e r f a c e W i t h S t a t i c M e t h o d . p h p     �$     x d     $     ��6�pk� O�
���-��<���6�pk�(      !               I s o l a t i o n T e s t . p h p     
%     h R     $     F��pk��d��pk��d��pk�F��pk�                        J s o n D a t a l l b �$     x f     $     �0@�pk� O�
�����<��0@�pk�H      H               M e  h o d C a l l b a c k . p h p   �$     � |     $     `�B�pk� O�
�����<�`�B�pk��      �               M e t h o d C a l l b a c k B y R e f e r e n c e . p h p     �$     p Z     $     g�I�pk� O�
��[���<�g�I�pk�       �               M o c k a b l e . p h p       �$     p ^     $     L�pk� O�
���S��<�L�pk�x      q               M o c k R u n n e r . p h p   �$     � l     $     7~N�pk� O�
�����<�7~N�pk�X      U               M o c k T e s t I n t e r f  c e . p h p     �$     � p     $     �CS�pk� O�
�����<��CS�pk�       �               M u l t i D e p e n d e n c y T e s t . p h p               �               M u l t i p l e D a t a P r o v i d e r T e s t . p h p       �$     p \     $     D�a�pk� O�
���z��<�D�a�pk�(      '               M y C o m m a n d . p h p     �$     x f     $     �h�pk� O�
��#���<��h�pk�       �	               M y T e s t L i s t e n e r . p h p   �$     x h     $     �k�pk� O�
� �@���<��k�pk��      �               N a m e d C o n s t r a i n t . p h p �$     � �     $     2�o�pk� O�
�������<�2�o�pk��      �              & N a m e s p a c e C o v e r a g e C l a s s E x t e n d e d T e s t . p h p   �$     � ~     $     >Br�pk� O�
�������<�>Br�pk��      �               N a m e s p a c e C o v e r a g e C l a s s T e s t . p h p   �$     � �     $     �hy�pk� O�
��v���<��hy�pk�                     * N a m e s p a c e C o v e r a g e C o v e r  C l a s s P u b l i c T e s t . p h p   �$     � �     $     ��{�pk� O�
���f���<���{�pk�       �              $ N a m e s p a c e C o v e r a g e C o v e r s C l a s s T e s t . p h p       �$     � �     $     N-~�pk� O�
���f���<�N-~�pk��      �               N a m e s p a c e C o v e r a g e M e t h o d T e s t . p h p �$     � �     $     �pk� O�
�������<��pk��      �              # N a m e s p a c e C o v e r a g e N o t P r i v a t e T e s t . p h p �$     � �    $     "U��pk� O�
��O+��<�"U��pk��      �              % N a m e s p a c e C o v e r a g e N o t P r o t e c t e d T e s t . p h p     �$     � �     $     ¶��pk� O�
������<�¶��pk��      �              " N a m e s p a c e C o v e r a g e N o t P u b l i c T e s t . p h p   �$     � �     $      ��pk� O�
������<� ��pk��      �                N a m e s p a c e C o v e r a g e P r i v a t e T e s t . p h p                                                                    <?xml version="1.0"?>

<!-- WSDL description of the Google Web APIs.
     The Google Web APIs are in beta release. All interfaces are subject to
     change as we refine and extend our APIs. Please see the terms of use
     for more information. -->

<!-- Revision 2002-08-16 -->

<definitions name="GoogleSearch"
             targetNamespace="urn:GoogleSearch"
             xmlns:typens="urn:GoogleSearch"
             xmlns:xsd="http://www.w3.org/2001/XMLSchema"
             xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
             xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
             xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
             xmlns="http://schemas.xmlsoap.org/wsdl/">

  <!-- Types for search - result elements, directory categories -->

  <types>
    <xsd:schema xmlns="http://www.w3.org/2001/XMLSchema"
                targetNamespace="urn:GoogleSearch">

      <xsd:complexType name="GoogleSearchResult">
        <xsd:all>
          <xsd:element name="documentFiltering"           type="xsd:boolean"/>
          <xsd:element name="searchComments"              type="xsd:string"/>
          <xsd:element name="estimatedTotalResultsCount"  type="xsd:int"/>
          <xsd:element name="estimateIsExact"             type="xsd:boolean"/>
          <xsd:element name="resultElements"              type="typens:ResultElementArray"/>
          <xsd:element name="searchQuery"                 type="xsd:string"/>
          <xsd:element name="startIndex"                  type="xsd:int"/>
          <xsd:element name="endIndex"                    type="xsd:int"/>
          <xsd:element name="searchTips"                  type="xsd:string"/>
          <xsd:element name="directoryCategories"         type="typens:DirectoryCategoryArray"/>
          <xsd:element name="searchTime"                  type="xsd:double"/>
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="ResultElement">
        <xsd:all>
          <xsd:element name="summary" type="xsd:string"/>
          <xsd:element name="URL" type="xsd:string"/>
          <xsd:element name="snippet" type="xsd:string"/>
          <xsd:element name="title" type="xsd:string"/>
          <xsd:element name="cachedSize" type="xsd:string"/>
          <xsd:element name="relatedInformationPresent" type="xsd:boolean"/>
          <xsd:element name="hostName" type="xsd:string"/>
          <xsd:element name="directoryCategory" type="typens:DirectoryCategory"/>
          <xsd:element name="directoryTitle" type="xsd:string"/>
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="ResultElementArray">
        <xsd:complexContent>
          <xsd:restriction base="soapenc:Array">
             <xsd:attribute ref="soapenc:arrayType" wsdl:arrayType="typens:ResultElement[]"/>
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="DirectoryCategoryArray">
        <xsd:complexContent>
          <xsd:restriction base="soapenc:Array">
             <xsd:attribute ref="soapenc:arrayType" wsdl:arrayType="typens:DirectoryCategory[]"/>
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="DirectoryCategory">
        <xsd:all>
          <xsd:element name="fullViewableName" type="xsd:string"/>
          <xsd:element name="specialEncoding" type="xsd:string"/>
        </xsd:all>
      </xsd:complexType>

    </xsd:schema>
  </types>

  <!-- Messages for Google Web APIs - cached page, search, spelling. -->

  <message name="doGetCachedPage">
    <part name="key"            type="xsd:string"/>
    <part name="url"            type="xsd:string"/>
  </message>

  <message name="doGetCachedPageResponse">
    <part name="return"         type="xsd:base64Binary"/>
  </message>

  <message name="doSpellingSuggestion">
    <part name="key"            type="xsd:string"/>
    <part name="phrase"         type="xsd:string"/>
  </message>

  <message name="doSpellingSuggestionResponse">
    <part name="return"         type="xsd:string"/>
  </message>

  <!-- note, ie and oe are ignored by server; all traffic is UTF-8. -->

  <message name="doGoogleSearch">
    <part name="key"            type="xsd:string"/>
    <part name="q"              type="xsd:string"/>
    <part name="start"          type="xsd:int"/>
    <part name="maxResults"     type="xsd:int"/>
    <part name="filter"         type="xsd:boolean"/>
    <part name="restrict"       type="xsd:string"/>
    <part name="safeSearch"     type="xsd:boolean"/>
    <part name="lr"             type="xsd:string"/>
    <part name="ie"             type="xsd:string"/>
    <part name="oe"             type="xsd:string"/>
  </message>

  <message name="doGoogleSearchResponse">
    <part name="return"         type="typens:GoogleSearchResult"/>
  </message>

  <!-- Port for Google Web APIs, "GoogleSearch" -->

  <portType name="GoogleSearchPort">

    <operation name="doGetCachedPage">
      <input message="typens:doGetCachedPage"/>
      <output message="typens:doGetCachedPageResponse"/>
    </operation>

    <operation name="doSpellingSuggestion">
      <input message="typens:doSpellingSuggestion"/>
      <output message="typens:doSpellingSuggestionResponse"/>
    </operation>

    <operation name="doGoogleSearch">
      <input message="typens:doGoogleSearch"/>
      <output message="typens:doGoogleSearchResponse"/>
    </operation>

  </portType>


  <!-- Binding for Google Web APIs - RPC, SOAP over HTTP -->

  <binding name="GoogleSearchBinding" type="typens:GoogleSearchPort">
    <soap:binding style="rpc"
                  transport="http://schemas.xmlsoap.org/soap/http"/>

    <operation name="doGetCachedPage">
      <soap:operation soapAction="urn:GoogleSearchAction"/>
      <input>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </input>
      <output>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </output>
    </operation>

    <operation name="doSpellingSuggestion">
      <soap:operation soapAction="urn:GoogleSearchAction"/>
      <input>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </input>
      <output>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </output>
    </operation>

    <operation name="doGoogleSearch">
      <soap:operation soapAction="urn:GoogleSearchAction"/>
      <input>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </input>
      <output>
        <soap:body use="encoded"
                   namespace="urn:GoogleSearch"
                   encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
      </output>
    </operation>
  </binding>

  <!-- Endpoint for Google Web APIs -->
  <service name="GoogleSearchService">
    <port name="GoogleSearchPort" binding="typens:GoogleSearchBinding">
      <soap:address location="http://api.google.com/search/beta2"/>
    </port>
  </service>

</definitions>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Mockable
{
    public $constructorArgs;

    public $cloned;

    public function __construct($arg1 = null, $arg2 = null)
    {
        $this->constructorArgs = [$arg1, $arg2];
    }

    public function __clone()
    {
        $