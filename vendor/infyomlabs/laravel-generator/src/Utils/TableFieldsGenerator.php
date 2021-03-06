<?php
$loader = require_once __DIR__ . '/vendor/autoload.php';

$consoleColor = new JakubOnderka\PhpConsoleColor\ConsoleColor();

echo "Colors are supported: " . ($consoleColor->isSupported() ? 'Yes' : 'No') . "\n";
echo "256 colors are supported: " . ($consoleColor->are256ColorsSupported() ? 'Yes' : 'No') . "\n\n";

if ($consoleColor->isSupported()) {
    foreach ($consoleColor->getPossibleStyles() as $style) {
        echo $consoleColor->apply($style, $style) . "\n";
    }
}

echo "\n";

if ($consoleColor->are256ColorsSupported()) {
    echo "Foreground colors:\n";
    for ($i = 1; $i <= 255; $i++) {
        echo $consoleColor->apply("color_$i", str_pad($i, 6, ' ', STR_PAD_BOTH));

        if ($i % 15 === 0) {
            echo "\n";
        }
    }

    echo "\nBackground colors:\n";

    for ($i = 1; $i <= 255; $i++) {
        echo $consoleColor->apply("bg_color_$i", str_pad($i, 6, ' ', STR_PAD_BOTH));

        if ($i % 15 === 0) {
            echo "\n";
        }
    }

    echo "\n";
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  Copyright (c) 2014-2018, Jakub Onderka
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:

  * Redistributions of source code must retain the above copyright
    notice, this list of conditions and the following disclaimer.

  * Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in
    the documentation and/or other materials provided with the
    distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             INDX( 	 �p             (   0  �        �                  �     h V          �c?�ok� &\X��3���<��c?�ok�                       
 . g i t i g n o r e   �     h X          �(D�ok� &\X�O����<��(D�ok�                     . t r a v i s . y m l �     h T          u�F�ok� &\X������<�u�F�ok�       D              	 b u i l d . x m l     �     p \          ��H�ok� &\X�[���<���H�ok�X      V               c o m p o s e r . j s o n     �     h X          \wR�ok� &\X������<�\wR�ok�       �               e x a m p l e . p h p �     ` P          �T�ok� &\X������<��T�ok�       #               L I C E N S E �     h X          �Y�ok� &\X�����<��Y�ok��      �               p h p u n i t . x m l �     h T          vb^�ok� &\X�&����<�vb^�ok��      �              	 R E A D M E . m d     �     X H          vb^�ok���g�ok���g�ok�vb^�ok�                        s r c �     ` L          CNj�ok��o�ok �o�ok�CNj�ok�                        t e s t s                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php
namespace JakubOnderka\PhpConsoleColor;

class ConsoleColor
{
    const FOREGROUND = 38,
        BACKGROUND = 48;

    const COLOR256_REGEXP = '~^(bg_)?color_([0-9]{1,3})$~';

    const RESET_STYLE = 0;

    /** @var bool */
    private $isSupported;

    /** @var bool */
    private $forceStyle = false;

    /** @var array */
    private $styles = array(
        'none' => null,
        'bold' => '1',
        'dark' => '2',
        'italic' => '3',
        'underline' => '4',
        'blink' => '5',
        'reverse' => '7',
        'concealed' => '8',

        'default' => '39',
        'black' => '30',
        'red' => '31',
        'green' => '32',
        'yellow' => '33',
        'blue' => '34',
        'magenta' => '35',
        'cyan' => '36',
        'light_gray' => '37',

        'dark_gray' => '90',
        'light_red' => '91',
        'light_green' => '92',
        'light_yellow' => '93',
        'light_blue' => '94',
        'light_magenta' => '95',
        'light_cyan' => '96',
        'white' => '97',

        'bg_default' => '49',
        'bg_black' => '40',
        'bg_red' => '41',
        'bg_green' => '42',
        'bg_yellow' => '43',
        'bg_blue' => '44',
        'bg_magenta' => '45',
        'bg_cyan' => '46',
        'bg_light_gray' => '47',

        'bg_dark_gray' => '100',
        'bg_light_red' => '101',
        'bg_light_green' => '102',
        'bg_light_yellow' => '103',
        'bg_light_blue' => '104',
        'bg_light_magenta' => '105',
        'bg_light_cyan' => '106',
        'bg_white' => '107',
    );

    /** @var array */
    private $themes = array();

    public function __construct()
    {
        $this->isSupported = $this->isSupported();
    }

    /**
     * @param string|array $style
     * @param string $text
     * @return string
     * @throws InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function apply($style, $text)
    {
        if (!$this->isStyleForced() && !$this->isSupported()) {
            return $text;
        }

        if (is_string($style)) {
            $style = array($style);
        }
        if (!is_array($style)) {
            throw new \InvalidArgumentException("Style must be string or array.");
        }

        $sequences = array();

        foreach ($style as $s) {
            if (isset($this->themes[$s])) {
                $sequences = array_merge($sequences, $this->themeSequence($s));
            } else if ($this->isValidStyle($s)) {
                $sequences[] = $this->styleSequence($s);
            } else {
                throw new InvalidStyleException($s);
            }
        }

        $sequences = array_filter($sequences, function ($val) {
            return $val !== null;
        });

        if (empty($sequences)) {
            return $text;
        }

        return $this->escSequence(implode(';', $sequences)) . $text . $this->escSequence(self::RESET_STYLE);
    }

    /**
     * @param bool $forceStyle
     */
    public function setForceStyle($forceStyle)
    {
        $this->forceStyle = (bool) $forceStyle;
    }

    /**
     * @return bool
     */
    public function isStyleForced()
    {
        return $this->forceStyle;
    }

    /**
     * @param array $themes
     * @throws InvalidStyleException
     * @throws \InvalidArgumentException
     */
    public function setThemes(array $themes)
    {
        $this->themes = array();
        foreach ($themes as $name => $styles) {
            $this->addTheme($name, $styles);
        }
    }

    /**
     * @param string $name
     * @param array|string $styles
     * @throws \InvalidArgumentException
     * @throws InvalidStyleException
     */
    public function addTheme($name, $styles)
    {
        if (is_string($styles)) {
            $styles = array($styles);
        }
        if (!is_array($styles)) {
            throw new \InvalidArgumentException("Style must be string or array.");
        }

        foreach ($styles as $style) {
            if (!$this->isValidStyle($style)) {
                throw new InvalidStyleException($style);
            }
        }

        $this->themes[$name] = $styles;
    }

    /**
     * @return array
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasTheme($name)
    {
        return isset($this->themes[$name]);
    }

    /**
     * @param string $name
     */
    public function removeTheme($name)
    {
        unset($this->themes[$name]);
    }

    /**
     * @return bool
     */
    public function isSupported()
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            if (function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support(STDOUT)) {
                return true;
            } elseif (getenv('ANSICON') !== false || getenv('ConEmuANSI') === 'ON') {
                return true;
            }
            return false;
        } else {
            return function_exists('posi