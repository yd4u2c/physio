te, $rule, $parameters);
    }

    /**
     * Replace all place-holders for the after_or_equal rule.
     *
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceAfterOrEqual($message, $attribute, $rule, $parameters)
    {
        return $this->replaceBefore($message, $attribute, $rule, $parameters);
    }

    /**
     * Replace all place-holders for the date_equals rule.
     *
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceDateEquals($message, $attribute, $rule, $parameters)
    {
        return $this->replaceBefore($message, $attribute, $rule, $parameters);
    }

    /**
     * Replace all place-holders for the dimensions rule.
     *
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceDimensions($message, $attribute, $rule, $parameters)
    {
        $parameters = $this->parseNamedParameters($parameters);

        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $message = str_replace(':'.$key, $value, $message);
            }
        }

        return $message;
    }

    /**
     * Replace all place-holders for the starts_with rule.
     *
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceStartsWith($message, $attribute, $rule, $parameters)
    {
        foreach ($parameters as &$parameter) {
            $parameter = $this->getDisplayableValue($attribute, $parameter);
        }

        return str_replace(':values', implode(', ', $parameters), $message);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Illuminate\Validation\Concerns;

use DateTime;
use Countable;
use Exception;
use Throwable;
use DateTimeZone;
use DateTimeInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationData;
use Egulias\EmailValidator\EmailValidator;
use Symfony\Component\HttpFoundation\File\File;
use Egulias\EmailValidator\Validation\RFCValidation;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait ValidatesAttributes
{
    /**
     * Validate that an attribute was "accepted".
     *
     * This validation rule implies the attribute is "required".
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function validateAccepted($attribute, $value)
    {
        $acceptable = ['yes', 'on', '1', 1, true, 'true'];

        return $this->validateRequired($attribute, $value) && in_array($value, $acceptable, true);
    }

    /**
     * Validate that an attribute is an active URL.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function validateActiveUrl($attribute, $value)
    {
        if (! is_string($value)) {
            return false;
        }

        if ($url = parse_url($value, PHP_URL_HOST)) {
            try {
                return count(dns_get_record($url, DNS_A | DNS_AAAA)) > 0;
            } catch (Exception $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * "Break" on first validation fail.
     *
     * Always returns true, just lets us put "bail" in rules.
     *
     * @return bool
     */
    public function validateBail()
    {
        return true;
    }

    /**
     * Validate the date is before a given date.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array   $parameters
     * @return bool
     */
    public function validateBefore($attribute, $value, $parameters)
    {
        $this->requireParameter