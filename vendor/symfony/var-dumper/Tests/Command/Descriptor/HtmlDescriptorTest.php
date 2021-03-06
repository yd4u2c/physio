sEntries(array $entries)
    {
        $vars = [];

        foreach ($entries as $entry) {
            list($name, $value) = Parser::parse($entry);
            $vars[$name] = $this->resolveNestedVariables($value);
            $this->setEnvironmentVariable($name, $vars[$name]);
        }

        return $vars;
    }

    /**
     * Resolve the nested variables.
     *
     * Look for ${varname} patterns in the variable value and replace with an
     * existing environment variable.
     *
     * @param string|null $value
     *
     * @return string|null
     */
    private function resolveNestedVariables($value = null)
    {
        return Option::fromValue($value)
            ->filter(function ($str) {
                return strpos($str, '$') !== false;
            })
            ->flatMap(function ($str) {
                return Regex::replaceCallback(
                    '/\${([a-zA-Z0-9_.]+)}/',
                    function (array $matches) {
                        return Option::fromValue($this->getEnvironmentVariable($matches[1]))
                            ->getOrElse($matches[0]);
                    },
                    $str
                )->success();
            })
            ->getOrElse($value);
    }

    /**
     * Search the different places for environment variables and return first value found.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getEnvironmentVariable($name)
    {
        return $this->envVariables->get($name);
    }

    /**
     * Set an environment variable.
     *
     * @param string      $name
     * @param string|null $value
     *
     * @return void
     */
    public function setEnvironmentVariable($name, $value = null)
    {
        $this->variableNames[] = $name;
        $this->envVariables->set($name, $value);
    }

    /**
     * Clear an environment variable.
     *
     * This method only expects names in normal form.
     *
     * @param string $name
     *
     * @return void
     */
    public function clearEnvironmentVariable($name)
    {
        $this->envVariables->clear($name);
    }

    /**
     * Get the list of environment variables names.
     *
     * @return string[]
     */
    public function getEnvironmentVariableNames()
    {
        return $this->variableNames;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Dotenv;

use Dotenv\Exception\InvalidFileException;

class Parser
{
    const INITIAL_STATE = 0;
    const UNQUOTED_STATE = 1;
    const QUOTED_STATE = 2;
    const ESCAPE_STATE = 3;
    const WHITESPACE_STATE = 4;
    const COMMENT_STATE = 5;

    /**
     * Parse the given environment variable entry into a name and value.
     *
     * @param string $entry
     *
     * @throws \Dotenv\Exception\InvalidFileException
     *
     * @return array
     */
    public static function parse($entry)
    {
        list($name, $value) = self::splitStringIntoParts($entry);

        return [self::parseName($name), self::parseValue($value)];
    }

    /**
     * Split the compound string into parts.
     *
     * @param string $line
     *
     * @throws \Dotenv\Exception\InvalidFileException
     *
     * @return array
     */
    private static function splitStringIntoParts($line)
    {
        $name = $line;
        $value = null;

        if (strpos($line, '=') !== false) {
            list($name, $value) = array_map('trim', explode('=', $line, 2));
        }

        if ($name === '') {
            throw new InvalidFileException(
                self::getErrorMessage('an unexpected equals', $line)
            );
        }

        return [$name, $value];
    }

    /**
     * Strips quotes and the optional leading "export " from the variable name.
     *
     * @param string $name
     *
     * @throws \Dotenv\Exception\InvalidFileException
     *
     * @return string
     */
    private static function parseName($name)
    {
        $name = trim(str_replace(['export ', '\'', '"'], '', $name));

        if (!self::isValidName($name)) {
            throw new InvalidFileException(
                self::getErrorMessage('an invalid name', $name)
            );
        }

        return $name;
    }

    /**
     * Is the given variable name valid?
     *
     * @param string $name
     *
     * @return bool
     */
    private static function isValidName($name)
    {
        return preg_match('~\A[a-zA-Z0-9_.]+\z~', $name) === 1;
    }

    /**
     * Strips quotes and comments from the environment variable value.
     *
     * @param string|null $value
     *
     * @throws \Dotenv\Exception\InvalidFileEx