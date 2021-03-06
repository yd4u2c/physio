<?php

namespace Faker\Test\Provider;

use Faker\Generator;
use Faker\Provider\Barcode;
use PHPUnit\Framework\TestCase;

class BarcodeTest extends TestCase
{
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Barcode($faker));
        $faker->seed(0);
        $this->faker = $faker;
    }

    public function testEan8()
    {
        $code = $this->faker->ean8();
        $this->assertRegExp('/^\d{8}$/i', $code);
        $codeWithoutChecksum = substr($code, 0, -1);
        $checksum = substr($code, -1);
        $this->assertEquals(TestableBarcode::eanChecksum($codeWithoutChecksum), $checksum);
    }

    public function testEan13()
    {
        $code = $this->faker->ean13();
        $this->assertRegExp('/^\d{13}$/i', $code);
        $codeWithoutChecksum = substr($code, 0, -1);
        $checksum = substr($code, -1);
        $this->assertEquals(TestableBarcode::eanChecksum($codeWithoutChecksum), $checksum);
    }
}

class TestableBarcode extends Barcode
{
    public static function eanChecksum($input)
    {
        return parent::eanChecksum($input);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

namespace Faker\Test\Provider;

use Faker\Provider\Base as BaseProvider;
use PHPUnit\Framework\TestCase;
use Traversable;

class BaseTest extends TestCase
{
    public function testRandomDigitReturnsInteger()
    {
        $this->assertInternalType('integer', BaseProvider::randomDigit());
    }

    public function testRandomDigitReturnsDigit()
    {
        $this->assertGreaterThanOrEqual(0, BaseProvider::randomDigit());
        $this->assertLessThan(10, BaseProvider::randomDigit());
    }

    public function testRandomDigitNotNullReturnsNotNullDigit()
    {
        $this->assertGreaterThan(0, BaseProvider::randomDigitNotNull());
        $this->assertLessThan(10, BaseProvider::randomDigitNotNull());
    }


    public function testRandomDigitNotReturnsValidDigit()
    {
        for ($i = 0; $i <= 9; $i++) {
            $this->assertGreaterThanOrEqual(0, BaseProvider::randomDigitNot($i));
            $this->assertLessThan(10, BaseProvider::randomDigitNot($i));
            $this->assertNotSame(BaseProvider::randomDigitNot($i), $i);
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRandomNumberThrowsExceptionWhenCalledWithAMax()
    {
        BaseProvider::randomNumber(5, 200);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRandomNumberThrowsExceptionWhenCalledWithATooHighNumberOfDigits()
    {
        BaseProvider::randomNumber(10);
    }

    public function testRandomNumberReturnsInteger()
    {
        $this->assertInternalType('integer', BaseProvider::randomNumber());
        $this->assertInternalType('integer', BaseProvider::randomNumber(5, false));
    }

    public function testRandomNumberReturnsDigit()
    {
        $this->assertGreaterThanOrEqual(0, BaseProvider::randomNumber(3));
        $this->assertLessThan(1000, BaseProvider::randomNumber(3));
    }

    public function testRandomNumberAcceptsStrictParamToEnforceNumberSize()
    {
        $this->assertEquals(5, strlen((string) BaseProvider::randomNumber(5, true)));
    }

    public function testNumberBetween()
    {
        $min = 5;
        $max = 6;

        $this->assertGreaterThanOrEqual($min, BaseProvider::numberBetween($min, $max));
        $this->assertGreaterThanOrEqual(BaseProvider::numberBetween($min, $max), $max);
    }

    public function testNumberBetweenAcceptsZeroAsMax()
    {
        $this->assertEquals(0, BaseProvider::numberBetween(0, 0));
    }

    public function testRandomFloat()
    {
        $min = 4;
        $max = 10;
        $nbMaxDecimals = 8;

        $result = BaseProvider::randomFloat($nbMaxDecimals, $min, $max);

        $parts = explode('.', $result);

        $this->assertInternalType('float', $result);
        $this->assertGreaterThanOrEqual($min, $result);
        $this->assertLessThanOrEqual($max, $result);
        $this->assertLessThanOrEqual($nbMaxDecimals, strlen($parts[1]));
    }

    public function testRandomLetterReturnsString()
    {
        $this->assertInternalType('string', BaseProvider::randomLetter());
    }

    public function testRandomLetterReturnsSingleLetter()
    {
        $this->assertEquals(1, strlen(BaseProvider::randomLetter()));
    }

    public function testRandomLetterReturnsLowercaseLetter()
    {
        $lowercaseLetters = 'abcdefghijklmnopqrstuvwxyz';
        $this->assertNotFalse(strpos($lowercaseLetters, BaseProvider::randomLetter()));
    }

    public function testRandomAsciiReturnsString()
    {
        $this->assertInternalType('string', BaseProvider::randomAscii());
    }

    public function testRandomAsciiReturnsSingleCharacter()
    {
        $this->assertEquals(1, strlen(BaseProvider::randomAscii()));
    }

    public function testRandomAsciiReturnsAsciiCharacter()
    {
        $lowercaseLetters = '!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
        $this->assertNotFalse(strpos($lowercaseLetters, BaseProvider::randomAscii()));
    }

    public function testRandomElementReturnsNullWhenArrayEmpty()
    {
        $this->assertNull(BaseProvider::randomElement(array()));
    }

    public function testRandomElementReturnsNullWhenCollectionEmpty()
    {
        $this->assertNull(BaseProvider::randomElement(new Collection(array())));
    }

    public function testRandomElementReturnsElementFromArray()
    {
        $elements = array('23', 'e', 32, '#');
        $this->assertContains(BaseProvider::randomElement($elements), $elements);
    }

    public function testRandomElementReturnsElementFromAssociativeArray()
    {
        $elements = array('tata' => '23', 'toto' => 'e', 'tutu' => 32, 'titi' => '#');
        $this->assertContains(BaseProvider::randomElement($elements), $elements);
    }

    public function testRandomElementReturnsElementFromCollection()
    {
        $collection = new Collection(array('one', 'two', 'three'));
        $this->assertContains(BaseProvider::randomElement($collection), $collection);
    }

    public function testShuffleReturnsStringWhenPassedAStringArgument()
    {
        $this->assertInternalType('string', BaseProvider::shuffle('foo'));
    }

    public function testShuffleReturnsArrayWhenPassedAnArrayArgument()
    {
        $this->assertInternalType('array', BaseProvider::shuffle(array(1, 2, 3)));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShuffleThrowsExceptionWhenPassedAnInvalidArgument()
    {
        BaseProvider::shuffle(false);
    }

    public function testShuffleArraySupportsEmptyArrays()
    {
        $this->assertEquals(array(), BaseProvider::shuffleArray(array()));
    }

    public function testShuffleArrayReturnsAnArrayOfTheSameSize()
    {
        $array = array(1, 2, 3, 4, 5);
        $this->assertSameSize($array, BaseProvider::shuffleArray($array));
    }

    public function testShuffleArrayReturnsAnArrayWithSameElements()
    {
        $array = array(2, 4, 6, 8, 10);
        $shuffleArray = BaseProvider::shuffleArray($array);
        $this->assertContains(2, $shuffleArray);
        $this->assertContains(4, $shuffleArray);
        $this->assertContains(6, $shuffleArray);
        $this->assertContains(8, $shuffleArray);
        $this->assertContains(10, $shuffleArray);
    }

    public function testShuffleArrayReturnsADifferentArrayThanTheOriginal()
    {
        $arr = array(1, 2, 3, 4, 5);
        $shuffledArray = BaseProvider::shuffleArray($arr);
        $this->assertNotEquals($arr, $shuffledArray);
    }

    public function testShuffleArrayLeavesTheOriginalArrayUntouched()
    {
        $arr = array(1, 2, 3, 4, 5);
        BaseProvider::shuffleArray($arr);
        $this->assertEquals($arr, array(1, 2, 3, 4, 5));
    }

    public function testShuffleStringSupportsEmptyStrings()
    {
        $this->assertEquals('', BaseProvider::shuffleString(''));
    }

    public function testShuffleStringReturnsAnStringOfTheSameSize()
    {
        $string = 'abcdef';
        $this->assertEquals(strlen($string), strlen(BaseProvider::shuffleString($string)));
    }

    public function testShuffleStringReturnsAnStringWithSameElements()
    {
        $string = 'acegi';
        $shuffleString = BaseProvider::shuffleString($string);
        $this->assertContains('a', $shuffleString);
        $this->assertContains('c', $shuffleString);
        $this->assertContains('e', $shuffleString);
        $this->assertContains('g', $shuffleString);
        $this->assertContains('i', $shuffleString);
    }

    public function testShuffleStringReturnsADifferentStringThanTheOriginal()
    {
        $string = 'abcdef';
        $shuffledString = BaseProvider::shuffleString($string);
        $this->assertNotEquals($string, $shuffledString);
    }

    public function testShuffleStringLeavesTheOriginalStringUntouched()
    {
        $string = 'abcdef';
        BaseProvider::shuffleString($string);
        $this->assertEquals($string, 'abcdef');
    }

    public function testNumerifyReturnsSameStringWhenItContainsNoHashSign()
    {
        $this->assertEquals('fooBar?', BaseProvider::numerify('fooBar?'));
    }

    public function testNumerifyReturnsStringWithHashSignsReplacedByDigits()
    {
        $this->assertRegExp('/foo\dBa\dr/', BaseProvider::numerify('foo#Ba#r'));
    }

    public function testNumerifyReturnsStringWithPercentageSignsReplacedByDigits()
    {
        $this->assertRegExp('/foo\dBa\dr/', BaseProvider::numerify('foo%Ba%r'));
    }

    public function testNumerifyReturnsStringWithPercentageSignsReplacedByNotNullDigits()
    {
        $this->assertNotEquals('0', BaseProvider::numerify('%'));
    }

    public function testNumerifyCanGenerateALargeNumberOfDigits()
    {
        $largePattern = str_repeat('#', 20); // definitely larger than PHP_INT_MAX on all systems
        $this->assertEquals(20, strlen(BaseProvider::numerify($largePattern)));
    }

    public function testLexifyReturnsSameStringWhenItContainsNoQuestionMark()
    {
        $this->assertEquals('fooBar#', BaseProvider::lexify('fooBar#'));
    }

    public function testLexifyReturnsStringWithQuestionMarksReplacedByLetters()
    {
        $this->assertRegExp('/foo[a-z]Ba[a-z]r/', BaseProvider::lexify('foo?Ba?r'));
    }

    public function testBothifyCombinesNumerifyAndLexify()
    {
        $this->assertRegExp('/foo[a-z]Ba\dr/', BaseProvider::bothify('foo?Ba#r'));
    }

    public function testBothifyAsterisk()
    {
        $this->assertRegExp('/foo([a-z]|\d)Ba([a-z]|\d)r/', BaseProvider::bothify('foo*Ba*r'));
    }

    public function testBothifyUtf()
    {
        $utf = 'œ∑´®†¥¨ˆøπ“‘和製╯°□°╯︵ ┻━┻🐵 🙈 ﺚﻣ ﻦﻔﺳ ﺲﻘﻄﺗ ﻮﺑﺎﻠﺘﺣﺪﻳﺩ،, ﺝﺰﻳﺮﺘﻳ ﺏﺎﺴﺘﺧﺩﺎﻣ ﺄﻧ ﺪﻧﻭ. ﺇﺫ ﻪﻧﺍ؟ ﺎﻠﺴﺗﺍﺭ ﻮﺘ';
        $this->assertRegExp('/'.$utf.'foo\dB[a-z]a([a-z]|\d)r/u', BaseProvider::bothify($utf.'foo#B?a*r'));
    }

    public function testAsciifyReturnsSameStringWhenItContainsNoStarSign()
    {
        $this->assertEquals('fooBar?', BaseProvider::asciify('fooBar?'));
    }

    public function testAsciifyReturnsStringWithStarSignsReplacedByAsciiChars()
    {
        $this->assertRegExp('/foo.Ba.r/', BaseProvider::asciify('foo*Ba*r'));
    }

    public function regexifyBasicDataProvider()
    {
        return array(
            array('azeQSDF1234', 'azeQSDF1234', 'does not change non regex chars'),
            array('foo(bar){1}', 'foobar', 'replaces regex characters'),
            array('', '', 'supports empty string'),
            array('/^foo(bar){1}$/', 'foobar', 'ignores regex delimiters')
        );
    }

    /**
     * @dataProvider regexifyBasicDataProvider
     */
    public function testRegexifyBasicFeatures($input, $output, $message)
    {
        $this->assertEquals($output, BaseProvider::regexify($input), $message);
    }

    public function regexifyDataProvider()
    {
        return array(
            array('\d', 'numbers'),
            array('\w', 'letters'),
            array('(a|b)', 'alternation'),
            array('[aeiou]', 'basic character class'),
            array('[a-z]', 'character class range'),
            array('[a-z1-9]', 'multiple character class range'),
            array('a*b+c?', 'single character quantifiers'),
            array('a{2}', 'brackets quantifiers'),
            array('a{2,3}', 'min-max brackets quantifiers'),
            array('[aeiou]{2,3}', 'brackets quantifiers on basic character class'),
            array('[a-z]{2,3}', 'brackets quantifiers on character class range'),
            array('(a|b){2,3}', 'brackets quantifiers on alternation'),
            array('\.\*\?\+', 'escaped characters'),
            array('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}', 'complex regex')
        );
    }

    /**
     * @dataProvider regexifyDataProvider
     */
    public function testRegexifySupportedRegexSyntax($pattern, $message)
    {
        $this->assertRegExp('/' . $pattern . '/', BaseProvider::regexify($pattern), 'Regexify supports ' . $message);
    }

    public function testOptionalReturnsProviderValueWhenCalledWithWeight1()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $this->assertNotNull($faker->optional(100)->randomDigit);
    }

    public function testOptionalReturnsNullWhenCalledWithWeight0()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $this->assertNull($faker->optional(0)->randomDigit);
    }

    public function testOptionalAllowsChainingPropertyAccess()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $faker->addProvider(new \ArrayObject(array(1))); // hack because method_exists forbids stubs
        $this->assertEquals(1, $faker->optional(100)->count);
        $this->assertNull($faker->optional(0)->count);
    }

    public function testOptionalAllowsChainingMethodCall()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $faker->addProvider(new \ArrayObject(array(1))); // hack because method_exists forbids stubs
        $this->assertEquals(1, $faker->optional(100)->count());
        $this->assertNull($faker->optional(0)->count());
    }

    public function testOptionalAllowsChainingProviderCallRandomlyReturnNull()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $values = array();
        for ($i=0; $i < 10; $i++) {
            $values[]= $faker->optional()->randomDigit;
        }
        $this->assertContains(null, $values);

        $values = array();
        for ($i=0; $i < 10; $i++) {
            $values[]= $faker->optional(50)->randomDigit;
        }
        $this->assertContains(null, $values);
    }

    /**
     * @link https://github.com/fzaninotto/Faker/issues/265
     */
    public function testOptionalPercentageAndWeight()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $faker->addProvider(new \Faker\Provider\Miscellaneous($faker));

        $valuesOld = array();
        $valuesNew = array();

        for ($i = 0; $i < 10000; ++$i) {
            $valuesOld[] = $faker->optional(0.5)->boolean(100);
            $valuesNew[] = $faker->optional(50)->boolean(100);
        }

        $this->assertEquals(
            round(array_sum($valuesOld) / 10000, 2),
            round(array_sum($valuesNew) / 10000, 2)
        );
    }

    public function testUniqueAllowsChainingPropertyAccess()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $faker->addProvider(new \ArrayObject(array(1))); // hack because method_exists forbids stubs
        $this->assertEquals(1, $faker->unique()->count);
    }

    public function testUniqueAllowsChainingMethodCall()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $faker->addProvider(new \ArrayObject(array(1))); // hack because method_exists forbids stubs
        $this->assertEquals(1, $faker->unique()->count());
    }

    public function testUniqueReturnsOnlyUniqueValues()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $values = array();
        for ($i=0; $i < 10; $i++) {
            $values[]= $faker->unique()->randomDigit;
        }
        sort($values);
        $this->assertEquals(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), $values);
    }

    /**
     * @expectedException OverflowException
     */
    public function testUniqueThrowsExceptionWhenNoUniqueValueCanBeGenerated()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        for ($i=0; $i < 11; $i++) {
            $faker->unique()->randomDigit;
        }
    }

    public function testUniqueCanResetUniquesWhenPassedTrueAsArgument()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $values = array();
        for ($i=0; $i < 10; $i++) {
            $values[]= $faker->unique()->randomDigit;
        }
        $values[]= $faker->unique(true)->randomDigit;
        for ($i=0; $i < 9; $i++) {
            $values[]= $faker->unique()->randomDigit;
        }
        sort($values);
        $this->assertEquals(array(0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9), $values);
    }

    public function testValidAllowsChainingPropertyAccess()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $this->assertLessThan(10, $faker->valid()->randomDigit);
    }

    public function testValidAllowsChainingMethodCall()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $this->assertLessThan(10, $faker->valid()->numberBetween(5, 9));
    }

    public function testValidReturnsOnlyValidValues()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $values = array();
        $evenValidator = function($digit) {
            return $digit % 2 === 0;
        };
        for ($i=0; $i < 50; $i++) {
            $values[$faker->valid($evenValidator)->randomDigit] = true;
        }
        $uniqueValues = array_keys($values);
        sort($uniqueValues);
        $this->assertEquals(array(0, 2, 4, 6, 8), $uniqueValues);
    }

    /**
     * @expectedException OverflowException
     */
    public function testValidThrowsExceptionWhenNoValidValueCanBeGenerated()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $evenValidator = function($digit) {
            return $digit % 2 === 0;
        };
        for ($i=0; $i < 11; $i++) {
            $faker->valid($evenValidator)->randomElement(array(1, 3, 5, 7, 9));
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidThrowsExceptionWhenParameterIsNotCollable()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\Base($faker));
        $faker->valid(12)->randomElement(array(1, 3, 5, 7, 9));
    }

    /**
     * @expectedException LengthException
     * @expectedExceptionMessage Cannot get 2 elements, only 1 in array
     */
    public function testRandomElementsThrowsWhenRequestingTooManyKeys()
    {
        BaseProvider::randomElements(array('foo'), 2);
    }

    public function testRandomElements()
    {
        $this->assertCount(1, BaseProvider::randomElements(), 'Should work without any input');

        $empty = BaseProvider::randomElements(array(), 0);
        $this->assertInternalType('array', $empty);
        $this->assertCount(0, $empty);

        $shuffled = BaseProvider::randomElements(array('foo', 'bar', 'baz'), 3);
        $this->assertContains('foo', $shuffled);
        $this->assertContains('bar', $shuffled);
        $this->assertContains('baz', $shuffled);

        $allowDuplicates = BaseProvider::randomElements(array('foo', 'bar'), 3, true);
        $this->assertCount(3, $allowDuplicates);
        $this->assertContainsOnly('string', $allowDuplicates);
    }
}

class Collection extends \ArrayObject
{
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
namespace Faker\Test\Provider;

use Faker\Provider\Biased;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class BiasedTest extends TestCase
{
    const MAX = 10;
    const NUMBERS = 25000;
    protected $generator;
    protected $results = array();

    protected function setUp()
    {
        $this->generator = new Generator();
        $this->generator->addProvider(new Biased($this->generator));

        $this->results = array_fill(1, self::MAX, 0);
    }

    public function performFake($function)
    {
        for($i = 0; $i < self::NUMBERS; $i++) {
            $this->results[$this->generator->biasedNumberBetween(1, self::MAX, $function)]++;
        }
    }

    public function testUnbiased()
    {
        $this->performFake(array('\Faker\Provider\Biased', 'unbiased'));

        // assert that all numbers are near the expected unbiased value
        foreach ($this->results as $number => $amount) {
            // integral
            $assumed = (1 / self::MAX * $number) - (1 / self::MAX * ($number - 1));
            // calculate the fraction of the whole area
            $assumed /= 1;
            $this->assertGreaterThan(self::NUMBERS * $assumed * .95, $amount, "Value was more than 5 percent under the expected value");
            $this->assertLessThan(self::NUMBERS * $assumed * 1.05, $amount, "Value was more than 5 percent over the expected value");
        }
    }

    public function testLinearHigh()
    {
        $this->performFake(array('\Faker\Provider\Biased', 'linearHigh'));

        foreach ($this->results as $number => $amount) {
            // integral
            $assumed = 0.5 * pow(1 / self::MAX * $number, 2) - 0.5 * pow(1 / self::MAX * ($number - 1), 2);
            // calculate the fraction of the whole area
            $assumed /= pow(1, 2) * .5;
            $this->assertGreaterThan(self::NUMBERS * $assumed * .9, $amount, "Value was more than 10 percent under the expected value");
            $this->assertLessThan(self::NUMBERS * $assumed * 1.1, $amount, "Value was more than 10 percent over the expected value");
        }
    }

    public function testLinearLow()
    {
        $this->performFake(array('\Faker\Provider\Biased', 'linearLow'));

        foreach ($this->results as $number => $amount) {
            // integral
            $assumed = -0.5 * pow(1 / self::MAX * $number, 2) - -0.5 * pow(1 / self::MAX * ($number - 1), 2);
            // shift the graph up
            $assumed += 1 / self::MAX;
            // calculate the fraction of the whole area
            $assumed /= pow(1, 2) * .5;
            $this->assertGreaterThan(self::NUMBERS * $assumed * .9, $amount, "Value was more than 10 percent under the expected value");
            $this->assertLessThan(self::NUMBERS * $assumed * 1.1, $amount, "Value was more than 10 percent over the expected value");
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Faker\Test\Provider;

use Faker\Provider\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{

    public function testHexColor()
    {
        $this->assertRegExp('/^#[a-f0-9]{6}$/i', Color::hexColor());
    }

    public function testSafeHexColor()
    {
        $this->assertRegExp('/^#[a-f0-9]{6}$/i', Color::safeHexColor());
    }

    public function testRgbColorAsArray()
    {
        $this->assertEquals(3, count(Color::rgbColorAsArray()));
    }

    public function testRgbColor()
    {
        $regexp = '([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])';
        $this->assertRegExp('/^' . $regexp . ',' . $regexp . ',' . $regexp . '$/i', Color::rgbColor());
    }

    public function testRgbCssColor()
    {
        $regexp = '([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])';
        $this->assertRegExp('/^rgb\(' . $regexp . ',' . $regexp . ',' . $regexp . '\)$/i', Color::rgbCssColor());
    }

    public function testRgbaCssColor()
    {
        $regexp = '([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])';
        $regexpAlpha = '([01]?(\.\d+)?)';
        $this->assertRegExp('/^rgba\(' . $regexp . ',' . $regexp . ',' . $regexp . ',' . $regexpAlpha . '\)$/i', Color::rgbaCssColor());
    }

    public function testSafeColorName()
    {
        $this->assertRegExp('/^[\w]+$/', Color::safeColorName());
    }

    public function testColorName()
    {
        $this->assertRegExp('/^[\w]+$/', Color::colorName());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Faker\Test\Provider;

use Faker\Provider\DateTime as DateTimeProvider;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    public function setUp()
    {
        $this->defaultTz = 'UTC';
        DateTimeProvider::setDefaultTimezone($this->defaultTz);
    }

    public function tearDown()
    {
        DateTimeProvider::setDefaultTimezone();
    }

    public function testPreferDefaultTimezoneOverSystemTimezone()
    {
        /**
         * Set the system timezone to something *other* than the timezone used
         * in setUp().
         */
        $originalSystemTimezone = date_default_timezone_get();
        $systemTimezone = 'Antarctica/Vostok';
        date_default_timezone_set($systemTimezone);

        /**
         * Get a new date/time value and assert that it prefers the default
         * timezone over the system timezone.
         */
        $date = DateTimeProvider::dateTime();
        $this->assertNotSame($systemTimezone, $date->getTimezone()->getName());
        $this->assertSame($this->defaultTz, $date->getTimezone()->getName());

        /**
         * Restore the system timezone.
         */
        date_default_timezone_set($originalSystemTimezone);
    }

    public function testUseSystemTimezoneWhenDefaultTimezoneIsNotSet()
    {
        /**
         * Set the system timezone to something *other* than the timezone used
         * in setUp() *and* reset the default timezone.
         */
        $originalSystemTimezone = date_default_timezone_get();
        $originalDefaultTimezone = DateTimeProvider::getDefaultTimezone();
        $systemTimezone = 'Antarctica/Vostok';
        date_default_timezone_set($systemTimezone);
        DateTimeProvider::setDefaultTimezone();

        /**
         * Get a new date/time value and assert that it uses the system timezone
         * and not the system timezone.
         */
        $date = DateTimeProvider::dateTime();
        $this->assertSame($systemTimezone, $date->getTimezone()->getName());
        $this->assertNotSame($this->defaultTz, $date->getTimezone()->getName());

        /**
         * Restore the system timezone.
         */
        date_default_timezone_set($originalSystemTimezone);
    }

    public function testUnixTime()
    {
        $timestamp = DateTimeProvider::unixTime();
        $this->assertInternalType('int', $timestamp);
        $this->assertGreaterThanOrEqual(0, $timestamp);
        $this->assertLessThanOrEqual(time(), $timestamp);
    }

    public function testDateTime()
    {
        $date = DateTimeProvider::dateTime();
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertGreaterThanOrEqual(new \DateTime('@0'), $date);
        $this->assertLessThanOrEqual(new \DateTime(), $date);
        $this->assertEquals(new \DateTimeZone($this->defaultTz), $date->getTimezone());
    }

    public function testDateTimeWithTimezone()
    {
        $date = DateTimeProvider::dateTime('now', 'America/New_York');
        $this->assertEquals($date->getTimezone(), new \DateTimeZone('America/New_York'));
    }

    public function testDateTimeAD()
    {
        $date = DateTimeProvider::dateTimeAD();
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertGreaterThanOrEqual(new \DateTime('0000-01-01 00:00:00'), $date);
        $this->assertLessThanOrEqual(new \DateTime(), $date);
        $this->assertEquals(new \DateTimeZone($this->defaultTz), $date->getTimezone());
    }

    public function testDateTimeThisCentury()
    {
        $date = DateTimeProvider::dateTimeThisCentury();
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertGreaterThanOrEqual(new \DateTime('-100 year'), $date);
        $this->assertLessThanOrEqual(new \DateTime(), $date);
        $this->assertEquals(new \DateTimeZone($this->defaultTz), $date->getTimezone());
    }

    public function testDateTimeThisDecade()
    {
        $date = DateTimeProvider::dateTimeThisDecade();
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertGreaterThanOrEqual(new \DateTime('-10 year'), $date);
        $this->assertLessThanOrEqual(new \DateTime(), $date);
        $this->assertEquals(new \DateTimeZone($this->defaultTz), $date->getTimezone());
    }

    public function testDateTimeThisYear()
    {
        $date = DateTimeProvider::dateTimeThisYear();
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertGreaterThanOrEqual(new \DateTime('-1 year'), $date);
        $this->assertLessThanOrEqual(new \DateTime(), $date);
        $this->assertEquals(new \DateTimeZone($this->defaultTz), $date->getTimezone());
    }

    public function testDateTimeThisMonth()
    {
        $date = DateTimeProvider::dateTimeThisMonth();
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertGreaterThanOrEqual(new \DateTime('-1 month'), $date);
        $this->assertLessThanOrEqual(new \DateTime(), $date);
        $this->assertEquals(new \DateTimeZone($this->defaultTz), $date->getTimezone());
    }

    public function testDateTimeThisCenturyWithTimezone()
    {
        $date = DateTimeProvider::dateTimeThisCentury('now', 'America/New_York');
        $this->assertEquals($date->getTimezone(), new \DateTimeZone('America/New_York'));
    }

    public function testDateTimeThisDecadeWithTimezone()
    {
        $date = DateTimeProvider::dateTimeThisDecade('now', 'America/New_York');
        $this->assertEquals($date->getTimezone(), new \DateTimeZone('America/New_York'));
    }

    public function testDateTimeThisYearWithTimezone()
    {
        $date = DateTimeProvider::dateTimeThisYear('now', 'America/New_York');
        $this->assertEquals($date->getTimezone(), new \DateTimeZone('America/New_York'));
    }

    public function testDateTimeThisMonthWithTimezone()
    {
        $date = DateTimeProvider::dateTimeThisMonth('now', 'America/New_York');
        $this->assertEquals($date->getTimezone(), new \DateTimeZone('America/New_York'));
    }

    public function testIso8601()
    {
        $date = DateTimeProvider::iso8601();
        $this->assertRegExp('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-Z](\d{4})?$/', $date);
        $this->assertGreaterThanOrEqual(new \DateTime('@0'), new \DateTime($date));
        $this->assertLessThanOrEqual(new \DateTime(), new \DateTime($date));
    }

    public function testDate()
    {
        $date = DateTimeProvider::date();
        $this->assertRegExp('/^\d{4}-\d{2}-\d{2}$/', $date);
        $this->assertGreaterThanOrEqual(new \DateTime('@0'), new \DateTime($date));
        $this->assertLessThanOrEqual(new \DateTime(), new \DateTime($date));
    }

    public function testTime()
    {
        $date = DateTimeProvider::time();
        $this->assertRegExp('/^\d{2}:\d{2}:\d{2}$/', $date);
    }

    /**
     *
     * @dataProvider providerDateTimeBetween
     */
    public function testDateTimeBetween($start, $end)
    {
        $date = DateTimeProvider::dateTimeBetween($start, $end);
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertGreaterThanOrEqual(new \DateTime($start), $date);
        $this->assertLessThanOrEqual(new \DateTime($end), $date);
        $this->assertEquals(new \DateTimeZone($this->defaultTz), $date->getTimezone());
    }

    public function providerDateTimeBetween()
    {
        return array(
            array('-1 year', false),
            array('-1 year', null),
            array('-1 day', '-1 hour'),
            array('-1 day', 'now'),
        );
    }

    /**
     *
     * @dataProvider providerDateTimeInInterval
     */
    public function testDateTimeInInterval($start, $interval = "+5 days", $isInFuture)
    {
        $date = DateTimeProvider::dateTimeInInterval($start, $interval);
        $this->assertInstanceOf('\DateTime', $date);

        $_interval = \DateInterval::createFromDateString($interval);
        $_start = new \DateTime($start);
        if ($isInFuture) {
            $this->assertGreaterThanOrEqual($_start, $date);
            $this->assertLessThanOrEqual($_start->add($_interval), $date);
        } else {
            $this->assertLessThanOrEqual($_start, $date);
            $this->assertGreaterThanOrEqual($_start->add($_interval), $date);
        }
    }

    public function providerDateTimeInInterval()
    {
        return array(
            array('-1 year', '+5 days', true),
            array('-1 day', '-1 hour', false),
            array('-1 day', '+1 hour', true),
        );
    }

    public function testFixedSeedWithMaximumTimestamp()
    {
        $max = '2118-03-01 12:00:00';

        mt_srand(1);
        $unixTime = DateTimeProvider::unixTime($max);
        $datetimeAD = DateTimeProvider::dateTimeAD($max);
        $dateTime1 = DateTimeProvider::dateTime($max);
        $dateTimeBetween = DateTimeProvider::dateTimeBetween('2014-03-01 06:00:00', $max);
        $date = DateTimeProvider::date('Y-m-d', $max);
        $time = DateTimeProvider::time('H:i:s', $max);
        $iso8601 = DateTimeProvider::iso8601($max);
        $dateTimeThisCentury = DateTimeProvider::dateTimeThisCentury($max);
        $dateTimeThisDecade = DateTimeProvider::dateTimeThisDecade($max);
        $dateTimeThisMonth = DateTimeProvider::dateTimeThisMonth($max);
        $amPm = DateTimeProvider::amPm($max);
        $dayOfMonth = DateTimeProvider::dayOfMonth($max);
        $dayOfWeek = DateTimeProvider::dayOfWeek($max);
        $month = DateTimeProvider::month($max);
        $monthName = DateTimeProvider::monthName($max);
        $year = DateTimeProvider::year($max);
        $dateTimeThisYear = DateTimeProvider::dateTimeThisYear($max);
        mt_srand();

        //regenerate Random Date with same seed and same maximum end timestamp
        mt_srand(1);
        $this->assertEquals($unixTime, DateTimeProvider::unixTime($max));
        $this->assertEquals($datetimeAD, DateTimeProvider::dateTimeAD($max));
        $this->assertEquals($dateTime1, DateTimeProvider::dateTime($max));
        $this->assertEquals($dateTimeBetween, DateTimeProvider::dateTimeBetween('2014-03-01 06:00:00', $max));
        $this->assertEquals($date, DateTimeProvider::date('Y-m-d', $max));
        $this->assertEquals($time, DateTimeProvider::time('H:i:s', $max));
        $this->assertEquals($iso8601, DateTimeProvider::iso8601($max));
        $this->assertEquals($dateTimeThisCentury, DateTimeProvider::dateTimeThisCentury($max));
        $this->assertEquals($dateTimeThisDecade, DateTimeProvider::dateTimeThisDecade($max));
        $this->assertEquals($dateTimeThisMonth, DateTimeProvider::dateTimeThisMonth($max));
        $this->assertEquals($amPm, DateTimeProvider::amPm($max));
        $this->assertEquals($dayOfMonth, DateTimeProvider::dayOfMonth($max));
        $this->assertEquals($dayOfWeek, DateTimeProvider::dayOfWeek($max));
        $this->assertEquals($month, DateTimeProvider::month($max));
        $this->assertEquals($monthName, DateTimeProvider::monthName($max));
        $this->assertEquals($year, DateTimeProvider::year($max));
        $this->assertEquals($dateTimeThisYear, DateTimeProvider::dateTimeThisYear($max));
        mt_srand();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        INDX( 	 �m             (   �  �       �� �  p �        �     p `     �     �a��ok� Uze�����<��a��ok�       �               A d d r e s s T e s t . p h p      ` L     �     �>�ok���ok���ok��>�ok�                        a r _ J O d e      ` L     �     ee�ok����ok����ok�ee�ok�                        a r _ S A d e      ` L     �     *�ok�<Q �ok�<Q �ok�*�ok�                        a t _ A T d e       p `     �     ����ok� Uze�����< ����ok�       v               B a r c o d e T e s t . p h p      p Z     �     ���ok� Uze�^@��<����ok� P      aL               B a s e T e s t . p h p            ` L     �     ��"�ok��%�ok��%�ok���"�ok�                        b g _ B G d T      p ^     �     �8��ok� Uze�V���<��8��ok�       0               B i a s e d T e s t . p h p        ` L     �     Cx'�ok�d�)�ok�d�)�ok�Cx'�ok�                        b n _ B D T e      p \     �     ����ok  Uze����<�����ok�       �               C o l o r T e s t . p h p          p `     �     �K��ok� Uze����<��K��ok�x      t               C o m p a n y T e s t . p h p      ` L     �     d�)�ok�T�.�ok�T�.�ok�d�)�ok�                        c s _ C Z i m      x b     �     �r��ok� Uze��g��<��r��ok� 0      �+               D a t e T i m e T e s t . p h p            ` L     �     T�.�ok��1�ok��1�ok�T�.�ok�                        d a _ D K o r !     ` L     �     �d3�ok�])8�ok�])8�ok��d3�ok�                        d e _ A T o r $     ` L     �     E�:�ok�O<K�ok�O<K�ok�E�:�ok�                        d e _ C H o r (     ` L     �     O<K�ok���M�ok���M�ok�O<K�ok�                        d e _ D E o r *     ` L     �     � P�ok��T�ok��T�ok�� P�ok�                        e l _ G R o r ,     ` L     �     �T�ok�n'W�ok�n'W�ok��T�ok�                        e n _ A U o r               �     ͉Y�ok��]% ͉Y�ok�͉Y�ok�                        e n _ C A o r 0     ` L     �     N^�ok��&�]%�N^�ok�N^�ok�                        e n _ G B o r 2     ` L     �     �c�ok�m�/�]%��c�ok��c�ok�                        e n _ I N o r 4     ` L     �     ��g�ok� �I�]%���g�ok���g�ok�                        e n _ N G o r 9     ` L     �     ~�s�ok��U�]%�~�s�ok�~�s�ok�                        e n _ N Z o r      x d     �     ���ok� Uze�����<����ok�       �              H t m l L o r e m T e s t . p h p          p \     �     ����ok� Uze�,��<�����ok�       �	               I m a g e T e s t . p h p          x b     �     ]���ok� Uze�,��<�]���ok�        I               I n t e r n e t T e s t . p h p       	     � j     �      K��ok� Uze�)���<� K��ok�                      L o c a l i z a t i o n T e s t . p h p       
     p \     �     ��ok� Uze������<���ok�                      L o r e m T e s t .  h p          � l     �     S7�ok� Uze�S���<�S7�ok�       q               M i s c e l l a n e o u s T e s t . p h p          p `     �     u��ok� Uze�S���<�u��ok�        �               P a y m e n t T e s t . p h p      p ^     �     ���ok� Uze�S���<����ok�       �	               P e r s o n T e s t . p h p        x h     �     ����ok� Uze�*����<�����ok�       �               P h o n e N u m b e r T e s t . p h p      � r     �     �R�ok  Uze�����<��R�ok�        s               P r o v i d e r O v e r r i d e T e s t . p h p            p Z     �     ��ok� Uze�����<���ok�       C               T e x t T e s t . p h p            x d     �     �y�ok� Uze��z���<��y�ok�       �               U s e r A g e n t T e s t . p h p          p Z     �     ��
�ok� Uze�K���<���
�ok�       �               U u i d T e s t . p h p                                                                    <?php

namespace Faker\Test\Provider;

use Faker\Generator;
use Faker\Provider\HtmlLorem;
use PHPUnit\Framework\TestCase;

class HtmlLoremTest extends TestCase
{

    public function testProvider()
    {
        $faker = new Generator();
        $faker->addProvider(new HtmlLorem($faker));
        $node = $faker->randomHtml(6, 10);
        $this->assertStringStartsWith("<html>", $node);
        $this->assertStringEndsWith("</html>\n", $node);
    }

    public function testRandomHtmlReturnsValidHTMLString(){
        $faker = new Generator();
        $faker->addProvider(new HtmlLorem($faker));
        $node = $faker->randomHtml(6, 10);
        $dom = new \DOMDocument();
        $error = $dom->loadHTML($node);
        $this->assertTrue($error);
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Faker\Test\Provider;

use Faker\Provider\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testImageUrlUses640x680AsTheDefaultSize()
    {
        $this->assertRegExp('#^https://lorempixel.com/640/480/#', Image::imageUrl());
    }

    public function testImageUrlAcceptsCustomWidthAndHeight()
    {
        $this->assertRegExp('#^https://lorempixel.com/800/400/#', Image::imageUrl(800, 400));
    }

    public function testImageUrlAcceptsCustomCategory()
    {
        $this->assertRegExp('#^https://lorempixel.com/800/400/nature/#', Image::imageUrl(800, 400, 'nature'));
    }

    public function testImageUrlAcceptsCustomText()
    {
        $this->assertRegExp('#^https://lorempixel.com/800/400/nature/Faker#', Image::imageUrl(800, 400, 'nature', false, 'Faker'));
    }

    public function testImageUrlAddsARandomGetParameterByDefault()
    {
        $url = Image::imageUrl(800, 400);
        $splitUrl = preg_split('/\?/', $url);

        $this->assertEquals(count($splitUrl), 2);
        $this->assertRegexp('#\d{5}#', $splitUrl[1]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUrlWithDimensionsAndBadCategory()
    {
        Image::imageUrl(800, 400, 'bullhonky');
    }

    public function testDownloadWithDefaults()
    {
        $url = "http://lorempixel.com/";
        $curlPing = curl_init($url);
        curl_setopt($curlPing, CURLOPT_TIMEOUT, 5);
        curl_setopt($curlPing, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curlPing, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curlPing);
        $httpCode = curl_getinfo($curlPing, CURLINFO_HTTP_CODE);
        curl_close($curlPing);

        if ($httpCode < 200 | $httpCode > 300) {
            $this->markTestSkipped("LoremPixel is offline, skipping image download");
        }

        $file = Image::image(sys_get_temp_dir());
        $this->assertFileExists($file);
        if (function_exists('getimagesize')) {
            list($width, $height, $type, $attr) = getimagesize($file);
            $this->assertEquals(640, $width);
            $this->assertEquals(480, $height);
            $this->assertEquals(constant('IMAGETYPE_JPEG'), $type);
        } else {
            $this->assertEquals('jpg', pathinfo($file, PATHINFO_EXTENSION));
        }
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace Faker\Test\Provider;

use Faker\Generator;
use Faker\Provider\Company;
use Faker\Provider\Internet;
use Faker\Provider\Lorem;
use Faker\Provider\Person;
use PHPUnit\Framework\TestCase;

class InternetTest extends TestCase
{
    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Lorem($faker));
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    public function localeDataProvider()
    {
        $providerPath = realpath(__DIR__ . '/../../../src/Faker/Provider');
        $localePaths = array_filter(glob($providerPath . '/*', GLOB_ONLYDIR));
        foreach ($localePaths as $path) {
            $parts = explode('/', $path);
            $locales[] = array($parts[count($parts) - 1]);
        }

        return $locales;
    }

    /**
     * @link http://stackoverflow.com/questions/12026842/how-to-validate-an-email-address-in-php
     *
     * @dataProvider localeDataProvider
     */
    public function testEmailIsValid($locale)
    {
        if ($locale !== 'en_US' && !class_exists('Transliterator')) {
            $this->markTestSkipped('Transliterator class not available (intl extension)');
        }

        $this->loadLocalProviders($locale);
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        $emailAddress = $this->faker->email();
        $this->assertRegExp($pattern, $emailAddress);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function testUsernameIsValid($locale)
    {
        if ($locale !== 'en_US' && !class_exists('Transliterator')) {
            $this->markTestSkipped('Transliterator class not available (intl extension)');
        }

        $this->loadLocalProviders($locale);
        $pattern = '/^[A-Za-z0-9]+([._][A-Za-z0-9]+)*$/';
        $username = $this->faker->username();
        $this->assertRegExp($pattern, $username);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function testDomainnameIsValid($locale)
    {
        if ($locale !== 'en_US' && !class_exists('Transliterator')) {
            $this->markTestSkipped('Transliterator class not available (intl extension)');
        }

        $this->loadLocalProviders($locale);
        $pattern = '/^[a-z]+(\.[a-z]+)+$/';
        $domainName = $this->faker->domainName();
        $this->assertRegExp($pattern, $domainName);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function testDomainwordIsValid($locale)
    {
        if ($locale !== 'en_US' && !class_exists('Transliterator')) {
            $this->markTestSkipped('Transliterator class not available (intl extension)');
        }

        $this->loadLocalProviders($locale);
        $pattern = '/^[a-z]+$/';
        $domainWord = $this->faker->domainWord();
        $this->assertRegExp($pattern, $domainWord);
    }

    public function loadLocalProviders($locale)
    {
        $providerPath = realpath(__DIR__ . '/../../../src/Faker/Provider');
        if (file_exists($providerPath.'/'.$locale.'/Internet.php')) {
            $internet = "\\Faker\\Provider\\$locale\\Internet";
            $this->faker->addProvider(new $internet($this->faker));
        }
        if (file_exists($providerPath.'/'.$locale.'/Person.php')) {
            $person = "\\Faker\\Provider\\$locale\\Person";
            $this->faker->addProvider(new $person($this->faker));
        }
        if (file_exists($providerPath.'/'.$locale.'/Company.php')) {
            $company = "\\Faker\\Provider\\$locale\\Company";
            $this->faker->addProvider(new $company($this->faker));
        }
    }

    public function testPasswordIsValid()
    {
        $this->assertRegexp('/^.{6}$/', $this->faker->password(6, 6));
    }

    public function testSlugIsValid()
    {
        $pattern = '/^[a-z0-9-]+$/';
        $slug = $this->faker->slug();
        $this->assertSame(preg_match($pattern, $slug), 1);
    }

    public function testUrlIsValid()
    {
        $url = $this->faker->url();
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));
    }

    public function testLocalIpv4()
    {
        $this->assertNotFalse(filter_var(Internet::localIpv4(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    }

    public function testIpv4()
    {
        $this->assertNotFalse(filter_var($this->faker->ipv4(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    }

    public function testIpv4NotLocalNetwork()
    {
        $this->assertNotRegExp('/\A0\./', $this->faker->ipv4());
    }

    public function testIpv4NotBroadcast()
    {
        $this->assertNotEquals('255.255.255.255', $this->faker->ipv4());
    }

    public function testIpv6()
    {
        $this->assertNotFalse(filter_var($this->faker->ipv6(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6));
    }

    public function testMacAddress()
    {
        $this->assertRegExp('/^([0-9A-F]{2}[:]){5}([0-9A-F]{2})$/i', Internet::macAddress());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Faker\Test\Provider;

use Faker\Factory;
use PHPUnit\Framework\TestCase;

class LocalizationTest extends TestCase
{
    public function testLocalizedNameProvidersDoNotThrowErrors()
    {
        foreach (glob(__DIR__ . '/../../../src/Faker/Provider/*/Person.php') as $localizedPerson) {
            preg_match('#/([a-zA-Z_]+)/Person\.php#', $localizedPerson, $matches);
            $faker = Factory::create($matches[1]);
            $this->assertNotNull($faker->name(), 'Localized Name Provider ' . $matches[1] . ' does not throw errors');
        }
    }

    public function testLocalizedAddressProvidersDoNotThrowErrors()
    {
        foreach (glob(__DIR__ . '/../../../src/Faker/Provider/*/Address.php') as $localizedAddress) {
            preg_match('#/([a-zA-Z_]+)/Address\.php#', $localizedAddress, $matches);
            $faker = Factory::create($matches[1]);
            $this->assertNotNull($faker->address(), 'Localized Address Provider ' . $matches[1] . ' does not throw errors');
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace Faker\Test\Provider;

use Faker\Provider\Lorem;
use PHPUnit\Framework\TestCase;

class LoremTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTextThrowsExceptionWhenAskedTextSizeLessThan5()
    {
        Lorem::text(4);
    }

    public function testTextReturnsWordsWhenAskedSizeLessThan25()
    {
        $this->assertEquals('Word word word word.', TestableLorem::text(24));
    }

    public function testTextReturnsSentencesWhenAskedSizeLessThan100()
    {
        $this->assertEquals('This is a test sentence. This is a test sentence. This is a test sentence.', TestableLorem::text(99));
    }

    public function testTextReturnsParagraphsWhenAskedSizeGreaterOrEqualThanThan100()
    {
        $this->assertEquals('This is a test paragraph. It has three sentences. Exactly three.', TestableLorem::text(100));
    }

    public function testSentenceWithZeroNbWordsReturnsEmptyString()
    {
        $this->assertEquals('', Lorem::sentence(0));
    }

    public function testSentenceWithNegativeNbWordsReturnsEmptyString()
    {
        $this->assertEquals('', Lorem::sentence(-1));
    }

    public function testParagraphWithZeroNbSentencesReturnsEmptyString()
    {
        $this->assertEquals('', Lorem::paragraph(0));
    }

    public function testParagraphWithNegativeNbSentencesReturnsEmptyString()
    {
        $this->assertEquals('', Lorem::paragraph(-1));
    }

    public function testSentenceWithPositiveNbWordsReturnsAtLeastOneWord()
    {
         $sentence = Lorem::sentence(1);

        $this->assertGreaterThan(1, strlen($sentence));
        $this->assertGreaterThanOrEqual(1, count(explode(' ', $sentence)));
    }

    public function testParagraphWithPositiveNbSentencesReturnsAtLeastOneWord()
    {
        $paragraph = Lorem::paragraph(1);

        $this->assertGreaterThan(1, strlen($paragraph));
        $this->assertGreaterThanOrEqual(1, count(explode(' ', $paragraph)));
    }

    public function testWordssAsText()
    {
        $words = TestableLorem::words(2, true);

        $this->assertEquals('word word', $words);
    }

    public function testSentencesAsText()
    {
        $sentences = TestableLorem::sentences(2, true);

        $this->assertEquals('This is a test sentence. This is a test sentence.', $sentences);
    }

    public function testParagraphsAsText()
    {
        $paragraphs = TestableLorem::paragraphs(2, true);

        $expected = "This is a test paragraph. It has three sentences. Exactly three.\n\nThis is a test paragraph. It has three sentences. Exactly three.";
        $this->assertEquals($expected, $paragraphs);
    }
}

class TestableLorem extends Lorem
{

    public static function word()
    {
        return 'word';
    }

    public static function sentence($nbWords = 5, $variableNbWords = true)
    {
        return 'This is a test sentence.';
    }

    public static function paragraph($nbSentences = 3, $variableNbSentences = true)
    {
        return 'This is a test paragraph. It has three sentences. Exactly three.';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Faker\Test\Provider;

use Faker\Provider\Miscellaneous;
use PHPUnit\Framework\TestCase;

class MiscellaneousTest extends TestCase
{
    public function testBoolean()
    {
        $this->assertContains(Miscellaneous::boolean(), array(true, false));
    }

    public function testMd5()
    {
        $this->assertRegExp('/^[a-z0-9]{32}$/', Miscellaneous::md5());
    }

    public function testSha1()
    {
        $this->assertRegExp('/^[a-z0-9]{40}$/', Miscellaneous::sha1());
    }

    public function testSha256()
    {
        $this->assertRegExp('/^[a-z0-9]{64}$/', Miscellaneous::sha256());
    }

    public function testLocale()
    {
        $this->assertRegExp('/^[a-z]{2,3}_[A-Z]{2}$/', Miscellaneous::locale());
    }

    public function testCountryCode()
    {
        $this->assertRegExp('/^[A-Z]{2}$/', Miscellaneous::countryCode());
    }

    public function testCountryISOAlpha3()
    {
        $this->assertRegExp('/^[A-Z]{3}$/', Miscellaneous::countryISOAlpha3());
    }

    public function testLanguage()
    {
        $this->assertRegExp('/^[a-z]{2}$/', Miscellaneous::languageCode());
    }

    public function testCurrencyCode()
    {
        $this->assertRegExp('/^[A-Z]{3}$/', Miscellaneous::currencyCode());
    }

    public function testEmoji()
    {
        $this->assertRegExp('/^[\x{1F600}-\x{1F637}]$/u', Miscellaneous::emoji());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Faker\Test\Provider;

use Faker\Calculator\Iban;
use Faker\Calculator\Luhn;
use Faker\Generator;
use Faker\Provider\Base as BaseProvider;
use Faker\Provider\DateTime as DateTimeProvider;
use Faker\Provider\Payment as PaymentProvider;
use Faker\Provider\Person as PersonProvider;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new BaseProvider($faker));
        $faker->addProvider(new DateTimeProvider($faker));
        $faker->addProvider(new PersonProvider($faker));
        $faker->addProvider(new PaymentProvider($faker));
        $this->faker = $faker;
    }

    public function localeDataProvider()
    {
        $providerPath = realpath(__DIR__ . '/../../../src/Faker/Provider');
        $localePaths = array_filter(glob($providerPath . '/*', GLOB_ONLYDIR));
        foreach ($localePaths as $path) {
            $parts = explode('/', $path);
            $locales[] = array($parts[count($parts) - 1]);
        }

        return $locales;
    }

    public function loadLocalProviders($locale)
    {
        $providerPath = realpath(__DIR__ . '/../../../src/Faker/Provider');
        if (file_exists($providerPath.'/'.$locale.'/Payment.php')) {
            $payment = "\\Faker\\Provider\\$locale\\Payment";
            $this->faker->addProvider(new $payment($this->faker));
        }
    }

    public function testCreditCardTypeReturnsValidVendorName()
    {
        $this->assertContains($this->faker->creditCardType, array('Visa', 'Visa Retired', 'MasterCard', 'American Express', 'Discover Card'));
    }

    public function creditCardNumberProvider()
    {
        return array(
            array('Discover Card', '/^6011\d{12}$/'),
            array('Visa', '/^4\d{15}$/'),
            array('Visa Retired', '/^4\d{12}$/'),
            array('MasterCard', '/^(5[1-5]|2[2-7])\d{14}$/')
        );
    }

    /**
     * @dataProvider creditCardNumberProvider
     */
    public function testCreditCardNumberReturnsValidCreditCardNumber($type, $regexp)
    {
        $cardNumber = $this->faker->creditCardNumber($type);
        $this->assertRegExp($regexp, $cardNumber);
        $this->assertTrue(Luhn::isValid($cardNumber));
    }

    public function testCreditCardNumberCanFormatOutput()
    {
        $this->assertRegExp('/^6011-\d{4}-\d{4}-\d{4}$/', $this->faker->creditCardNumber('Discover Card', true));
    }

    public function testCreditCardExpirationDateReturnsValidDateByDefault()
    {
        $expirationDate = $this->faker->creditCardExpirationDate;
        $this->assertTrue(intval($expirationDate->format('U')) > strtotime('now'));
        $this->assertTrue(intval($expirationDate->format('U')) < strtotime('+36 months'));
    }

    public function testRandomCard()
    {
        $cardDetails = $this->faker->creditCardDetails;
        $this->assertEquals(count($cardDetails), 4);
        $this->assertEquals(array('type', 'number', 'name', 'expirationDate'), array_keys($cardDetails));
    }

    protected $ibanFormats = array(
        'AD' => '/^AD\d{2}\d{4}\d{4}[A-Z0-9]{12}$/',
        'AE' => '/^AE\d{2}\d{3}\d{16}$/',
        'AL' => '/^AL\d{2}\d{8}[A-Z0-9]{16}$/',
        'AT' => '/^AT\d{2}\d{5}\d{11}$/',
        'AZ' => '/^AZ\d{2}[A-Z]{4}[A-Z0-9]{20}$/',
        'BA' => '/^BA\d{2}\d{3}\d{3}\d{8}\d{2}$/',
        'BE' => '/^BE\d{2}\d{3}\d{7}\d{2}$/',
        'BG' => '/^BG\d{2}[A-Z]{4}\d{4}\d{2}[A-Z0-9]{8}$/',
        'BH' => '/^BH\d{2}[A-Z]{4}[A-Z0-9]{14}$/',
        'BR' => '/^BR\d{2}\d{8}\d{5}\d{10}[A-Z]{1}[A-Z0-9]{1}$/',
        'CH' => '/^CH\d{2}\d{5}[A-Z0-9]{12}$/',
        'CR' => '/^CR\d{2}\d{3}\d{14}$/',
        'CY' => '/^CY\d{2}\d{3}\d{5}[A-Z0-9]{16}$/',
        'CZ' => '/^CZ\d{2}\d{4}\d{6}\d{10}$/',
        'DE' => '/^DE\d{2}\d{8}\d{10}$/',
        'DK' => '/^DK\d{2}\d{4}\d{9}\d{1}$/',
        'DO' => '/^DO\d{2}[A-Z0-9]{4}\d{20}$/',
        'EE' => '/^EE\d{2}\d{2}\d{2}\d{11}\d{1}$/',
        'ES' => '/^ES\d{2}\d{4}\d{4}\d{1}\d{1}\d{10}$/',
        'FI' => '/^FI\d{2}\d{6}\d{7}\d{1}$/',
        'FR' => '/^FR\d{2}\d{5}\d{5}[A-Z0-9]{11}\d{2}$/',
        'GB' => '/^GB\d{2}[A-Z]{4}\d{6}\d{8}$/',
        'GE' => '/^GE\d{2}[A-Z]{2}\d{16}$/',
        'GI' => '/^GI\d{2}[A-Z]{4}[A-Z0-9]{15}$/',
        'GR' => '/^GR\d{2}\d{3}\d{4}[A-Z0-9]{16}$/',
        'GT' => '/^GT\d{2}[A-Z0-9]{4}[A-Z0-9]{20}$/',
        'HR' => '/^HR\d{2}\d{7}\d{10}$/',
        'HU' => '/^HU\d{2}\d{3}\d{4}\d{1}\d{15}\d{1}$/',
        'IE' => '/^IE\d{2}[A-Z]{4}\d{6}\d{8}$/',
        'IL' => '/^IL\d{2}\d{3}\d{3}\d{13}$/',
        'IS' => '/^IS\d{2}\d{4}\d{2}\d{6}\d{10}$/',
        'IT' => '/^IT\d{2}[A-Z]{1}\d{5}\d{5}[A-Z0-9]{12}$/',
        'KW' => '/^KW\d{2}[A-Z]{4}\d{22}$/',
        'KZ' => '/^KZ\d{2}\d{3}[A-Z0-9]{13}$/',
        'LB' => '/^LB\d{2}\d{4}[A-Z0-9]{20}$/',
        'LI' => '/^LI\d{2}\d{5}[A-Z0-9]{12}$/',
        'LT' => '/^LT\d{2}\d{5}\d{11}$/',
        'LU' => '/^LU\d{2}\d{3}[A-Z0-9]{13}$/',
        'LV' => '/^LV\d{2}[A-Z]{4}[A-Z0-9]{13}$/',
        'MC' => '/^MC\d{2}\d{5}\d{5}[A-Z0-9]{11}\d{2}$/',
        'MD' => '/^MD\d{2}[A-Z0-9]{2}[A-Z0-9]{18}$/',
        'ME' => '/^ME\d{2}\d{3}\d{13}\d{2}$/',
        'MK' => '/^MK\d{2}\d{3}[A-Z0-9]{10}\d{2}$/',
        'MR' => '/^MR\d{2}\d{5}\d{5}\d{11}\d{2}$/',
        'MT' => '/^MT\d{2}[A-Z]{4}\d{5}[A-Z0-9]{18}$/',
        'MU' => '/^MU\d{2}[A-Z]{4}\d{2}\d{2}\d{12}\d{3}[A-Z]{3}$/',
        'NL' => '/^NL\d{2}[A-Z]{4}\d{10}$/',
        'NO' => '/^NO\d{2}\d{4}\d{6}\d{1}$/',
        'PK' => '/^PK\d{2}[A-Z]{4}[A-Z0-9]{16}$/',
        'PL' => '/^PL\d{2}\d{8}\d{16}$/',
        'PS' => '/^PS\d{2}[A-Z]{4}[A-Z0-9]{21}$/',
        'PT' => '/^PT\d{2}\d{4}\d{4}\d{11}\d{2}$/',
        'RO' => '/^RO\d{2}[A-Z]{4}[A-Z0-9]{16}$/',
        'RS' => '/^RS\d{2}\d{3}\d{13}\d{2}$/',
        'SA' => '/^SA\d{2}\d{2}[A-Z0-9]{18}$/',
        'SE' => '/^SE\d{2}\d{3}\d{16}\d{1}$/',
        'SI' => '/^SI\d{2}\d{5}\d{8}\d{2}$/',
        'SK' => '/^SK\d{2}\d{4}\d{6}\d{10}$/',
        'SM' => '/^SM\d{2}[A-Z]{1}\d{5}\d{5}[A-Z0-9]{12}$/',
        'TN' => '/^TN\d{2}\d{2}\d{3}\d{13}\d{2}$/',
        'TR' => '/^TR\d{2}\d{5}\d{1}[A-Z0-9]{16}$/',
        'VG' => '/^VG\d{2}[A-Z]{4}\d{16}$/',
    );

    /**
     * @dataProvider localeDataProvider
     */
    public function testBankAccountNumber($locale)
    {
        $parts = explode('_', $locale);
        $countryCode = array_pop($parts);

        if (!isset($this->ibanFormats[$countryCode])) {
            // No IBAN format available
            return;
        }

        $this->loadLocalProviders($locale);

        try {
            $iban = $this->faker->bankAccountNumber;
        } catch (\InvalidArgumentException $e) {
            // Not implemented, nothing to test
            $this->markTestSkipped("bankAccountNumber not implemented for $locale");
            return;
        }

        // Test format
        $this->assertRegExp($this->ibanFormats[$countryCode], $iban);

        // Test checksum
        $this->assertTrue(Iban::isValid($iban), "Checksum for $iban is invalid");
    }

    public function ibanFormatProvider()
    {
        $return = array();
        foreach ($this->ibanFormats as $countryCode => $regex) {
            $return[] = array($countryCode, $regex);
        }
        return $return;
    }
    /**
     * @dataProvider ibanFormatProvider
     */
    public function testIban($countryCode, $regex)
    {
        $iban = $this->faker->iban($countryCode);

        // Test format
        $this->assertRegExp($regex, $iban);

        // Test checksum
        $this->assertTrue(Iban::isValid($iban), "Checksum for $iban is invalid");
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Faker\Test\Provider;

use Faker\Provider\Person;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    /**
     * @dataProvider firstNameProvider
     */
    public function testFirstName($gender, $expected)
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->assertContains($faker->firstName($gender), $expected);
    }

    public function firstNameProvider()
    {
        return array(
            array(null, array('John', 'Jane')),
            array('foobar', array('John', 'Jane')),
            array('male', array('John')),
            array('female', array('Jane')),
        );
    }

    public function testFirstNameMale()
    {
        $this->assertContains(Person::firstNameMale(), array('John'));
    }

    public function testFirstNameFemale()
    {
        $this->assertContains(Person::firstNameFemale(), array('Jane'));
    }

    /**
     * @dataProvider titleProvider
     */
    public function testTitle($gender, $expected)
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->assertContains($faker->title($gender), $expected);
    }

    public function titleProvider()
    {
        return array(
            array(null, array('Mr.', 'Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.')),
            array('foobar', array('Mr.', 'Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.')),
            array('male', array('Mr.', 'Dr.', 'Prof.')),
            array('female', array('Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.')),
        );
    }

    public function testTitleMale()
    {
        $this->assertContains(Person::titleMale(), array('Mr.', 'Dr.', 'Prof.'));
    }

    public function testTitleFemale()
    {
        $this->assertContains(Person::titleFemale(), array('Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.'));
    }

    public function testLastNameReturnsDoe()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->assertEquals($faker->lastName(), 'Doe');
    }

    public function testNameReturnsFirstNameAndLastName()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->assertContains($faker->name(), array('John Doe', 'Jane Doe'));
        $this->assertContains($faker->name('foobar'), array('John Doe', 'Jane Doe'));
        $this->assertContains($faker->name('male'), array('John Doe'));
        $this->assertContains($faker->name('female'), array('Jane Doe'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

namespace Faker\Test\Provider;

use Faker\Generator;
use Faker\Calculator\Luhn;
use Faker\Provider\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }

    public function testPhoneNumberFormat()
    {
        $number = $this->faker->e164PhoneNumber();
        $this->assertRegExp('/^\+[0-9]{11,}$/', $number);
    }

    public function testImeiReturnsValidNumber()
    {
        $imei = $this->faker->imei();
        $this->assertTrue(Luhn::isValid($imei));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php
/**
 * @author Mark van der Velden <mark@dynom.nl>
 */

namespace Faker\Test\Provider;

use Faker;
use PHPUnit\Framework\TestCase;

/**
 * Class ProviderOverrideTest
 *
 * @package Faker\Test\Provider
 *
 * This class tests a large portion of all locale specific providers. It does not test the entire stack, because each
 * locale specific provider (can) has specific implementations. The goal of this test is to test the common denominator
 * and to try to catch possible invalid multi-byte sequences.
 */
class ProviderOverrideTest extends TestCase
{
    /**
     * Constants with regular expression patterns for testing the output.
     *
     * Regular expressions are sensitive for malformed strings (e.g.: strings with incorrect encodings) so by using
     * PCRE for the tests, even though they seem fairly pointless, we test for incorrect encodings also.
     */
    const TEST_STRING_REGEX = '/.+/u';

    /**
     * Slightly more specific for e-mail, the point isn't to properly validate e-mails.
     */
    const TEST_EMAIL_REGEX = '/^(.+)@(.+)$/ui';

    /**
     * @dataProvider localeDataProvider
     * @param string $locale
     */
    public function testAddress($locale = null)
    {
        $faker = Faker\Factory::create($locale);

        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->city);
        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->postcode);
        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->address);
        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->country);
    }


    /**
     * @dataProvider localeDataProvider
     * @param string $locale
     */
    public function testCompany($locale = null)
    {
        $faker = Faker\Factory::create($locale);

        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->company);
    }


    /**
     * @dataProvider localeDataProvider
     * @param string $locale
     */
    public function testDateTime($locale = null)
    {
        $faker = Faker\Factory::create($locale);

        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->century);
        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->timezone);
    }


    /**
     * @dataProvider localeDataProvider
     * @param string $locale
     */
    public function testInternet($locale = null)
    {
        if ($locale && $locale !== 'en_US' && !class_exists('Transliterator')) {
            $this->markTestSkipped('Transliterator class not available (intl extension)');
        }

        $faker = Faker\Factory::create($locale);

        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->userName);

        $this->assertRegExp(static::TEST_EMAIL_REGEX, $faker->email);
        $this->assertRegExp(static::TEST_EMAIL_REGEX, $faker->safeEmail);
        $this->assertRegExp(static::TEST_EMAIL_REGEX, $faker->freeEmail);
        $this->assertRegExp(static::TEST_EMAIL_REGEX, $faker->companyEmail);
    }


    /**
     * @dataProvider localeDataProvider
     * @param string $locale
     */
    public function testPerson($locale = null)
    {
        $faker = Faker\Factory::create($locale);

        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->name);
        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->title);
        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->firstName);
        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->lastName);
    }


    /**
     * @dataProvider localeDataProvider
     * @param string $locale
     */
    public function testPhoneNumber($locale = null)
    {
        $faker = Faker\Factory::create($locale);

        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->phoneNumber);
    }


    /**
     * @dataProvider localeDataProvider
     * @param string $locale
     */
    public function testUserAgent($locale = null)
    {
        $faker = Faker\Factory::create($locale);

        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->userAgent);
    }


    /**
     * @dataProvider localeDataProvider
     *
     * @param null   $locale
     * @param string $locale
     */
    public function testUuid($locale = null)
    {
        $faker = Faker\Factory::create($locale);

        $this->assertRegExp(static::TEST_STRING_REGEX, $faker->uuid);
    }


    /**
     * @return array
     */
    public function localeDataProvider()
    {
        $locales = $this->getAllLocales();
        $data = array();

        foreach ($locales as $locale) {
            $data[] = array(
                $locale
            );
        }

        return $data;
    }


    /**
     * Returns all locales as array values
     *
     * @return array
     */
    private function getAllLocales()
    {
        static $locales = array();

        if ( ! empty($locales)) {
            return $locales;
        }

        // Finding all PHP files in the xx_XX directories
        $providerDir = __DIR__ .'/../../../src/Faker/Provider';
        foreach (glob($providerDir .'/*_*/*.php') as $file) {
            $localisation = basename(dirname($file));

            if (isset($locales[ $localisation ])) {
                continue;
            }

            $locales[ $localisation ] = $localisation;
        }

        return $locales;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php
namespace Faker\Test\Provider;

use Faker\Provider\en_US\Text;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    public function testTextMaxLength()
    {
        $generator = new Generator();
        $generator->addProvider(new Text($generator));
        $generator->seed(0);

        $lengths = array(10, 20, 50, 70, 90, 120, 150, 200, 500);

        foreach ($lengths as $length) {
            $this->assertLessThan($length, $generator->realText($length));
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTextMaxIndex()
    {
    $generator = new Generator();
        $generator->addProvider(new Text($generator));
        $generator->seed(0);
    $generator->realText(200, 11);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTextMinIndex()
    {
    $generator = new Generator();
        $generator->addProvider(new Text($generator));
        $generator->seed(0);
        $generator->realText(200, 0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTextMinLength()
    {
    $generator = new Generator();
        $generator->addProvider(new Text($generator));
        $generator->seed(0);
        $generator->realText(9);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Faker\Test\Provider;

use Faker\Provider\UserAgent;
use PHPUnit\Framework\TestCase;

class UserAgentTest extends TestCase
{
    public function testRandomUserAgent()
    {
        $this->assertNotNull(UserAgent::userAgent());
    }

    public function testFirefoxUserAgent()
    {
        $this->stringContains(' Firefox/', UserAgent::firefox());
    }

    public function testSafariUserAgent()
    {
        $this->stringContains('Safari/', UserAgent::safari());
    }

    public function testInternetExplorerUserAgent()
    {
        $this->assertStringStartsWith('Mozilla/5.0 (compatible; MSIE ', UserAgent::internetExplorer());
    }

    public function testOperaUserAgent()
    {
        $this->assertStringStartsWith('Opera/', UserAgent::opera());
    }

    public function testChromeUserAgent()
    {
        $this->stringContains('(KHTML, like Gecko) Chrome/', UserAgent::chrome());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Faker\Test\Provider;

use Faker\Generator;
use Faker\Provider\Uuid as BaseProvider;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function testUuidReturnsUuid()
    {
        $uuid = BaseProvider::uuid();
        $this->assertTrue($this->isUuid($uuid));
    }

    public function testUuidExpectedSeed()
    {
        if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
            $this->markTestSkipped('Big Endian');
        }
        $faker = new Generator();
        $faker->seed(123);
        $this->assertEquals("8e2e0c84-50dd-367c-9e66-f3ab455c78d6", BaseProvider::uuid());
        $this->assertEquals("073eb60a-902c-30ab-93d0-a94db371f6c8", BaseProvider::uuid());
    }

    protected function isUuid($uuid)
    {
        return is_string($uuid) && (bool) preg_match('/^[a-f0-9]{8,8}-(?:[a-f0-9]{4,4}-){3,3}[a-f0-9]{12,12}$/i', $uuid);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

namespace Faker\Test\Provider\ar_JO;

use Faker\Generator;
use Faker\Provider\fi_FI\Person;
use Faker\Provider\fi_FI\Internet;
use Faker\Provider\fi_FI\Company;
use PHPUnit\Framework\TestCase;

class InternetTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    public function testEmailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Test\Provider\ar_SA;

use Faker\Generator;
use Faker\Provider\ar_SA\Person;
use Faker\Provider\ar_SA\Internet;
use Faker\Provider\ar_SA\Company;
use PHPUnit\Framework\TestCase;

class InternetTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    public function testEmailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Test\Provider\cs_CZ;

use Faker\Generator;
use Faker\Provider\cs_CZ\Person;
use Faker\Provider\Miscellaneous;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testBirthNumber()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Miscellaneous($faker));

        for ($i = 0; $i < 1000; $i++) {
            $birthNumber = $faker->birthNumber();
            $birthNumber = str_replace('/', '', $birthNumber);

            // check date
            $year = intval(substr($birthNumber, 0, 2), 10);
            $month = intval(substr($birthNumber, 2, 2), 10);
            $day = intval(substr($birthNumber, 4, 2), 10);

            // make 4 digit year from 2 digit representation
            $year += $year < 54 ? 2000 : 1900;

            // adjust special cases for month
            if ($month > 50) $month -= 50;
            if ($year >= 2004 && $month > 20) $month -= 20;

            $this->assertTrue(checkdate($month, $day, $year), "Birth number $birthNumber: date $year/$month/$day is invalid.");

            // check CRC if presented
            if (strlen($birthNumber) == 10) {
                $crc = intval(substr($birthNumber, -1), 10);
                $refCrc = intval(substr($birthNumber, 0, -1), 10) % 11;
                if ($refCrc == 10) {
                    $refCrc = 0;
                }
                $this->assertEquals($crc, $refCrc, "Birth number $birthNumber: checksum $crc doesn't match expected $refCrc.");
            }
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Faker\Test\Provider\da_DK;

use Faker\Generator;
use Faker\Provider\da_DK\Person;
use Faker\Provider\da_DK\Internet;
use Faker\Provider\da_DK\Company;
use PHPUnit\Framework\TestCase;

class InternetTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    public function testEmailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Test\Provider\de_AT;

use Faker\Generator;
use Faker\Provider\de_AT\Person;
use Faker\Provider\de_AT\Internet;
use Faker\Provider\de_AT\Company;
use PHPUnit\Framework\TestCase;

class InternetTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    public function testEmailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Test\Provider\de_CH;

use Faker\Generator;
use Faker\Provider\de_CH\Address;
use Faker\Provider\de_CH\Person;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }

    /**
     * @test
     */
    public function canton ()
    {
        $canton = $this->faker->canton();
        $this->assertInternalType('array', $canton);
        $this->assertCount(1, $canton);

        foreach ($canton as $cantonShort => $cantonName){
            $this->assertInternalType('string', $cantonShort);
            $this->assertEquals(2, strlen($cantonShort));
            $this->assertInternalType('string', $cantonName);
            $this->assertGreaterThan(2, strlen($cantonName));
        }
    }

    /**
     * @test
     */
    public function cantonName ()
    {
        $cantonName = $this->faker->cantonName();
        $this->assertInternalType('string', $cantonName);
        $this->assertGreaterThan(2, strlen($cantonName));
    }

    /**
     * @test
     */
    public function cantonShort ()
    {
        $cantonShort = $this->faker->cantonShort();
        $this->assertInternalType('string', $cantonShort);
        $this->assertEquals(2, strlen($cantonShort));
    }

    /**
     * @test
     */
    public function address (){
        $address = $this->faker->address();
        $this->assertInternalType('string', $address);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Faker\Test\Provider\de_CH;

use Faker\Generator;
use Faker\Provider\de_CH\Person;
use Faker\Provider\de_CH\Internet;
use Faker\Provider\de_CH\Company;
use PHPUnit\Framework\TestCase;

class InternetTest extends TestCase
{

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    /**
     * @test
     */
    public function emailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Faker\Test\Provider\de_CH;

use Faker\Generator;
use Faker\Provider\de_CH\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }

    public function testPhoneNumber()
    {
        $this->assertRegExp('/^0\d{2} ?\d{3} ?\d{2} ?\d{2}|\+41 ?(\(0\))?\d{2} ?\d{3} ?\d{2} ?\d{2}$/', $this->faker->phoneNumber());
    }

    public function testMobileNumber()
    {
        $this->assertRegExp('/^07[56789] ?\d{3} ?\d{2} ?\d{2}$/', $this->faker->mobileNumber());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Faker\Test\Provider\de_DE;

use Faker\Generator;
use Faker\Provider\de_DE\Person;
use Faker\Provider\de_DE\Internet;
use Faker\Provider\de_DE\Company;
use PHPUnit\Framework\TestCase;

class InternetTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    public function testEmailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Faker\Test\Provider\el_GR;

use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    private $textClass;

    public function setUp()
    {
        $this->textClass = new \ReflectionClass('Faker\Provider\el_GR\Text');
    }

    protected function getMethod($name) {
        $method = $this->textClass->getMethod($name);

        $method->setAccessible(true);

        return $method;
    }

    /** @test */
    function testItShouldAppendEndPunctToTheEndOfString()
    {
        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, array('Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ '))
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, array('Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ—'))
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, array('Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ,'))
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ!.',
            $this->getMethod('appendEnd')->invokeArgs(null, array('Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ! '))
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, array('Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ; '))
        );

        $this->assertSame(
            'Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ.',
            $this->getMethod('appendEnd')->invokeArgs(null, array('Και δεν άκουσες το κλοπακλόπ, κλοπακλόπ, κλοπακλόπ: '))
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace Faker\Provider\en_AU;

use Faker\Generator;
use Faker\Provider\en_AU\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

  /**
   * @var Faker\Generator
   */
  private $faker;

  public function setUp()
  {
    $faker = new Generator();
    $faker->addProvider(new Address($faker));
    $this->faker = $faker;
  }

  public function testCityPrefix()
  {
    $cityPrefix = $this->faker->cityPrefix();
    $this->assertNotEmpty($cityPrefix);
    $this->assertInternalType('string', $cityPrefix);
    $this->assertRegExp('/[A-Z][a-z]+/', $cityPrefix);
  }

  public function testStreetSuffix()
  {
    $streetSuffix = $this->faker->streetSuffix();
    $this->assertNotEmpty($streetSuffix);
    $this->assertInternalType('string', $streetSuffix);
    $this->assertRegExp('/[A-Z][a-z]+/', $streetSuffix);
  }

  public function testState()
  {
    $state = $this->faker->state();
    $this->assertNotEmpty($state);
    $this->assertInternalType('string', $state);
    $this->assertRegExp('/[A-Z][a-z]+/', $state);
  }
}

?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Faker\Provider\en_CA;

use Faker\Generator;
use Faker\Provider\en_CA\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

  /**
   * @var Faker\Generator
   */
  private $faker;

  public function setUp()
  {
    $faker = new Generator();
    $faker->addProvider(new Address($faker));
    $this->faker = $faker;
  }

  /**
   * Test the validity of province
   */
  public function testProvince()
  {
    $province = $this->faker->province();
    $this->assertNotEmpty($province);
    $this->assertInternalType('string', $province);
    $this->assertRegExp('/[A-Z][a-z]+/', $province);
  }

  /**
   * Test the validity of province abbreviation
   */
  public function testProvinceAbbr()
  {
    $provinceAbbr = $this->faker->provinceAbbr();
    $this->assertNotEmpty($provinceAbbr);
    $this->assertInternalType('string', $provinceAbbr);
    $this->assertRegExp('/^[A-Z]{2}$/', $provinceAbbr);
  }

  /**
   * Test the validity of postcode letter
   */
  public function testPostcodeLetter()
  {
    $postcodeLetter = $this->faker->randomPostcodeLetter();
    $this->assertNotEmpty($postcodeLetter);
    $this->assertInternalType('string', $postcodeLetter);
    $this->assertRegExp('/^[A-Z]{1}$/', $postcodeLetter);
  }

  /**
   * Test the validity of Canadian postcode
   */
  public function testPostcode()
  {
    $postcode = $this->faker->postcode();
    $this->assertNotEmpty($postcode);
    $this->assertInternalType('string', $postcode);
    $this->assertRegExp('/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/', $postcode);
  }
}

?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace Faker\Provider\en_GB;

use Faker\Generator;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));
        $this->faker = $faker;
    }

    /**
     *
     */
    public function testPostcode()
    {

        $postcode = $this->faker->postcode();
        $this->assertNotEmpty($postcode);
        $this->assertInternalType('string', $postcode);
        $this->assertRegExp('@^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$@i', $postcode);

    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

namespace Faker\Provider\en_IN;

use Faker\Generator;
use Faker\Provider\en_IN\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

  /**
   * @var Faker\Generator
   */
  private $faker;

  public function setUp()
  {
    $faker = new Generator();
    $faker->addProvider(new Address($faker));
    $this->faker = $faker;
  }

  public function testCity()
  {
    $city = $this->faker->city();
    $this->assertNotEmpty($city);
    $this->assertInternalType('string', $city);
    $this->assertRegExp('/[A-Z][a-z]+/', $city);
  }

  public function testCountry()
  {
    $country = $this->faker->country();
    $this->assertNotEmpty($country);
    $this->assertInternalType('string', $country);
    $this->assertRegExp('/[A-Z][a-z]+/', $country);
  }

  public function testLocalityName()
  {
    $localityName = $this->faker->localityName();
    $this->assertNotEmpty($localityName);
    $this->assertInternalType('string', $localityName);
    $this->assertRegExp('/[A-Z][a-z]+/', $localityName);
  }

  public function testAreaSuffix()
  {
    $areaSuffix = $this->faker->areaSuffix();
    $this->assertNotEmpty($areaSuffix);
    $this->assertInternalType('string', $areaSuffix);
    $this->assertRegExp('/[A-Z][a-z]+/', $areaSuffix);
  }
}

?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Faker\Provider\ng_NG;

use Faker\Generator;
use Faker\Provider\en_NG\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));
        $this->faker = $faker;
    }

    /**
     *
     */
    public function testPostcodeIsNotEmptyAndIsValid()
    {
        $postcode = $this->faker->postcode();

        $this->assertNotEmpty($postcode);
        $this->assertInternalType('string', $postcode);
    }

    /**
     * Test the name of the Nigerian State/County
     */
    public function testCountyIsAValidString()
    {
        $county = $this->faker->county;

        $this->assertNotEmpty($county);
        $this->assertInternalType('string', $county);
    }

    /**
     * Test the name of the Nigerian Region in a State.
     */
    public function testRegionIsAValidString()
    {
        $region = $this->faker->region;

        $this->assertNotEmpty($region);
        $this->assertInternalType('string', $region);
    }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

namespace Faker\Test\Provider\ng_NG;

use Faker\Generator;
use Faker\Provider\en_NG\Person;
use Faker\Provider\en_NG\Internet;
use PHPUnit\Framework\TestCase;

class InternetTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $this->faker = $faker;
    }

    public function testEmailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
        $this->assertNotEmpty($email);
        $this->assertInternalType('string', $email);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Faker\Test\Provider\en_NZ;

use Faker\Generator;
use Faker\Provider\en_NZ\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }

    public function testIfPhoneNumberCanReturnData()
    {
      $number = $this->faker->phoneNumber;
      $this->assertNotEmpty($number);
    }

    public function phoneNumberFormat()
    {
      $number = $this->faker->phoneNumber;
      $this->assertRegExp('/(^\([0]\d{1}\))(\d{7}$)|(^\([0][2]\d{1}\))(\d{6,8}$)|([0][8][0][0])([\s])(\d{5,8}$)/', $number);
    }
}
?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        INDX( 	 �3n            (   �  �         r �  �  �        0     ` L     �     N^�ok�ذ`�ok�ذ`�ok�N^�ok�                        e n _ G B o r 2     ` L     �     �c�ok��ue�ok��ue�ok��c�ok�                        e n _ I N o r 4     ` L     �     ��g�ok�~�s�ok�~�s�ok���g�ok�                        e n _ N G o r 9     ` L     �     ~�s�ok��&v�ok��&v�ok�~�s�ok�                        e n _ N Z o r ;     ` L     �     �x�ok�k�z�ok�k�z�ok��x�ok�                       e n _ P H o r =     ` L     �     �M}�ok����ok����ok��M}�ok�                        e n _ S G o r @     ` L     �     �t��ok�R׆�ok�R׆�ok��t��ok�                        e n _ U G o r B     ` L     �     �9��ok�z��ok�z��ok��9��ok�                        e n _ U S o r G     ` L     �     s��ok�q#��ok�q#��ok�s��ok�                        e n _ Z A o r L     ` L     �     q#��ok�b��ok�b��ok�q#��ok�                        e s _ E S o  P     ` L     �     b��ok��q��ok��q��ok�b��ok�                        e s _ P E o r R     ` L     �     ����ok�W���ok�W���ok�����ok�                        e s _ V E o r U     ` L     �     ����ok��"��ok��"��ok�����ok�                        f i _ F I o r X     ` L     �     �"��ok�����ok�����ok��"��ok�                        f r _ B E o r Z     ` L     �     ����ok��p��ok��p��ok�����ok�                        f r _ C H o r ^     ` L     �     1���ok ��4�ok���4�ok�1���ok�                        f r _ F R o r      x d     �     ���ok� Uze�����<����ok�       �               H t m l L o r e m T e s t . p h p     e     ` L     �     /E7�ok�
<�ok�
<�ok�/E7�ok�                        i d _ I D T e      p \     �     ����ok� Uze�,��<�����ok�       �	               I m a g e T e s t . p h p          x b     �     ]���ok� Uze�,��<�]���ok�        I               I n t e r n e t T e s t . p h p                    �     
<�ok����]%�
<�ok�
<�ok�                        i t _ C H i z k     ` L     �     #Q�ok��Z��]%�w�S�ok�#Q�ok�                        i t _ I T i z n     ` L     �     D�X�ok�B��]%�2	[�ok�D�X�ok�                        j a _ J P i z r     ` L     �     Wi�ok�����]%�Wi�ok�Wi�ok�                        k a _ G E i z t     ` L     �     ~p�ok�1EǺ]%���P�ok�~p�ok�                        k k _ K Z i z x     ` L     �     �f�ok e1Ӻ]%��sh�ok��f�ok�                        k o _ K R i z 	     � j     �      K��ok� Uze�)���<� K��ok�                      L o c a l i z a t i o n T e s t . p h p       
     p \     �     ��ok� Uze������<���ok�                      L o r e m T e s t . p h p          � l     �     S7�ok� Uze�S���<�S7�ok�       q               M i s c e l l a n e o u s T e s t . p h p     z     ` L     �     '�o�ok�}�ܺ]%�'�o�ok�'�o�ok�                       m n _ M N n t |     ` L     �     �#y�ok����]%��#y�ok��#y�ok�                        m s _ M Y n t      p `     �     u��ok� Uze�S���<�u��ok�        �               P a y m e n t T e s t . p h p      p ^     �     ���ok� Uze�S���<����ok�       �	               P e r s o n T e s t . p h p        x h     �     ����ok� Uze�*����<�����ok�       �               P h o n e N u m b e r T e s t . p h p      � r     �     �R�ok� Uze�����<��R�ok         s               P r o v i d e r O v e r r i d e T e s t . p h p            p Z     �     ��ok� Uze�����<���ok�       C               T e x t T e s t . p h p            x d     �     �y�ok� Uze��z���<��y�ok�       �               U s e r A g e n t T e s t . p h p          p Z     �     ��
�ok� Uze�K���<���
�ok�       �               U u i d T e s t . p h p                                                                                            <?php

namespace Faker\Test\Provider\en_PH;

use Faker\Generator;
use Faker\Provider\en_PH\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function setUp()
    {
      $faker = new Generator();
      $faker->addProvider(new Address($faker));
      $this->faker = $faker;
    }

    public function testProvince()
    {
      $province = $this->faker->province();
      $this->assertNotEmpty($province);
      $this->assertInternalType('string', $province);
    }

    public function testCity()
    {
      $city = $this->faker->city();
      $this->assertNotEmpty($city);
      $this->assertInternalType('string', $city);
    }

    public function testMunicipality()
    {
      $municipality = $this->faker->municipality();
      $this->assertNotEmpty($municipality);
      $this->assertInternalType('string', $municipality);
    }

    public function testBarangay()
    {
      $barangay = $this->faker->barangay();
      $this->assertInternalType('string', $barangay);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           