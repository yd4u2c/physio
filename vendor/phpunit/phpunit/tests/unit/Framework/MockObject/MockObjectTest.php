otPrintAdditionalInformationForIncompleteTestByDefault(): void
    {
        $this->printer->startTest($this);
        $this->printer->addIncompleteTest($this, new Exception, 0);
        $this->printer->endTest($this, 0.001);

        $this->assertNotContains('│', $this->printer->getBuffer());
    }

    public function testPrintsAdditionalInformationForIncompleteTestInVerboseMode(): void
    {
        $this->verbosePrinter->startTest($this);
        $this->verbosePrinter->addIncompleteTest($this, new Exception('E_X_C_E_P_T_I_O_N'), 0);
        $this->verbosePrinter->endTest($this, 0.001);

        $this->assertContains('│', $this->verbosePrinter->getBuffer());
        $this->assertContains('E_X_C_E_P_T_I_O_N', $this->verbosePrinter->getBuffer());
    }

    public function testPrintsRadioactiveSymbolForRiskyTest(): void
    {
        $this->printer->startTest($this);
        $this->printer->addRiskyTest($this, new Exception, 0);
        $this->printer->endTest($this, 0.001);

        $this->assertContains('☢', $this->printer->getBuffer());
    }

    public function testDoesNotPrintAdditionalInformationForRiskyTestByDefault(): void
    {
        $this->printer->startTest($this);
        $this->printer->addRiskyTest($this, new Exception, 0);
        $this->printer->endTest($this, 0.001);

        $this->assertNotContains('│', $this->printer->getBuffer());
    }

    public function testPrintsAdditionalInformationForRiskyTestInVerboseMode(): void
    {
        $this->verbosePrinter->startTest($this);
        $this->verbosePrinter->addRiskyTest($this, new Exception, 0);
        $this->verbosePrinter->endTest($this, 0.001);

        $this->assertContains('│', $this->verbosePrinter->getBuffer());
    }

    public function testPrintsArrowForSkippedTest(): void
    {
        $this->printer->startTest($this);
        $this->printer->addSkippedTest($this, new Exception, 0);
        $this->printer->endTest($this, 0.001);

        $this->assertContains('→', $this->printer->getBuffer());
    }

    public function testDoesNotPrintAdditionalInformationForSkippedTestByDefault(): void
    {
        $this->printer->startTest($this);
        $this->printer->addSkippedTest($this, new Exception, 0);
        $this->printer->endTest($this, 0.001);

        $this->assertNotContains('│', $this->printer->getBuffer());
    }

    public function testPrintsAdditionalInformationForSkippedTestInVerboseMode(): void
    {
        $this->verbosePrinter->startTest($this);
        $this->verbosePrinter->addSkippedTest($this, new Exception('S_K_I_P_P_E_D'), 0);
        $this->verbosePrinter->endTest($this, 0.001);

        $this->assertContains('│', $this->verbosePrinter->getBuffer());
        $this->assertContains('S_K_I_P_P_E_D', $this->verbosePrinter->getBuffer());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Util\TestDox;

use PHPUnit\Framework\TestCase;

class NamePrettifierTest extends TestCase
{
    /**
     * @var NamePrettifier
     */
    private $namePrettifier;

    protected function setUp(): void
    {
        $this->namePrettifier = new NamePrettifier;
    }

    protected function tearDown(): void
    {
        $this->namePrettifier = null;
    }

    public function testTitleHasSensibleDefaults(): void
    {
        $this->assertEquals('Foo', $this->namePrettifier->prettifyTestClass('FooTest'));
        $this->assertEquals('Foo', $this->namePrettifier->prettifyTestClass('TestFoo'));
        $this->assertEquals('Foo', $this->namePrettifier->prettifyTestClass('TestFooTest'));
        $this->assertEquals('Foo', $this->namePrettifier->prettifyTestClass('Test\FooTest'));
        $this->assertEquals('Foo', $this->namePrettifier->prettifyTestClass('Tests\FooTest'));
    }

    public function testTestNameIsConvertedToASentence(): void
    {
        $this->assertEquals('This is a test', $this->namePrettifier->prettifyTestMethod('testThisIsATest'));
        $this->assertEquals('This is a test', $this->namePrettifier->prettifyTestMethod('testThisIsATest2'));
        $this->assertEquals('This is a test', $this->namePrettifier->prettifyTestMethod('this_is_a_test'));
        $this->assertEquals('This is a test', $this->namePrettifier->prettifyTestMethod('test_this_is_a_test'));
        $this->assertEquals('Foo for bar is 0', $this->namePrettifier->prettifyTestMethod('testFooForBarIs0'));
        $this->assertEquals('Foo for baz is 1', $this->namePrettifier->prettifyTestMethod('testFooForBazIs1'));
        $this->assertEquals('This has a 123 in its name', $this->namePrettifier->prettifyTestMethod('testThisHasA123InItsName'));
        $this->assertEquals('', $this->namePrettifier->prettifyTestMethod('test'));
    }

    /**
     * @ticket 224
     */
    public function testTestNameIsNotGroupedWhenNotInSequence(): void
    {
        $this->assertEquals('Sets redirect header on 301', $this->namePrettifier->prettifyTestMethod('testSetsRedirectHeaderOn301'));
        $this->assertEquals('Sets redirect header on 302', $this->namePrettifier->prettifyTestMethod('testSetsRedirectHeaderOn302'));
    }

    public function testPhpDoxIgnoreDataKeys(): void
    {
        $test = new class extends TestCase {
            public function __construct()
            {
                parent::__construct('testAddition', [
                    'augend' => 1,
                    'addend' => 2,
                    'result' => 3,
                ]);
            }

            public function testAddition(int $augend, int $addend, int $result): void
            {
            }

            public function getAnnotations(): array
            {
                return [
                    'method' => [
                        'testdox' => ['$augend + $addend = $result'],
                    ],
                ];
            }
        };

        $this->assertEquals('1 + 2 = 3', $this->namePrettifier->prettifyTestCase($test));
    }

    public function testPhpDoxUsesDefaultValue(): void
    {
        $test = new class extends TestCase {
            public function __construct()
            {
                parent::__construct('testAddition', []);
            }

            public function testAddition(int $augend = 1, int $addend = 2, int $result = 3): void
            {
            }

            public function getAnnotations(): array
            {
                return [
                    'method' => [
                        'testdox' => ['$augend + $addend = $result'],
                    ],
                ];
            }
        };

        $this->assertEquals('1 + 2 = 3', $this->namePrettifier->prettifyTestCase($test));
    }

    public function testPhpDoxArgumentExporting(): void
    {
        $test = new class extends TestCase {
            public function __construct()
            {
                parent::__construct('testExport', [
                    'int'      => 1234,
                    'strInt'   => '1234',
                    'float'    => 2.123,
                    'strFloat' => '2.123',
                    'string'   => 'foo',
                    'bool'     => true,
                    'null'     => null,
                ]);
            }

            public function testExport($int, $strInt, $float, $strFloat, $string, $bool, $null): void
            {
            }

            public function getAnnotations(): array
            {
                return [
                    'method' => [
                        'testdox' => ['$int, $strInt, $float, $strFloat, $string, $bool, $null'],
                    ],
                ];
            }
        };

        $this->assertEquals('1234, 1234, 2.123, 2.123, foo, true, NULL', $this->namePrettifier->prettifyTestCase($test));
    }

    public function testPhpDoxReplacesLongerVariablesFirst(): void
    {
        $test = new class extends TestCase {
            public function __construct()
            {
                parent::__construct('testFoo', []);
            }

            public function testFoo(int $a = 1, int $ab = 2, int $abc = 3): void
            {
            }

            public function getAnnotations(): array
            {
                return [
                    'method' => [
                        'testdox' => ['$a, "$a", $a$ab, $abc, $abcd, $ab'],
                    ],
                ];
            }
        };

        $this->assertEquals('1, "1", 12, 3, $abcd, 2', $this->namePrettifier->prettifyTestCase($test));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns="http://schemas.xmlsoap.org/wsdl/" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:tns="http://some-web-service.com/CustomUI" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsdLocal0="http://www.some-web-service.com/xml/ContactInformation" targetNamespace="http://some-web-service.com/CustomUI">
    <message name="Contact_Information_Input">
        <part name="Contact_Id" type="xsd:string" />
    </message>
    <message name="Contact_Information_Output">
        <part name="Response_Code" type="xsd:string" />
        <part name="Response_Message" type="xsd:string" />
    </message>
    <portType name="Contact_Information">
        <operation name="Contact_Information">
            <input message="tns:Contact_Information_Input" />
            <output message="tns:Contact_Information_Output" />
        </operation>
    </portType>
    <binding name="Contact_Information" type="tns:Contact_Information">
        <soap:binding transport="http://schemas.xmlsoap.org/soap/http" style="rpc" />
        <operation name="Contact_Information">
            <soap:operation soapAction="rpc/http://some-web-service.com/CustomUI:Contact_Information" />
            <input>
                <soap:body namespace="http://some-web-service.com/CustomUI" use="literal" />
            </input>
            <output>
                <soap:body namespace="http://some-web-service.com/CustomUI" use="literal" />
            </output>
        </operation>
    </binding>
    <service name="Web_Service">
        <port binding="tns:Contact_Information" name="Contact_Information">
            <soap:address location="https://some-web-service.com" />
        </port>
    </service>
</definitions>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              INDX( 	 �^�             (   �  �       s h   �  �c          $     h R     $     ��o�pk� O�
���w���<���o�pk��      �               3 1 9 4 . p h p       !$     h T     $     ZQt�pk� O�
��ي��<�ZQt�pk�                     	 3 5 3 0 . w s d l     "$     � t     $     �R�pk� O�
���;���<��R�pk��      �               A b s t r a c t M o c k T e s t C l a s s . p h p     #$     x b     $     #�V�pk� O�
���;���<�#�V�pk��      �               A b s t r a c t T e  t . p h p       $$     x d     $     4Y�pk� O�
�������<�4Y�pk��      �               A b s t r a c t T r a i t . p h p     %$     p `     $     ��]�pk� O�
�� ���<���]�pk�(      !               A n I n t e r f a c e . p h p &$     � |     $     L�b�pk� O�
�� ���<�L�b�pk�8      8               A n I n t e r f a c e W i t h R e t u r n T y p e . p h p     '$     � j     $     �g�pk� O�
��nc���<��g�pk�0      *               A n o t h e r I n t e r f a c e . p  p       ($     x h     $     8�n�pk� O�
���Ė��<�8�n�pk�       �               A r r a y A c c e s s i b l e . p h p )$     � j     $     ?�u�pk� O�
��0(���<�?�u�pk�P      K               A s s e r t i o n E x a m p l e . p h p       *$     � r     $     �z�pk� O�
�������<��z�pk��      �               A s s e r t i o n E x a m p l e T e s t . p h p       +$     h V     $     6�|�pk� O�
�������<�6�|�pk��      �              
 A u t h o r . p h p   ,$     p `    $     ����pk� O�
��읯�<�����pk�                      B a n k A c c o u n t . p h p -$     x h     $     ㈌pk� O�
��FO���<�㈌pk�       �               B a n k A c c o u n t T e s t . p h p .$     � r     $     F��pk� O�
��FO���<�F��pk�                      B a n k A c c o u n t T e s t . t e s t . p h p       /$     � j     $     �
��pk� O�
�������<��
��pk�       �               B a n k A c c o u n t T e s t 2 . p h p                     $     �l��pk  O�
������<��l��pk�@      =               B a r . p h p 1$     ` P     $     �Δ�pk� O�
��[u���<��Δ�pk�                       b a r . x m l 2$     � n     $     ����pk� O�
��[u���<�����pk�       <               B e f o r e A n d A f t e r T e s t . p h p   3$     � �     $     ����pk� O�
���ة��<�����pk�       �                B e f o r e C l a s s A n d A f t e r C l a s s T e s t . p h p       4$     � �     $     y��pk� O�
��;���<�y��pk�       8             ' B e f o r e C l a s s W i t h O n l y D a t a P r o v i d e r T e s t . p h p 5$     h R     $     �᧌pk� O�
��;���<��᧌pk�`      ^               B o o k . p h p       6$     p ^     $     3���pk� O�
��b����<�3���pk��      �               C a l c u l a t o r . p h p   7$     � �     $     k��pk� O�
�������<�k��pk��      �              % C h a n g e C u r r e n t W o r k i n g D i r e c t o r y T e s t . p h p     8$     � �     $     �0��pk� O�
��a���< �0��pk�(      "              # C l a s s T h a t I m p l e m e n t s S e r i a l i z a b l e . p h p 9$     � �     $      W��pk� O�
��yĵ��<� W��pk�       d              # C l a s s W i t h A l l P o s s i b l e R e t u r n T y p e s . p h p :$     � �     $     `ȍpk� O�
��yĵ��<�`ȍpk�       �                C l a s s W i t h N o n P u b l i c A t t r i b u t e s . p h p       ;$     � �     $     �#͍pk� O�
���%���<��#͍pk�X      R              # C l a s s W i t h S  a l a r T y p e D e c l a r a t i o n s . p h p <$     � t     $     C�эpk� O�
��@����<�C�эpk�8      3               C l a s s W i t h S e l f T y p e H i n t . p h p     =$     � t     $     Kԍpk� O�
��@����<�Kԍpk�@      :               C l a s s W i t h S t a t i c M e t h o d . p h p     >$     � l     $     #�֍pk� O�
���꼯�<�#�֍pk��      �               C l a s s W i t h T o S t r i n g . p h p                                                                  <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ArrayAccessible implements ArrayAccess, IteratorAggregate
{
    private $array;

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    public function offsetExists($offset)
    {
        return \array_key_exists($offset, $this->array);
    }

    public function offsetGet($offset)
    {
        return $this->array[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->array[$offset]);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->array);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class BankAccountException extends RuntimeException
{
}

/**
 * A bank account.
 */
class BankAccount
{
    /**
     * The bank account's balance.
     *
     * @var float
     */
    protected $balance = 0;

    /**
     * Returns the bank account's balance.
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Deposits an amount of money to the bank account.
     *
     * @param float $balance
     *
     * @throws BankAccountException
     */
    public function depositMoney($balance)
    {
        $this->setBalance($this->getBalance() + $balance);

        return $this->getBalance();
    }

    /**
     * Withdraws an amount of money from the bank account.
     *
     * @param float $balance
     *
     * @throws BankAccountException
     */
    public function withdrawMoney($balance)
    {
        $this->setBalance($this->getBalance() - $balance);

        return $this->getBalance();
    }

    /**
     * Sets the bank account's balance.
     *
     * @param float $balance
     *
     * @throws BankAccountException
     */
    protected function setBalance($balance): void
    {
        if ($balance >= 0) {
            $this->balance = $balance;
        } else {
            throw new BankAccountException;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;

/**
 * Tests for the BankAccount class.
 */
class BankAccountTest extends TestCase
{
    protected $ba;

    protected function setUp(): void
    {
        $this->ba = new BankAccount;
    }

    /**
     * @covers BankAccount::getBalance
     * @group balanceIsInitiallyZero
     * @group specification
     */
    public function testBalanceIsInitiallyZero(): void
    {
        /* @Given a fresh bank account */
        $ba = new BankAccount;

        /* @When I ask it for its balance */
        $balance = $ba->getBalance();

        /* @Then I should get 0 */
        $this->assertEquals(0, $balance);
    }

    /**
     * @covers BankAccount::withdrawMoney
     * @group balanceCannotBecomeNegative
     * @group specification
     */
    public function testBalanceCannotBecomeNegative(): void
    {
        try {
            $this->ba->withdrawMoney(1);
        } catch (BankAccountException $e) {
            $this->assertEquals(0, $this->ba->getBalance());

            return;
        }

        $this->fail();
    }

    /**
     * @covers BankAccount::depositMoney
     * @group balanceCannotBecomeNegative
     * @group specification
     */
    public function testBalanceCannotBecomeNegative2(): void
    {
        try {
            $this->ba->depositMoney(-1);
        } catch (BankAccountException $e) {
            $this->assertEquals(0, $this->ba->getBalance());

            return;
        }

        $this->fail();
    }

    /*
     * @covers BankAccount::getBalance
     * @covers BankAccount::depositMoney
     * @covers BankAccount::withdrawMoney
     * @group balanceCannotBecomeNegative
     */
    /*
    public function testDepositingAndWithdrawingMoneyWorks()
    {
        $this->assertEquals(0, $this->ba->getBalance());
        $this->ba->depositMoney(1);
        $this->assertEquals(1, $this->ba->getBalance());
        $this->ba->withdrawMoney(1);
        $this->assertEquals(0, $this->ba->getBalance());
    }
    */
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;

/**
 * Tests for the BankAccount class.
 */
class BankAccountWithCustomExtensionTest extends TestCase
{
    protected $ba;

    protected function setUp(): void
    {
        $this->ba = new BankAccount;
    }

    /**
     * @covers BankAccount::getBalance
     * @group balanceIsInitiallyZero
     * @group specification
     */
    public function testBalanceIsInitiallyZero(): void
    {
        $this->assertEquals(0, $this->ba->getBalance());
    }

    /**
     * @covers BankAccount::withdrawMoney
     * @group balanceCannotBecomeNegative
     * @group specification
     */
    public function testBalanceCannotBecomeNegative(): void
    {
        try {
            $this->ba->withdrawMoney(1);
        } catch (BankAccountException $e) {
            $this->assertEquals(0, $this->ba->getBalance());

            return;
        }

        $this->fail();
    }

    /**
     * @covers BankAccount::depositMoney
     * @group balanceCannotBecomeNegative
     * @group specification
     */
    public function testBalanceCannotBecomeNegative2(): void
    {
        try {
            $this->ba->depositMoney(-1);
        } catch (BankAccountException $e) {
            $this->assertEquals(0, $this->ba->getBalance());

            return;
        }

        $this->fail();
    }

    /*
     * @covers BankAccount::getBalance
     * @covers BankAccount::depositMoney
     * @covers BankAccount::withdrawMoney
     * @group balanceCannotBecomeNegative
     */
    /*
    public function testDepositingAndWithdrawingMoneyWorks()
    {
        $this->assertEquals(0, $this->ba->getBalance());
        $this->ba->depositMoney(1);
        $this->assertEquals(1, $this->ba->getBalance());
        $this->ba->withdrawMoney(1);
        $this->assertEquals(0, $this->ba->getBalance());
    }
    */
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    