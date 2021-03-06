ifiers
     *                           - CarbonInterface::DIFF_RELATIVE_TO_NOW   add ago/from now modifier
     *                           - CarbonInterface::DIFF_RELATIVE_TO_OTHER add before/after modifier
     *                           Default value: CarbonInterface::DIFF_ABSOLUTE
     * @param bool      $short   displays short format of time units
     * @param int       $parts   maximum number of parts to display (default value: 1: single part)
     * @param int       $options human diff options
     *
     * @return string
     */
    public function ago($syntax = null, $short = false, $parts = 1, $options = null)
    {
        $other = null;

        if ($syntax instanceof DateTimeInterface) {
            [$other, $syntax, $short, $parts, $options] = array_pad(func_get_args(), 5, null);
        }

        return $this->from($other, $syntax, $short, $parts, $options);
    }

    /**
     * Get the difference in a human readable format in the current locale from current instance to an other
     * instance given (or now if null given).
     *
     * @return string
     */
    public function timespan($other = null, $timezone = null)
    {
        if (!$other instanceof DateTimeInterface) {
            $other = static::parse($other, $timezone);
        }

        return $this->diffForHumans($other, [
            'join' => ', ',
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
            'options' => CarbonInterface::NO_ZERO_DIFF,
            'parts' => -1,
        ]);
    }

    /**
     * Returns either the close date "Friday 15h30", or a calendar date "10/09/2017" is farthest than 7 days from now.
     *
     * @param Carbon|\DateTimeInterface|string|null $referenceTime
     * @param array                                 $formats
     *
     * @return string
     */
    public function calendar($referenceTime = null, array $formats = [])
    {
        /** @var CarbonInterface $current */
        $current = $this->copy()->startOfDay();
        /** @var CarbonInterface $other */
        $other = $this->resolveCarbon($referenceTime)->copy()->setTimezone($this->getTimezone())->startOfDay();
        $diff = $other->diffInDays($current, false);
        $format = $diff < -6 ? 'sameElse' : (
            $diff < -1 ? 'lastWeek' : (
                $diff < 0 ? 'lastDay' : (
                    $diff < 1 ? 'sameDay' : (
                        $diff < 2 ? 'nextDay' : (
                            $diff < 7 ? 'nextWeek' : 'sameElse'
                        )
                    )
                )
            )
        );
        $format = array_merge($this->getCalendarFormats(), $formats)[$format];
        if ($format instanceof Closure) {
            $format = $format($current, $other) ?? '';
        }

        return $this->isoFormat(strval($format));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/**
 * This file is part of the Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Carbon\Traits;

use Carbon\CarbonInterface;
use Carbon\Language;
use Carbon\Translator;
use Closure;
use InvalidArgumentException;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Trait Localization.
 *
 * Embed default and locale translators and translation base methods.
 */
trait Localization
{
    /**
     * Default translator.
     *
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected static $translator;

    /**
     * Specific translator of the current instance.
     *
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $localTranslator;

    /**
     * Options for diffForHumans().
     *
     * @var int
     */
    protected static $humanDiffOptions = CarbonInterface::NO_ZERO_DIFF;

    /**
     * @deprecated To avoid conflict between different third-party libraries, static setters should not be used.
     *             You should rather use the ->settings() method.
     * @see settings
     *
     * @param int $humanDiffOptions
     */
    public static function setHumanDiffOptions($humanDiffOptions)
    {
        static::$humanDiffOptions = $humanDiffOptions;
    }

    /**
     * @deprecated To avoid conflict between different third-party libraries, static setters should not be used.
     *             You should rather use the ->settings() method.
     * @see settings
     *
     * @param int $humanDiffOption
     */
    public static function enableHumanDiffOption($humanDiffOption)
    {
        static::$humanDiffOptions = static::getHumanDiffOptions() | $humanDiffOption;
    }

    /**
     * @deprecated To avoid conflict between different third-party libraries, static setters should not be used.
     *             You should rather use the ->settings() method.
     * @see settings
     *
     * @param int $humanDiffOption
     */
    public static function disableHumanDiffOption($humanDiffOption)
    {
        static::$humanDiffOptions = static::getHumanDiffOptions() & ~$humanDiffOption;
    }

    /**
     * Return default humanDiff() options (merged flags as integer).
     *
     * @return int
     */
    public static function getHumanDiffOptions()
    {
        return static::$humanDiffOptions;
    }

    /**
     * Initialize the default translator instance if necessary.
     *
     * @return \Symfony\Component\Translation\TranslatorInterface
     */
    protected static function translator()
    {
        if (static::$translator === null) {
            static::$translator = Translator::get();
        }

        return static::$translator;
    }

    /**
     * Get the default translator instance in use.
     *
     * @return \Symfony\Component\Translation\TranslatorInterface
     */
    public static function getTranslator()
    {
        return static::translator();
    }

    /**
     * Set the default translator instance to use.
     *
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     *
     * @return void
     */
    public static function setTranslator(TranslatorInterface $translator)
    {
        static::$translator = $translator;
    }

    /**
     * Get the translator of the current instance or the default if none set.
     *
     * @return \Symfony\Component\Translation\TranslatorInterface
     */
    public function getLocalTranslator()
    {
        return $this->localTranslator ?: static::translator();
    }

    /**
     * Set the translator for the current instance.
     *
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     *
     * @return $this
     */
    public function setLocalTranslator(TranslatorInterface $translator)
    {
        $this->localTranslator = $translator;

        return $this;
    }

    /**
     * Returns raw translation message for a given key.
     *
     * @param \Symfony\Component\Translation\TranslatorInterface $translator the translator to use
     * @param string                                             $key        key to find
     * @param string|null                                        $locale     current locale used if null
     * @param string|null                                        $default    default value if translation returns the key
     *
     * @return string
     */
    public static function getTranslationMessageWith($translator, string $key, string $locale = null, string $default = null)
    {
        if (!($translator instanceof TranslatorBagInterface && $translator instanceof TranslatorInterface)) {
            throw new InvalidArgumentException(
                'Translator does not implement '.TranslatorInterface::class.' and '.TranslatorBagInterface::class.'.'
            );
        }

        $result = $translator->getCatalogue($locale ?? $translator->getLocale())->get($key);

        return $result === $key ? $default : $result;
    }

    /**
     * Returns raw translation message for a given key.
     *
     * @param string                                             $key        key to find
     * @param string|null                                        $locale     current locale used if null
     * @param string|null                                        $default    default value if translation returns the key
     * @param \Symfony\Component\Translation\TranslatorInterface $translator an optional translator to use
     *
     * @return string
     */
    public function getTranslationMessage(string $key, string $locale = null, string $default = null, $translator = null)
    {
        return static::getTranslationMessageWith($translator ?: $this->getLocalTranslator(), $key, $locale, $default);
    }

    /**
     * Translate using translation string or callback available.
     *
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     * @param string                                             $key
     * @param array                                              $parameters
     * @param null                                               $number
     *
     * @return string
     */
    public static function translateWith(TranslatorInterface $translator, string $key, array $parameters = [], $number = null): string
    {
        $message = static::getTranslationMessageWith($translator, $key, null, $key);
        if ($message instanceof Closure) {
            return $message(...array_values($parameters));
        }

        if ($number !== null) {
            $parameters['%count%'] = $number;
        }
        if (isset($parameters['%count%'])) {
            $parameters[':count'] = $parameters['%count%'];
        }

        return $translator->transChoice($key, $number, $parameters);
    }

    /**
     * Translate using translation string or callback available.
     *
     * @param string                                             $key
     * @param array                                              $parameters
     * @param null                                               $number
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     *
     * @return string
     */
    public function translate(string $key, array $parameters = [], $number = null, TranslatorInterface $translator = null): string
    {
        return static::translateWith($translator ?: $this->getLocalTranslator(), $key, $parameters, $number);
   