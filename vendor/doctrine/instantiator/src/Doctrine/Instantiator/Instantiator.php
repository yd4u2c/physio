# EmailValidator
[![Build Status](https://travis-ci.org/egulias/EmailValidator.png?branch=master)](https://travis-ci.org/egulias/EmailValidator) [![Coverage Status](https://coveralls.io/repos/egulias/EmailValidator/badge.png?branch=master)](https://coveralls.io/r/egulias/EmailValidator?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/egulias/EmailValidator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/egulias/EmailValidator/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/22ba6692-9c02-42e5-a65d-1c5696bfffc6/small.png)](https://insight.sensiolabs.com/projects/22ba6692-9c02-42e5-a65d-1c5696bfffc6)
=============================
## Suported RFCs ##
This library aims to support:

RFC 5321, 5322, 6530, 6531, 6532.

## Requirements ##

 * [Composer](https://getcomposer.org) is required for installation
 * [Spoofchecking](https://github.com/egulias/EmailValidator/blob/master/EmailValidator/Validation/SpoofCheckValidation.php) and [DNSCheckValidation](https://github.com/egulias/EmailValidator/blob/master/EmailValidator/Validation/DNSCheckValidation.php) validation requires that your PHP system has the [PHP Internationalization Libraries](https://php.net/manual/en/book.intl.php) (also known as PHP Intl)

## Installation ##

Run the command below to install via Composer

```shell
composer require egulias/email-validator "~2.1"
```

## Getting Started ##
`EmailValidator`requires you to decide which (or combination of them) validation/s strategy/ies you'd like to follow for each [validation](#available-validations).

A basic example with the RFC validation
```php
<?php

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

$validator = new EmailValidator();
$validator->isValid("example@example.com", new RFCValidation()); //true
```


### Available validations ###

1. [RFCValidation](https://github.com/egulias/EmailValidator/blob/master/EmailValidator/Validation/RFCValidation.php)
2. [NoRFCWarningsValidation](https://github.com/egulias/EmailValidator/blob/master/EmailValidator/Validation/NoRFCWarningsValidation.php)
3. [DNSCheckValidation](https://github.com/egulias/EmailValidator/blob/master/EmailValidator/Validation/DNSCheckValidation.php)
4. [SpoofCheckValidation](https://github.com/egulias/EmailValidator/blob/master/EmailValidator/Validation/SpoofCheckValidation.php)
5. [MultipleValidationWithAnd](https://github.com/egulias/EmailValidator/blob/master/EmailValidator/Validation/MultipleValidationWithAnd.php)
6. [Your own validation](#how-to-extend)

`MultipleValidationWithAnd`

It is a validation that operates over other validations performing a logical and (&&) over the result of each validation.

```php
<?php

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

$validator = new EmailValidator();
$multipleValidations = new MultipleValidationWithAnd([
    new RFCValidation(),
    new DNSCheckValidation()
]);
$validator->isValid("example@example.com", $multipleValidations); //true
```

### How to extend ###

It's easy! You just need to implement [EmailValidation](https://github.com/egulias/EmailValidator/blob/master/EmailValidator/Validation/EmailValidation.php) and you can use your own validation.


## Other Contributors ##
(You can find current contributors [here](https://github.com/egulias/EmailValidator/graphs/contributors))

As this is a port from another library and work, here are other people related to the previous one:

* Ricard Clau [@ricardclau](https://github.com/ricardclau):      	Performance against PHP built-in filter_var
* Josepf Bielawski [@stloyd](https://github.com/stloyd):      		For its first re-work of Dominic's lib
* Dominic Sayers [@dominicsayers](https://github.com/dominicsayers):  	The original isemail function

## License ##
Released under the MIT License attached with this code.

                                                <?php

namespace Egulias\EmailValidator;

use Doctrine\Common\Lexer\AbstractLexer;

class EmailLexer extends AbstractLexer
{
    //ASCII values
    const C_DEL              = 127;
    const C_NUL              = 0;
    const S_AT               = 64;
    const S_BACKSLASH        = 92;
    const S_DOT              = 46;
    const S_DQUOTE           = 34;
    const S_OPENPARENTHESIS  = 49;
    const S_CLOSEPARENTHESIS = 261;
    const S_OPENBRACKET      = 262;
    const S_CLOSEBRACKET     = 263;
    const S_HYPHEN           = 264;
    const S_COLON            = 265;
    const S_DOUBLECOLON      = 266;
    const S_SP               = 267;
    const S_HTAB             = 268;
    const S_CR               = 269;
    const S_LF               = 270;
    const S_IPV6TAG          = 271;
    const S_LOWERTHAN        = 272;
    const S_GREATERTHAN      = 273;
    const S_COMMA            = 274;
    const S_SEMICOLON        = 275;
    const S_OPENQBRACKET     = 276;
    const S_CLOSEQBRACKET    = 277;
    const S_SLASH            = 278;
    const S_EMPTY            = null;
    const GENERIC            = 300;
    const CRLF               = 301;
    const INVALID            = 302;
    const ASCII_INVALID_FROM = 127;
    const ASCII_INVALID_TO   = 199;

    /**
     * US-ASCII visible characters not valid for atext (@link http://tools.ietf.org/html/rfc5322#section-3.2.3)
     *
     * @var array
     */
    protected $charValue = array(
        '('    => self::S_OPENPARENTHESIS,
        ')'    => self::S_CLOSEPARENTHESIS,
        '<'    => self::S_LOWERTHAN,
        '>'    => self::S_GREATERTHAN,
        '['    => self::S_OPENBRACKET,
        ']'    => self::