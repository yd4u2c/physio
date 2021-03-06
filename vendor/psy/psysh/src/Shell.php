n a list of variables currently in scope.

If a target object is provided, list properties, constants and methods of that
target. If a class, interface or trait name is passed instead, list constants
and methods on that class.

e.g.
<return>>>> ls</return>
<return>>>> ls $foo</return>
<return>>>> ls -k --grep mongo -i</return>
<return>>>> ls -al ReflectionClass</return>
<return>>>> ls --constants --category date</return>
<return>>>> ls -l --functions --grep /^array_.*/</return>
<return>>>> ls -l --properties new DateTime()</return>
HELP
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->validateInput($input);
        $this->initEnumerators();

        $method = $input->getOption('long') ? 'writeLong' : 'write';

        if ($target = $input->getArgument('target')) {
            list($target, $reflector) = $this->getTargetAndReflector($target);
        } else {
            $reflector = null;
        }

        // @todo something cleaner than this :-/
        if ($input->getOption('long')) {
            $output->startPaging();
        }

        foreach ($this->enumerators as $enumerator) {
            $this->$method($output, $enumerator->enumerate($input, $reflector, $target));
        }

        if ($input->getOption('long')) {
            $output->stopPaging();
        }

        // Set some magic local variables
        if ($reflector !== null) {
            $this->setCommandScopeVariables($reflector);
        }
    }

    /**
     * Initialize Enumerators.
     */
    protected function initEnumerators()
    {
        if (!isset($this->enumerators)) {
            $mgr = $this->presenter;

            $this->enumerators = [
                new ClassConstantEnumerator($mgr),
                new ClassEnumerator($mgr),
                new ConstantEnumerator($mgr),
                new FunctionEnumerator($mgr),
                new GlobalVariableEnumerator($mgr),
                new PropertyEnumerator($mgr),
                new MethodEnumerator($mgr),
                new VariableEnumerator($mgr, $this->context),
            ];
        }
    }

    /**
     * Write the list items to $output.
     *
     * @param OutputInterface $output
     * @param null|array      $result List of enumerated items
     */
    protected function write(OutputInterface $output, array $result = null)
    {
        if ($result === null) {
            return;
        }

        foreach ($result as $label => $items) {
            $names = \array_map([$this, 'formatItemName'], $items);
            $output->writeln(\sprintf('<strong>%s</strong>: %s', $label, \implode(', ', $names)));
        }
    }

    /**
     * Write the list items to $output.
     *
     * Items are listed one per line, and include the item signature.
     *
     * @param OutputInterface $output
     * @param null|array      $result List of enumerated items
     */
    protected function writeLong(OutputInterface $output, array $result = null)
    {
        if ($result === null) {
            return;
        }

        $table = $this->getTable($output);

        foreach ($result as $label => $items) {
            $output->writeln('');
            $output->writeln(\sprintf('<strong>%s:</strong>', $label));

            $table->setRows([]);
            foreach ($items as $item) {
                $table->addRow([$this->formatItemName($item), $item['value']]);
            }

            if ($table instanceof TableHelper) {
                $table->render($output);
            } else {
                $table->render();
            }
        }
    }

    /**
     * Format an item name given its visibility.
     *
     * @param array $item
     *
     * @return string
     */
    private function formatItemName($item)
    {
        return \sprintf('<%s>%s</%s>', $item['style'], OutputFormatter::escape($item['name']), $item['style']);
    }

    /**
     * Validate that input options make sense, provide defaults when called without options.
     *
     * @throws RuntimeException if options are inconsistent
     *
     * @param InputInterface $input
     */
    private function validateInput(InputInterface $input)
    {
        if (!$input->getArgument('target')) {
            // if no target is passed, there can be no properties or methods
            foreach (['properties', 'methods', 'no-inherit'] as $option) {
                if ($input->getOption($option)) {
                    throw new RuntimeException('--' . $option . ' does not make sense without a specified target');
                }
            }

            foreach (['globals', 'vars', 'constants', 'functions', 'classes', 'interfaces', 'traits'] as $option) {
                if ($input->getOption($option)) {
                    return;
                }
            }

            // default to --vars if no other options are passed
            $input->setOption('vars', true);
        } else {
            // if a target is passed, classes, functions, etc don't make sense
            foreach (['vars', 'globals', 'functions', 'classes', 'interfaces', 'traits'] as $option) {
                if ($input->getOption($option)) {
                    throw new RuntimeException('--' . $option . ' does not make sense with a specified target');
                }
            }

            foreach (['constants', 'properties', 'methods'] as $option) {
                if ($input->getOption($option)) {
                    return;
                }
            }

            // default to --constants --properties --methods if no other options are passed
            $input->setOption('constants',  true);
            $input->setOption('properties', true);
            $input->setOption('methods',    true);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command;

use PhpParser\Node;
use PhpParser\Parser;
use Psy\Context;
use Psy\ContextAware;
use Psy\Input\CodeArgument;
use Psy\ParserFactory;
use Psy\VarDumper\Presenter;
use Psy\VarDumper\PresenterAware;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\VarDumper\Caster\Caster;

/**
 * Parse PHP code and show the abstract syntax tree.
 */
class ParseCommand extends Command implements ContextAware, PresenterAware
{
    /**
     * Context instance (for ContextAware interface).
     *
     * @var Context
     */
    protected $context;

    private $presenter;
    private $parserFactory;
    private $parsers;

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        $this->parserFactory = new ParserFactory();
        $this->parsers       = [];

        parent::__construct($name);
    }

    /**
     * ContextAware interface.
     *
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    /**
     * PresenterAware interface.
     *
     * @param Presenter $presenter
     */
    public function setPresenter(Presenter $presenter)
    {
        $this->presenter = clone $presenter;
        $this->presenter->addCasters([
            'PhpParser\Node' => function (Node $node, array $a) {
                $a = [
                    Caster::PREFIX_VIRTUAL . 'type'       => $node->getType(),
                    Caster::PREFIX_VIRTUAL . 'attributes' => $node->getAttributes(),
                ];

                foreach ($node->getSubNodeNames() as $name) {
                    $a[Caster::PREFIX_VIRTUAL . $name] = $node->$name;
                }

                return $a;
            },
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $definition = [
            new CodeArgument('code', CodeArgument::REQUIRED, 'PHP code to parse.'),
            new InputOption('depth', '', InputOption::VALUE_REQUIRED, 'Depth to parse.', 10),
        ];

        if ($this->parserFactory->hasKindsSupport()) {
            $msg = 'One of PhpParser\\ParserFactory constants: '
                . \implode(', ', ParserFactory::getPossibleKinds())
                . " (default is based on current interpreter's version).";
            $defaultKind = $this->parserFactory->getDefaultKind();

            $definition[] = new InputOption('kind', '', InputOption::VALUE_REQUIRED, $msg, $defaultKind);
        }

        $this
            ->setName('parse')
            ->setDefinition($definition)
            ->setDescription('Parse PHP code and show the abstract syntax tree.')
            ->setHelp(
                <<<'HELP'
Parse PHP code and show the abstract syntax tree.

This command is used in the development of PsySH. Given a string of PHP code,
it pretty-prints the PHP Parser parse tree.

See https://github.com/nikic/PHP-Parser

It prolly won't be super useful for most of you, but it's here if you want to play.
HELP
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $code = $input->getArgument('code');
        if (\strpos('<?', $code) === false) {
            $code = '<?php ' . $code;
        }

        $parserKind = $this->parserFactory->hasKindsSupport() ? $input->getOption('kind') : null;
        $depth      = $input->getOption('depth');
        $nodes      = $this->parse($this->getParser($parserKind), $code);
        $output->page($this->presenter->present($nodes, $depth));

        $this->context->setReturnValue($nodes);
    }

    /**
     * Lex and parse a string of code into statements.
     *
     * @param Parser $parser
     * @param string $code
     *
     * @return array Statements
     */
    private function parse(Parser $parser, $code)
    {
        try {
            return $parser->parse($code);
        } catch (\PhpParser\Error $e) {
            if (\strpos($e->getMessage(), 'unexpected EOF') === false) {
                throw $e;
            }

            // If we got an unexpected EOF, let's try it again with a semicolon.
            return $parser->parse($code . ';');
        }
    }

    /**
     * Get (or create) the Parser instance.
     *
     * @param string|null $kind One of Psy\ParserFactory constants (only for PHP parser 2.0 and above)
     *
     * @return Parser
     */
    private function getParser($kind = null)
    {
        if (!\array_key_exists($kind, $this->parsers)) {
            $this->parsers[$kind] = $this->parserFactory->createParser($kind);
        }

        return $this->parsers[$kind];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A dumb little command for printing out the current Psy Shell version.
 */
class PsyVersionCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('version')
            ->setDefinition([])
            ->setDescription('Show Psy Shell version.')
            ->setHelp('Show Psy Shell version.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getVersion());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command;

use Psy\CodeCleaner\NoReturnValue;
use Psy\Context;
use Psy\ContextAware;
use Psy\Exception\ErrorException;
use Psy\Exception\RuntimeException;
use Psy\Util\Mirror;

/**
 * An abstract command with helpers for inspecting the current context.
 */
abstract class ReflectingCommand extends Command implements ContextAware
{
    const CLASS_OR_FUNC   = '/^[\\\\\w]+$/';
    const CLASS_MEMBER    = '/^([\\\\\w]+)::(\w+)$/';
    const CLASS_STATIC    = '/^([\\\\\w]+)::\$(\w+)$/';
    const INSTANCE_MEMBER = '/^(\$\w+)(::|->)(\w+)$/';

    /**
     * Context instance (for ContextAware interface).
     *
     * @var Context
     */
    protected $context;

    /**
     * ContextAware interface.
     *
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    /**
     * Get the target for a value.
     *
     * @throws \InvalidArgumentException when the value specified can't be resolved
     *
     * @param string $valueName Function, class, variable, constant, method or property name
     *
     * @return array (class or instance name, member name, kind)
     */
    protected function getTarget($valueName)
    {
        $valueName = \trim($valueName);
        $matches   = [];
        switch (true) {
            case \preg_match(self::CLASS_OR_FUNC, $valueName, $matches):
                return [$this->resolveName($matches[0], true), null, 0];

            case \preg_match(self::CLASS_MEMBER, $valueName, $matches):
                return [$this->resolveName($matches[1]), $matches[2], Mirror::CONSTANT | Mirror::METHOD];

            case \preg_match(self::CLASS_STATIC, $valueName, $matches):
                return [$this->resolveName($matches[1]), $matches[2], Mirror::STATIC_PROPERTY | Mirror::PROPERTY];

            case \preg_match(self::INSTANCE_MEMBER, $valueName, $matches):
                if ($matches[2] === '->') {
                    $kind = Mirror::METHOD | Mirror::PROPERTY;
                } else {
                    $kind = Mirror::CONSTANT | Mirror::METHOD;
                }

                return [$this->resolveObject($matches[1]), $matches[3], $kind];

            default:
                return [$this->resolveObject($valueName), null, 0];
        }
    }

    /**
     * Resolve a class or function name (with the current shell namespace).
     *
     * @throws ErrorException when `self` or `static` is used in a non-class scope
     *
     * @param string $name
     * @param bool   $includeFunctions (default: false)
     *
     * @return string
     */
    protected function resolveName($name, $includeFunctions = false)
    {
        $shell = $this->getApplication();

        // While not *technically* 100% accurate, let's treat `self` and `static` as equivalent.
        if (\in_array(\strtolower($name), ['self', 'static'])) {
            if ($boundClass = $shell->getBoundClass()) {
                return $boundClass;
            }

            if ($boundObject = $shell->getBoundObject()) {
                return \get_class($boundObject);
            }

            $msg = \sprintf('Cannot use "%s" when no class scope is active', \strtolower($name));
            throw new ErrorException($msg, 0, E_USER_ERROR, "eval()'d code", 1);
        }

        if (\substr($name, 0, 1) === '\\') {
            return $name;
        }

        if ($namespace = $shell->getNamespace()) {
            $fullName = $namespace . '\\' . $name;

            if (\class_exists($fullName) || \interface_exists($fullName) || ($includeFunctions && \function_exists($fullName))) {
                return $fullName;
            }
        }

        return $name;
    }

    /**
     * Get a Reflector and documentation for a function, class or instance, constant, method or property.
     *
     * @param string $valueName Function, class, variable, constant, method or property name
     *
     * @return array (value, Reflector)
     */
    protected function getTargetAndReflector($valueName)
    {
        list($value, $member, $kind) = $this->getTarget($valueName);

        return [$value, Mirror::get($value, $member, $kind)];
    }

    /**
     * Resolve code to a value in the current scope.
     *
     * @throws RuntimeException when the code does not return a value in the current scope
     *
     * @param string $code
     *
     * @return mixed Variable value
     */
    protected function resolveCode($code)
    {
        try {
            $value = $this->getApplication()->execute($code, true);
        } catch (\Exception $e) {
            // Swallow all exceptions?
        }

        if (!isset($value) || $value instanceof NoReturnValue) {
            throw new RuntimeException('Unknown target: ' . $code);
        }

        return $value;
    }

    /**
     * Resolve code to an object in the current scope.
     *
     * @throws RuntimeException when the code resolves to a non-object value
     *
     * @param string $code
     *
     * @return object Variable instance
     */
    private function resolveObject($code)
    {
        $value = $this->resolveCode($code);

        if (!\is_object($value)) {
            throw new RuntimeException('Unable to inspect a non-object');
        }

        return $value;
    }

    /**
     * @deprecated Use `resolveCode` instead
     *
     * @param string $name
     *
     * @return mixed Variable instance
     */
    protected function resolveInstance($name)
    {
        @\trigger_error('`resolveInstance` is deprecated; use `resolveCode` instead.', E_USER_DEPRECATED);

        return $this->resolveCode($name);
    }

    /**
     * Get a variable from the current shell scope.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function getScopeVariable($name)
    {
        return $this->context->get($name);
    }

    /**
     * Get all scope variables from the current shell scope.
     *
     * @return array
     */
    protected function getScopeVariables()
    {
        return $this->context->getAll();
    }

    /**
     * Given a Reflector instance, set command-scope variables in the shell
     * execution context. This is used to inject magic $__class, $__method and
     * $__file variables (as well as a handful of others).
     *
     * @param \Reflector $reflector
     */
    protected function setCommandScopeVariables(\Reflector $reflector)
    {
        $vars = [];

        switch (\get_class($reflector)) {
            case 'ReflectionClass':
            case 'ReflectionObject':
                $vars['__class'] = $reflector->name;
                if ($reflector->inNamespace()) {
                    $vars['__namespace'] = $reflector->getNamespaceName();
                }
                break;

            case 'ReflectionMethod':
                $vars['__method'] = \sprintf('%s::%s', $reflector->class, $reflector->name);
                $vars['__class'] = $reflector->class;
                $classReflector = $reflector->getDeclaringClass();
                if ($classReflector->inNamespace()) {
                    $vars['__namespace'] = $classReflector->getNamespaceName();
                }
                break;

            case 'ReflectionFunction':
                $vars['__function'] = $reflector->name;
                if ($reflector->inNamespace()) {
                    $vars['__namespace'] = $reflector->getNamespaceName();
                }
                break;

            case 'ReflectionGenerator':
                $funcReflector = $reflector->getFunction();
                $vars['__function'] = $funcReflector->name;
                if ($funcReflector->inNamespace()) {
                    $vars['__namespace'] = $funcReflector->getNamespaceName();
                }
                if ($fileName = $reflector->getExecutingFile()) {
                    $vars['__file'] = $fileName;
                    $vars['__line'] = $reflector->getExecutingLine();
                    $vars['__dir']  = \dirname($fileName);
                }
                break;

            case 'ReflectionProperty':
            case 'ReflectionClassConstant':
            case 'Psy\Reflection\ReflectionClassConstant':
                $classReflector = $reflector->getDeclaringClass();
                $vars['__class'] = $classReflector->name;
                if ($classReflector->inNamespace()) {
                    $vars['__namespace'] = $classReflector->getNamespaceName();
                }
                // no line for these, but this'll do
                if ($fileName = $reflector->getDeclaringClass()->getFileName()) {
                    $vars['__file'] = $fileName;
                    $vars['__dir']  = \dirname($fileName);
                }
                break;

            case 'Psy\Reflection\ReflectionConstant_':
                if ($reflector->inNamespace()) {
                    $vars['__namespace'] = $reflector->getNamespaceName();
                }
                break;
        }

        if ($reflector instanceof \ReflectionClass || $reflector instanceof \ReflectionFunctionAbstract) {
            if ($fileName = $reflector->getFileName()) {
                $vars['__file'] = $fileName;
                $vars['__line'] = $reflector->getStartLine();
                $vars['__dir']  = \dirname($fileName);
            }
        }

        $this->context->setCommandScopeVariables($vars);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command;

use JakubOnderka\PhpConsoleHighlighter\Highlighter;
use Psy\Configuration;
use Psy\ConsoleColorFactory;
use Psy\Exception\RuntimeException;
use Psy\Formatter\CodeFormatter;
use Psy\Formatter\SignatureFormatter;
use Psy\Input\CodeArgument;
use Psy\Output\ShellOutput;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Show the code for an object, class, constant, method or property.
 */
class ShowCommand extends ReflectingCommand
{
    private $colorMode;
    private $highlighter;
    private $lastException;
    private $lastExceptionIndex;

    /**
     * @param null|string $colorMode (default: null)
     */
    public function __construct($colorMode = null)
    {
        $this->colorMode = $colorMode ?: Configuration::COLOR_MODE_AUTO;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('show')
            ->setDefinition([
                new CodeArgument('target', CodeArgument::OPTIONAL, 'Function, class, instance, constant, method or property to show.'),
                new InputOption('ex', null,  InputOption::VALUE_OPTIONAL, 'Show last exception context. Optionally specify a stack index.', 1),
            ])
            ->setDescription('Show the code for an object, class, constant, method or property.')
            ->setHelp(
                <<<HELP
Show the code for an object, class, constant, method or property, or the context
of the last exception.

<return>cat --ex</return> defaults to showing the lines surrounding the location of the last
exception. Invoking it more than once travels up the exception's stack trace,
and providing a number shows the context of the given index of the trace.

e.g.
<return>>>> show \$myObject</return>
<return>>>> show Psy\Shell::debug</return>
<return>>>> show --ex</return>
<return>>>> show --ex 3</return>
HELP
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // n.b. As far as I can tell, InputInterface doesn't want to tell me
        // whether an option with an optional value was actually passed. If you
        // call `$input->getOption('ex')`, it will return the default, both when
        // `--ex` is specified with no value, and when `--ex` isn't specified at
        // all.
        //
        // So we're doing something sneaky here. If we call `getOptions`, it'll
        // return the default value when `--ex` is not present, and `null` if
        // `--ex` is passed with no value. /shrug
        $opts = $input->getOptions();

        // Strict comparison to `1` (the default value) here, because `--ex 1`
        // will come in as `"1"`. Now we can tell the difference between
        // "no --ex present", because it's the integer 1, "--ex with no value",
        // because it's `null`, and "--ex 1", because it's the string "1".
        if ($opts['ex'] !== 1) {
            if ($input->getArgument('target')) {
                throw new \InvalidArgumentException('Too many arguments (supply either "target" or "--ex")');
            }

            return $this->writeExceptionContext($input, $output);
        }

        if ($input->getArgument('target')) {
            return $this->writeCodeContext($input, $output);
        }

        throw new RuntimeException('Not enough arguments (missing: "target")');
    }

    private function writeCodeContext(InputInterface $input, OutputInterface $output)
    {
        list($target, $reflector) = $this->getTargetAndReflector($input->getArgument('target'));

        // Set some magic local variables
        $this->setCommandScopeVariables($reflector);

        try {
            $output->page(CodeFormatter::format($reflector, $this->colorMode), ShellOutput::OUTPUT_RAW);
        } catch (RuntimeException $e) {
            $output->writeln(SignatureFormatter::format($reflector));
            throw $e;
        }
    }

    private function writeExceptionContext(InputInterface $input, OutputInterface $output)
    {
        $exception = $this->context->getLastException();
        if ($exception !== $this->lastException) {
            $this->lastException = null;
            $this->lastExceptionIndex = null;
        }

        $opts = $input->getOptions();
        if ($opts['ex'] === null) {
            if ($this->lastException && $this->lastExceptionIndex !== null) {
                $index = $this->lastExceptionIndex + 1;
            } else {
                $index = 0;
            }
        } els