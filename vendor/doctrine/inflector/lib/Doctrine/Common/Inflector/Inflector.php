 * *');
        $current = new DateTime('now');
        $next = $cron->getNextRunDate($current);
        $nextPrev = $cron->getPreviousRunDate($next);
        $this->assertSame($current->format('Y-m-d H:i:00'), $nextPrev->format('Y-m-d H:i:s'));
    }

    /**
     * @covers \Cron\CronExpression::getRunDate
     * @ticket 7
     */
    public function testStripsForSeconds()
    {
        $cron = CronExpression::factory('* * * * *');
        $current = new DateTime('2011-09-27 10:10:54');
        $this->assertSame('2011-09-27 10:11:00', $cron->getNextRunDate($current)->format('Y-m-d H:i:s'));
    }

    /**
     * @covers \Cron\CronExpression::getRunDate
     */
    public function testFixesPhpBugInDateIntervalMonth()
    {
        $cron = CronExpression::factory('0 0 27 JAN *');
        $this->assertSame('2011-01-27 00:00:00', $cron->getPreviousRunDate('2011-08-22 00:00:00')->format('Y-m-d H:i:s'));
    }

    public function testIssue29()
    {
        $cron = CronExpression::factory('@weekly');
        $this->assertSame(
            '2013-03-10 00:00:00',
            $cron->getPreviousRunDate('2013-03-17 00:00:00')->format('Y-m-d H:i:s')
        );
    }

    /**
     * @see https://github.com/mtdowling/cron-expression/issues/20
     */
    public function testIssue20() {
        $e = CronExpression::factory('* * * * MON#1');
        $this->assertTrue($e->isDue(new DateTime('2014-04-07 00:00:00')));
        $this->assertFalse($e->isDue(new DateTime('2014-04-14 00:00:00')));
        $this->assertFalse($e->isDue(new DateTime('2014-04-21 00:00:00')));

        $e = CronExpression::factory('* * * * SAT#2');
        $this->assertFalse($e->isDue(new DateTime('2014-04-05 00:00:00')));
        $this->assertTrue($e->isDue(new DateTime('2014-04-12 00:00:00')));
        $this->assertFalse($e->isDue(new DateTime('2014-04-19 00:00:00')));

        $e = CronExpression::factory('* * * * SUN#3');
        $this->assertFalse($e->isDue(new DateTime('2014-04-13 00:00:00')));
        $this->assertTrue($e->isDue(new DateTime('2014-04-20 00:00:00')));
        $this->assertFalse($e->isDue(new DateTime('2014-04-27 00:00:00')));
    }

    /**
     * @covers \Cron\CronExpression::getRunDate
     */
    public function testKeepOriginalTime()
    {
        $now = new \DateTime;
        $strNow = $now->format(DateTime::ISO8601);
        $cron = CronExpression::factory('0 0 * * *');
        $cron->getPreviousRunDate($now);
        $this->assertSame($strNow, $now->format(DateTime::ISO8601));
    }

    /**
     * @covers \Cron\CronExpression::__construct
     * @covers \Cron\CronExpression::factory
     * @covers \Cron\CronExpression::isValidExpression
     * @covers \Cron\CronExpression::setExpression
     * @covers \Cron\CronExpression::setPart
     */
    public function testValidationWorks()
    {
        // Invalid. Only four values
        $this->assertFalse(CronExpression::isValidExpression('* * * 1'));
        // Valid
        $this->assertTrue(CronExpression::isValidExpression('* * * * 1'));

        // Issue #156, 13 is an invalid month
        $this->assertFalse(CronExpression::isValidExpression("* * * 13 * "));

        // Issue #155, 90 is an invalid second
        $this->assertFalse(CronExpression::isValidExpression('90 * * * *'));

        // Issue #154, 24 is an invalid hour
        $this->assertFalse(CronExpression::isValidExpression("0 24 1 12 0"));

        // Issue #125, this is just all sorts of wrong
        $this->assertFalse(CronExpression::isValidExpression('990 14 * * mon-fri0345345'));

        // see https://github.com/dragonmantank/cron-expression/issues/5
        $this->assertTrue(CronExpression::isValidExpression('2,17,35,47 5-7,11-13 * * *'));
    }

    /**
     * Makes sure that 00 is considered a valid value for 0-based fields
     * cronie allows numbers with a leading 0, so adding support for this as well
     *
     * @see https://github.com/dragonmantank/cron-expression/issues/12
     */
    public function testDoubleZeroIsValid()
    {
        $this->assertTrue(CronExpression::isValidExpression('00 * * * *'));
        $this->assertTrue(CronExpression::isValidExpression('01 * * * *'));
        $this->assertTrue(CronExpression::isValidExpression('* 00 * * *'));
        $this->assertTrue(CronExpression::isValidExpression('* 01 * * *'));

        $e = CronExpression::factory('00 * * * *');
        $this->assertTrue($e->isDue(new DateTime('2014-04-07 00:00:00')));
        $e = CronExpression::factory('01 * * * *');
        $this->assertTrue($e->isDue(new DateTime('2014-04-07 00:01:00')));

        $e = CronExpression::factory('* 00 * * *');
        $this->assertTrue($e->isDue(new DateTime('2014-04-07 00:00:00')));
        $e = CronExpression::factory('* 01 * * *');
        $this->assertTrue($e->isDue(new DateTime('2014-04-07 01:00:00')));
    }


    /**
     * Ranges with large steps should "wrap around" to the appropriate value
     * cronie allows for steps that are larger than the range of a field, with it wrapping around like a ring buffer. We
     * should do the same.
     *
     * @see https://github.com/dragonmantank/cron-expression/issues/6
     */
    public function testRangesWrapAroundWithLargeSteps()
    {
        $f = new MonthField();
        $this->assertTrue($f->validate('*/123'));
        $this->assertSame([4], $f->getRangeForExpression('*/123', 12));

        $e = CronExpression::factory('* * * */123 *');
        $this->assertTrue($e->isDue(new DateTime('2014-04-07 00:00:00')));

        $nextRunDate = $e->getNextRunDate(new DateTime('2014-04-07 00:00:00'));
        $this->assertSame('2014-04-07 00:01:00', $nextRunDate->format('Y-m-d H:i:s'));

        $nextRunDate = $e->getNextRunDate(new DateTime('2014-05-07 00:00:00'));
        $this->assertSame('2015-04-01 00:00:00', $nextRunDate->format('Y-m-d H:i:s'));
    }

    /**
     * When there is an issue with a field, we should report the human readable position
     *
     * @see https://github.com/dragonmantank/cron-expression/issues/29
     */
    public function testFieldPositionIsHumanAdjusted()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("6 is not a valid position");
        $e = CronExpression::factory('0 * * * * ? *');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Cron\Tests;

use Cron\DayOfMonthField;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class DayOfMonthFieldTest extends TestCase
{
    /**
     * @covers \Cron\DayOfMonthField::validate
     */
    public function testValidatesField()
    {
        $f = new DayOfMonthField();
        $this->assertTrue($f->validate('1'));
        $this->assertTrue($f->validate('*'));
        $this->assertTrue($f->validate('L'));
        $this->assertTrue($f->validate('5W'));
        $this->assertTrue($f->validate('01'));
        $this->assertFalse($f->validate('5W,L'));
        $this->assertFalse($f->validate('1.'));
    }

    /**
     * @covers \Cron\DayOfMonthField::isSatisfiedBy
     */
    public function testChecksIfSatisfied()
    {
        $f = new DayOfMonthField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime(), '?'));
        $this->assertTrue($f->isSatisfiedBy(new DateTimeImmutable(), '?'));
    }

    /**
     * @covers \Cron\DayOfMonthField::increment
     */
    public function testIncrementsDate()
    {
        $d = new DateTime('2011-03-15 11:15:00');
        $f = new DayOfMonthField();
        $f->increment($d);
        $this->assertSame('2011-03-16 00:00:00', $d->format('Y-m-d H:i:s'));

        $d = new DateTime('2011-03-15 11:15:00');
        $f->increment($d, true);
        $this->assertSame('2011-03-14 23:59:00', $d->format('Y-m-d H:i:s'));
    }

    /**
     * @covers \Cron\DayOfMonthField::increment
     */
    public function testIncrementsDateTimeImmutable()
    {
        $d = new DateTimeImmutable('2011-03-15 11:15:00');
        $f = new DayOfMonthField();
        $f->increment($d);
        $this->assertSame('2011-03-16 00:00:00', $d->format('Y-m-d H:i:s'));
    }

    /**
     * Day of the month cannot accept a 0 value, it must be between 1 and 31
     * See Github issue #120
     *
     * @since 2017-01-22
     */
    public function testDoesNotAccept0Date()
    {
        $f = new DayOfMonthField();
        $this->assertFalse($f->validate(0));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

namespace Cron\Tests;

use Cron\DayOfWeekField;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class DayOfWeekFieldTest extends TestCase
{
    /**
     * @covers \Cron\DayOfWeekField::validate
     */
    public function testValidatesField()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->validate('1'));
        $this->assertTrue($f->validate('01'));
        $this->assertTrue($f->validate('00'));
        $this->assertTrue($f->validate('*'));
        $this->assertFalse($f->validate('*/3,1,1-12'));
        $this->assertTrue($f->validate('SUN-2'));
        $this->assertFalse($f->validate('1.'));
    }

    /**
     * @covers \Cron\DayOfWeekField::isSatisfiedBy
     */
    public function testChecksIfSatisfied()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime(), '?'));
        $this->assertTrue($f->isSatisfiedBy(new DateTimeImmutable(), '?'));
    }

    /**
     * @covers \Cron\DayOfWeekField::increment
     */
    public function testIncrementsDate()
    {
        $d = new DateTime('2011-03-15 11:15:00');
        $f = new DayOfWeekField();
        $f->increment($d);
        $this->assertSame('2011-03-16 00:00:00', $d->format('Y-m-d H:i:s'));

        $d = new DateTime('2011-03-15 11:15:00');
        $f->increment($d, true);
        $this->assertSame('2011-03-14 23:59:00', $d->format('Y-m-d H:i:s'));
    }

    /**
     * @covers \Cron\DayOfWeekField::increment
     */
    public function testIncrementsDateTimeImmutable()
    {
        $d = new DateTimeImmutable('2011-03-15 11:15:00');
        $f = new DayOfWeekField();
        $f->increment($d);
        $this->assertSame('2011-03-16 00:00:00', $d->format('Y-m-d H:i:s'));
    }

    /**
     * @covers \Cron\DayOfWeekField::isSatisfiedBy
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Weekday must be a value between 0 and 7. 12 given
     */
    public function testValidatesHashValueWeekday()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime(), '12#1'));
    }

    /**
     * @covers \Cron\DayOfWeekField::isSatisfiedBy
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage There are never more than 5 or less than 1 of a given weekday in a month
     */
    public function testValidatesHashValueNth()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime(), '3#6'));
    }

    /**
     * @covers \Cron\DayOfWeekField::validate
     */
    public function testValidateWeekendHash()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->validate('MON#1'));
        $this->assertTrue($f->validate('TUE#2'));
        $this->assertTrue($f->validate('WED#3'));
        $this->assertTrue($f->validate('THU#4'));
        $this->assertTrue($f->validate('FRI#5'));
        $this->assertTrue($f->validate('SAT#1'));
        $this->assertTrue($f->validate('SUN#3'));
        $this->assertTrue($f->validate('MON#1,MON#3'));
    }

    /**
     * @covers \Cron\DayOfWeekField::isSatisfiedBy
     */
    public function testHandlesZeroAndSevenDayOfTheWeekValues()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2011-09-04 00:00:00'), '0-2'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2011-09-04 00:00:00'), '6-0'));

        $this->assertTrue($f->isSatisfiedBy(new DateTime('2014-04-20 00:00:00'), 'SUN'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2014-04-20 00:00:00'), 'SUN#3'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2014-04-20 00:00:00'), '0#3'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2014-04-20 00:00:00'), '7#3'));
    }

    /**
     * @covers \Cron\DayOfWeekField::isSatisfiedBy
     */
    public function testHandlesLastWeekdayOfTheMonth()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2018-12-28 00:00:00'), 'FRIL'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2018-12-28 00:00:00'), '5L'));
        $this->assertFalse($f->isSatisfiedBy(new DateTime('2018-12-21 00:00:00'), 'FRIL'));
        $this->assertFalse($f->isSatisfiedBy(new DateTime('2018-12-21 00:00:00'), '5L'));
    }

    /**
     * @see https://github.com/mtdowling/cron-expression/issues/47
     */
    public function testIssue47() {
        $f = new DayOfWeekField();
        $this->assertFalse($f->validate('mon,'));
        $this->assertFalse($f->validate('mon-'));
        $this->assertFalse($f->validate('*/2,'));
        $this->assertFalse($f->validate('-mon'));
        $this->assertFalse($f->validate(',1'));
        $this->assertFalse($f->validate('*-'));
        $this->assertFalse($f->validate(',-'));
    }

    /**
     * @see https://github.com/laravel/framework/commit/07d160ac3cc9764d5b429734ffce4fa311385403
     */
    public function testLiteralsExpandProperly()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->validate('MON-FRI'));
        $this->assertSame([1,2,3,4,5], $f->getRangeForExpression('MON-FRI', 7));
    }
}
                                                                                                                                                                                           