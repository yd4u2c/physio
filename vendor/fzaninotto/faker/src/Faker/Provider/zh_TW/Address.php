�而不圓，卻是他“行狀”上的一個汙點。但不多時也就釋然了，他想：孫子纔畫得很圓的圓圈呢。於是他睡著了。
然而這一夜，舉人老爺反而不能睡：他和把總嘔了氣了。舉人老爺主張第一要追贓，把總主張第一要示眾。把總近來很不將舉人老爺放在眼裏了，拍案打凳的說道，“懲一儆百！你看，我做革命黨還不上二十天，搶案就是十幾件，全不破案，我的面子在那裏？破了案，你又來迂。不成！這是我管的！”舉人老爺窘急了，然而還堅持，說是倘若不追贓，他便立刻辭了幫辦民政的職務。而把總卻道，“請便罷！”於是舉人老爺在這一夜竟沒有睡，但幸第二天倒也沒有辭。
阿Q第三次抓出柵欄門的時候，便是舉人老爺睡不著的那一夜的明天的上午了。他到了大堂，上面還坐著照例的光頭老頭子；阿Q也照例的下了跪。
老頭子很和氣的問道，“你還有什麼話麽？”
阿Q一想，沒有話，便回答說，“沒有。”
許多長衫和短衫人物，忽然給他穿上一件洋布的白背心，上面有些黑字。阿Q很氣苦：因為這很像是帶孝，而帶孝是晦氣的。然而同時他的兩手反縛了，同時又被一直抓出衙門外去了。
阿Q被抬上了一輛沒有蓬的車，幾個短衣人物也和他同坐在一處。這車立刻走動了，前面是一班背著洋炮的兵們和團丁，兩旁是許多張著嘴的看客，後面怎樣，阿Q沒有見。但他突然覺到了：這豈不是去殺頭麽？他一急，兩眼發黑，耳朵裏喤的一聲，似乎發昏了。然而他又沒有全發昏，有時雖然著急，有時卻也泰然；他意思之間，似乎覺得人生天地間，大約本來有時也未免要殺頭的。
他還認得路，於是有些詫異了：怎麼不向著法場走呢？他不知道這是在遊街，在示眾。但即使知道也一樣，他不過便以為人生天地間，大約本來有時也未免要遊街要示眾罷了
他省悟了，這是繞到法場去的路，這一定是“嚓”的去殺頭。他惘惘的向左右看，全跟著馬蟻似的人，而在無意中，卻在路旁的人叢中發見了一個吳媽。很久違，伊原來在城裏做工了。阿Q忽然很羞愧自己沒志氣：竟沒有唱幾句戲。他的思想仿佛旋風似的在腦裏一迴旋：《小孤孀上墳》欠堂皇，《龍虎鬥》裏的“悔不該……”也太乏，還是“手執鋼鞭將你打”罷。他同時想手一揚，纔記得這兩手原來都捆著，於是“手執鋼鞭”也不唱了。
“過了二十年又是一個……”阿Q在百忙中，“無師自通”的說出半句從來不說的話。
“好！！！”從人叢裏，便發出豺狼的嗥叫一般的聲音來。
車子不住的前行，阿Q在喝采聲中，輪轉眼睛去看吳媽，似乎伊一向並沒有見他，卻只是出神的看著兵們背上的洋炮。
阿Q於是再看那些喝采的人們
這剎那中，他的思想又仿佛旋風似的在腦裏一迴旋了。四年之前，他曾在山腳下遇見一隻餓狼，永是不近不遠的跟定他，要吃他的肉。他那時嚇得幾乎要死，幸而手裏有一柄斫柴刀，纔得仗這壯了膽，支持到未莊；可是永遠記得那狼眼睛，又凶又怯，閃閃的像兩顆鬼火，似乎遠遠的來穿透了他的皮肉。而這回他又看見從來沒有見過的更可怕的眼睛了，又鈍又鋒利，不但已經咀嚼了他的話，並且還要咀嚼他皮肉以外的東西，永是不近不遠的跟他走。
這些睛們似乎連成一氣，已經在那裏咬他的靈魂。
“救命，……”
然而阿Q沒有說。他早就兩眼發黑，耳朵裏嗡的一聲，覺得全身仿佛微塵似的迸散了。
至於當時的影響，最大的倒反在舉人老爺，因為終於沒有追贓，他全家都號啕了。其次是趙府，非特秀才因為上城去報官，被不好的革命黨剪了辮子，而且又破費了二十千的賞錢，所以全家也號啕了。從這一天以來，他們便漸漸的都發生了遺老的氣味。
至於輿論，在未莊是無異議，自然都說阿Q壞，被槍斃便是他的壞的證據：不壞又何至於被槍斃呢？而城裏的輿論卻不佳，他們多半不滿足，以為槍斃並無殺頭這般好看；而且那是怎樣的一個可笑的死囚呵，游了那麼久的街，竟沒有唱一句戲：他們白跟一趟了。
EOT;

    protected static $encoding = 'UTF-8';

    protected static function explode($text)
    {
        $chars = array();

        foreach (preg_split('//u', str_replace(PHP_EOL, '', $text)) as $char) {
            if (! empty($char)) {
                $chars[] = $char;
            }
        }

        return $chars;
    }

    protected static function strlen($text)
    {
        return function_exists('mb_strlen')
            ? mb_strlen($text, static::$encoding)
            : count(static::explode($text));
    }

    protected static function validStart($word)
    {
        return ! in_array($word, static::$notBeginPunct);
    }

    protected static function appendEnd($text)
    {
        $mbAvailable = extension_loaded('mbstring');

        // extract the last char of $text
        if ($mbAvailable) {
            // in order to support php 5.3, third param use 1 instead of null
            // https://secure.php.net/manual/en/function.mb-substr.php#refsect1-function.mb-substr-changelog
            $last = mb_substr($text, mb_strlen($text, static::$encoding) - 1, 1, static::$encoding);
        } else {
            $chars = static::utf8Encoding($text);
            $last = $chars[count($chars) - 1];
        }

        // if the last char is a not-valid-end punctuation, remove it
        if (in_array($last, static::$notEndPunct)) {
            if ($mbAvailable) {
                $text = mb_substr($text, 0, mb_strlen($text, static::$encoding) - 1, static::$encoding);
            } else {
                array_pop($chars);
                $text = implode('', $chars);
            }
        }

        // if the last char is not a valid punctuation, append a default one.
        return in_array($last, static::$endPunct) ? $text : $text . '。';
    }

    /**
     * Convert original string to utf-8 encoding.
     *
     * @param string $text
     * @return array
     */
    protected static function utf8Encoding($text)
    {
        $encoding = array();

        $chars = str_split($text);

        $countChars = count($chars);

        for ($i = 0; $i < $countChars; ++$i) {
            $temp = $chars[$i];

            $ord = ord($chars[$i]);

            switch (true) {
                case $ord > 251:
                    $temp .= $chars[++$i];
                    // no break
                case $ord > 247:
                    $temp .= $chars[++$i];
                    // no break
                case $ord > 239:
                    $temp .= $chars[++$i];
                    // no break
                case $ord > 223:
                    $temp .= $chars[++$i];
                    // no break
                case $ord > 191:
                    $temp .= $chars[++$i];
                    // no break
            }

            $encoding[] = $temp;
        }

        return $encoding;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
require __DIR__ .'/../vendor/autoload.php';
$faker = Faker\Factory::create();
$faker->seed(5);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<contacts>
<?php for ($i=0; $i < 10; $i++): ?>
  <contact firstName="<?php echo $faker->firstName ?>" lastName="<?php echo $faker->lastName ?>" email="<?php echo $faker->email ?>" >
    <phone number="<?php echo $faker->phoneNumber ?>"/>
<?php if ($faker->boolean(25)): ?>
    <birth date="<?php echo $faker->dateTimeThisCentury->format('Y-m-d') ?>" place="<?php echo $faker->city ?>"/>
<?php endif; ?>
    <address>
      <street><?php echo $faker->streetAddress ?></street>
      <city><?php echo $faker->city ?></city>
      <postcode><?php echo $faker->postcode ?></postcode>
      <state><?php echo $faker->state ?></state>
    </address>
    <company name="<?php echo $faker->company ?>" catchPhrase="<?php echo $faker->catchPhrase ?>">
<?php if ($faker->boolean(33)): ?>
      <offer><?php echo $faker->bs ?></offer>
<?php endif; ?>
<?php if ($faker->boolean(33)): ?>
      <director name="<?php echo $faker->name ?>" />
<?php endif; ?>
    </company>
<?php if ($faker->boolean(15)): ?>
    <details>
<![CDATA[
<?php echo $faker->text(400) ?>
]]>
    </details>
<?php endif; ?>
  </contact>
<?php endfor; ?>
</contacts>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Faker\Test;

use Faker\DefaultGenerator;
use PHPUnit\Framework\TestCase;

class DefaultGeneratorTest extends TestCase
{
    public function testGeneratorReturnsNullByDefault()
    {
        $generator = new DefaultGenerator;
        $this->assertNull($generator->value);
    }

    public function testGeneratorReturnsDefaultValueForAnyPropertyGet()
    {
        $generator = new DefaultGenerator(123);
        $this->assertSame(123, $generator->foo);
        $this->assertNotNull($generator->bar);
    }

    public function testGeneratorReturnsDefaultValueForAnyMethodCall()
    {
        $generator = new DefaultGenerator(123);
        $this->assertSame(123, $generator->foobar());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Faker\Test;

use Faker\Generator;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    public function testAddProviderGivesPriorityToNewlyAddedProvider()
    {
        $generator = new Generator;
        $generator->addProvider(new FooProvider());
        $generator->addProvider(new BarProvider());
        $this->assertEquals('barfoo', $generator->format('fooFormatter'));
    }

    public function testGetFormatterReturnsCallable()
    {
        $generator = new Generator;
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $this->assertInternalType('callable', $generator->getFormatter('fooFormatter'));
    }

    public function testGetFormatterReturnsCorrectFormatter()
    {
        $generator = new Generator;
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $expected = array($provider, 'fooFormatter');
        $this->assertEquals($expected, $generator->getFormatter('fooFormatter'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetFormatterThrowsExceptionOnIncorrectProvider()
    {
        $generator = new Generator;
        $generator->getFormatter('fooFormatter');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetFormatterThrowsExceptionOnIncorrectFormatter()
    {
        $generator = new Generator;
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $generator->getFormatter('barFormatter');
    }

    public function testFormatCallsFormatterOnProvider()
    {
        $generator = new Generator;
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $this->assertEquals('foobar', $generator->format('fooFormatter'));
    }

    public function testFormatTransfersArgumentsToFormatter()
    {
        $generator = new Generator;
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $this->assertEquals('bazfoo', $generator->format('fooFormatterWithArguments', array('foo')));
    }

    public function testParseReturnsSameStringWhenItContainsNoCurlyBraces()
    {
        $generator = new Generator();
        $this->assertEquals('fooBar#?', $generator->parse('fooBar#?'));
    }

    public function testParseReturnsStringWithTokensReplacedByFormatters()
    {
        $generator = new Generator();
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $this->assertEquals('This is foobar a text with foobar', $generator->parse('This is {{fooFormatter}} a text with {{ fooFormatter }}'));
    }

    public function testMagicGetCallsFormat()
    {
        $generator = new Generator;
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $this->assertEquals('foobar', $generator->fooFormatter);
    }

    public function testMagicCallCallsFormat()
    {
        $generator = new Generator;
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $this->assertEquals('foobar', $generator->fooFormatter());
    }

    public function testMagicCallCallsFormatWithArguments()
    {
        $generator = new Generator;
        $provider = new FooProvider();
        $generator->addProvider($provider);
        $this->assertEquals('bazfoo', $generator->fooFormatterWithArguments('foo'));
    }

    public function testSeed()
    {
        $generator = new Generator;

        $generator->seed(0