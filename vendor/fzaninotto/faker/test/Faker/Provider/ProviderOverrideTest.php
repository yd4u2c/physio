<?php

namespace Faker\Test\Provider\nl_BE;

use Faker\Generator;
use Faker\Provider\nl_BE\Person;
use PHPUnit\Framework\TestCase;
use Datetime;

/**
 * @group Person
 */
class PersonTest extends TestCase
{
    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }

    public function testRrnIsValid()
    {
        $rrn = $this->faker->rrn();

        $this->assertEquals(11, strlen($rrn));

        $ctrlNumber = substr($rrn, 9, 2);
        $calcCtrl = 97 - (substr($rrn, 0, 9) % 97);
        $altcalcCtrl = 97 - ((2 . substr($rrn, 0, 9)) % 97);
        $this->assertContains($ctrlNumber, array($calcCtrl, $altcalcCtrl));

        $middle = substr($rrn, 6, 3);
        $this->assertGreaterThan(1, $middle);
        $this->assertLessThan(997, $middle);
    }

    public function testRrnIsMale()
    {
        $rrn = $this->faker->rrn('male');
        $this->assertEquals(substr($rrn, 6, 3) % 2, 1);
    }

    public function testRrnIsFemale()
    {
        $rrn = $this->faker->rrn('female');
        $this->assertEquals(substr($rrn, 6, 3) % 2, 0);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Faker\Test\Provider\nl_NL;

use Faker\Generator;
use Faker\Provider\nl_NL\Company;
use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    public function testGenerateValidVatNumber()
    {
        $vatNo = $this->faker->vat();

        $this->assertEquals(14, strlen($vatNo));
        $this->assertRegExp('/^NL[0-9]{9}B[0-9]{2}$/', $vatNo);
    }

    public function testGenerateValidBtwNumberAlias()
    {
        $btwNo = $this->faker->btw();

        $this->assertEquals(14, strlen($btwNo));
        $this->assertRegExp('/^NL[0-9]{9}B[0-9]{2}$/', $btwNo);
    }
}
                                                                                                                                                                                                                                                                                                                                                                      