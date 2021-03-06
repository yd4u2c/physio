g) {
                    throw $e;
                }
            }
        }

        if (!is_null($this->_mockery_partial) && method_exists($this->_mockery_partial, $method)) {
            return call_user_func_array(array($this->_mockery_partial, $method), $args);
        } elseif ($this->_mockery_deferMissing && is_callable("parent::$method")
            && (!$this->hasMethodOverloadingInParentClass() || method_exists(get_parent_class($this), $method))) {
            return call_user_func_array("parent::$method", $args);
        } elseif ($method == '__toString') {
            // __toString is special because we force its addition to the class API regardless of the
            // original implementation.  Thus, we should always return a string rather than honor
            // _mockery_ignoreMissing and break the API with an error.
            return sprintf("%s#%s", __CLASS__, spl_object_hash($this));
        } elseif ($this->_mockery_ignoreMissing) {
            if (\Mockery::getConfiguration()->mockingNonExistentMethodsAllowed() || (method_exists($this->_mockery_partial, $method) || is_callable("parent::$method"))) {
                if ($this->_mockery_defaultReturnValue instanceof \Mockery\Undefined) {
                    return call_user_func_array(array($this->_mockery_defaultReturnValue, $method), $args);
                } elseif (null === $this->_mockery_defaultReturnValue) {
                    return $this->mockery_returnValueForMethod($method);
                }

                return $this->_mockery_defaultReturnValue;
            }
        }

        $message = 'Method ' . __CLASS__ . '::' . $method .
            '() does not exist on this mock object';

        if (!is_null($rm)) {
            $message = 'Received ' . __CLASS__ .
                '::' . $method . '(), but no expectations were specified';
        }

        $bmce = new BadMethodCallException($message);
        $this->_mockery_thrownExceptions[] = $bmce;
        throw $bmce;
    }

    /**
     * Uses reflection to get the list of all
     * methods within the current mock object
     *
     * @return array
     */
    protected function mockery_getMethods()
    {
        if (static::$_mockery_methods && \Mockery::getConfiguration()->reflectionCacheEnabled()) {
            return static::$_mockery_methods;
        }

        if (isset($this->_mockery_partial)) {
            $reflected = new \ReflectionObject($this->_mockery_partial);
        } else {
            $reflected = new \ReflectionClass($this);
        }

        return static::$_mockery_methods = $reflected->getMethods();
    }

    private function hasMethodOverloadingInParentClass()
    {
        // if there's __call any name would be callable
        return is_callable('parent::aFunctionNameThatNoOneWouldEverUseInRealLife12345');
    }

    /**
     * @return array
     */
    private function getNonPublicMethods()
    {
        return array_map(
            function ($method) {
                return $method->getName();
            },
            array_filter($this->mockery_getMethods(), function ($method) {
                return !$method->isPublic();
            })
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery;

interface MockInterface
{
    /**
     * @param mixed $something  String method name or map of method => return
     * @return self|\Mockery\ExpectationInterface|\Mockery\Expectation|\Mockery\HigherOrderMessage
     */
    public function allows($something = []);

    /**
     * @param mixed $something  String method name (optional)
     * @return \Mockery\ExpectationInterface|\Mockery\Expectation|\Mockery\ExpectsHigherOrderMessage
     */
    public function expects($something = null);

    /**
     * Alternative setup method to constructor
     *
     * @param \Mockery\Container $container
     * @param object $partialObject
     * @return void
     */
    public function mockery_init(\Mockery\Container $container = null, $partialObject = null);

    /**
     * Set expected method calls
     *
     * @param mixed ...$methodNames one or many methods that are expected to be called in this mock
     *
     * @return \Mockery\ExpectationInterface|\Mockery\Expectation|\Mockery\HigherOrderMessage
     */
    public function shouldReceive(...$methodNames);

    /**
     * Shortcut method for setting an expectation that a method should not be called.
     *
     * @param mixed ...$methodNames one or many methods that are expected not to be called in this mock
     * @return \Mockery\ExpectationInterface|\Mockery\Expectation|\Mockery\HigherOrderMessage
     */
    public function shouldNotReceive(...$methodNames);

    /**
     * Allows additional methods to be mocked that do not explicitly exist on mocked class
     * @param String $method name of the method to be mocked
     */
    public function shouldAllowMockingMethod($method);

    /**
     * Set mock to ignore unexpected methods and return Undefined class
     * @param mixed $returnValue the default return value for calls to missing functions on this mock
     * @return Mock
     */
    public function shouldIgnoreMissing($returnValue = null);

    /**
     * @return Mock
     */
    public function shouldAllowMockingProtectedMethods();

    /**
     * Set mock to defer unexpected methods to its parent if possible
     *
     * @deprecated 2.0.0 Please use makePartial() instead
     *
     * @return Mock
     */
    public function shouldDeferMissing();

    /**
     * Set mock to defer unexpected methods to its parent if possible
     *
     * @return Mock
     */
    public function makePartial();

    /**
     * @param null|string $method
     * @param null $args
     * @return mixed
     */
    public function shouldHaveReceived($method = null, $args = null);

    /**
     * @return mixed
     */
    public function shouldHaveBeenCalled();

    /**
     * @param null|string $method
     * @param null $args
     * @return mixed
     */
    public function shouldNotHaveReceived($method, $args = null);

    /**
     * @param array $args (optional)
     * @return mixed
     */
    public function shouldNotHaveBeenCalled(array $args = null);

    /**
     * In the event shouldReceive() accepting an array of methods/returns
     * this method will switch them from normal expectations to default
     * expectations
     *
     * @return self
     */
    public function byDefault();

    /**
     * Iterate across all expectation directors and validate each
     *
     * @throws \Mockery\CountValidator\Exception
     * @return void
     */
    public function mockery_verify();

    /**
     * Tear down tasks for this mock
     *
     * @return void
     */
    public function mockery_teardown();

    /**
     * Fetch the next available allocation order number
     *
     * @return int
     */
    public function mockery_allocateOrder();

    /**
     * Set ordering for a group
     *
     * @param mixed $group
     * @param int $order
     */
    public function mockery_setGroup($group, $order);

    /**
     * Fetch array of ordered groups
     *
     * @return array
     */
    public function mockery_getGroups();

    /**
     * Set current ordered number
     *
     * @param int $order
     */
    public function mockery_setCurrentOrder($order);

    /**
     * Get current ordered number
     *
     * @return int
     */
    public function mockery_getCurrentOrder();

    /**
     * Validate the current mock's ordering
     *
     * @param string $method
     * @param int $order
     * @throws \Mockery\Exception
     * @return void
     */
    public function mockery_validateOrder($method, $order);

    /**
     * Gets the count of expectations for this mock
     *
     * @return int
     */
    public function mockery_getExpectationCount();

    /**
     * Return the expectations director for the given method
     *
     * @var string $method
     * @return \Mockery\ExpectationDirector|null
     */
    public function mockery_setExpectationsFor($method, \Mockery\ExpectationDirector $director);

    /**
     * Return the expectations director for the given method
     *
     * @var string $method
     * @return \Mockery\ExpectationDirector|null
     */
    public function mockery_getExpectationsFor($method);

    /**
     * Find an expectation matching the given method and arguments
     *
     * @var string $method
     * @var array $args
     * @return \Mockery\Expectation|null
     */
    public function mockery_findExpectation($method, array $args);

    /**
     * Return the container for this mock
     *
     * @return \Mockery\Container
     */
    public function mockery_getContainer();

    /**
     * Return the name for this mock
     *
     * @return string
     */
    public function mockery_getName();

    /**
     * @return array
     */
    public function mockery_getMockableProperties();

    /**
     * @return string[]
     */
    public function mockery_getMockableMethods();

    /**
     * @return bool
     */
    public function mockery_isAnonymous();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery;

class ReceivedMethodCalls
{
    private $methodCalls = array();
    
    public function push(MethodCall $methodCall)
    {
        $this->methodCalls[] = $methodCall;
    }

    public function verify(Expectation $expectation)
    {
        foreach ($this->methodCalls as $methodCall) {
            if ($methodCall->getMethod() !== $expectation->getName()) {
                continue;
            }

            if (!$expectation->matchArgs($methodCall->getArgs())) {
                continue;
            }

            $expectation->verifyCall($methodCall->getArgs());
        }

        $expectation->verify();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            