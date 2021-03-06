<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Mockery;

use Closure;
use ReflectionClass;
use UnexpectedValueException;
use InvalidArgumentException;

/**
 * This is a trimmed down version of https://github.com/doctrine/instantiator,
 * basically without the caching
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
final class Instantiator
{
    /**
     * Markers used internally by PHP to define whether {@see \unserialize} should invoke
     * the method {@see \Serializable::unserialize()} when dealing with classes implementing
     * the {@see \Serializable} interface.
     */
    const SERIALIZATION_FORMAT_USE_UNSERIALIZER   = 'C';
    const SERIALIZATION_FORMAT_AVOID_UNSERIALIZER = 'O';

    /**
     * {@inheritDoc}
     */
    public function instantiate($className)
    {
        $factory    = $this->buildFactory($className);
        $instance   = $factory();

        return $instance;
    }

    /**
     * @internal
     * @private
     *
     * Builds a {@see \Closure} capable of instantiating the given $className without
     * invoking its constructor.
     * This method is only exposed as public because of PHP 5.3 compatibility. Do not
     * use this method in your own code
     *
     * @param string $className
     *
     * @return Closure
     */
    public function buildFactory($className)
    {
        $reflectionClass = $this->getReflectionClass($className);

        if ($this->isInstantiableViaReflection($reflectionClass)) {
            return function () use ($reflectionClass) {
                return $reflectionClass->newInstanceWithoutConstructor();
            };
        }

        $serializedString = sprintf(
            '%s:%d:"%s":0:{}',
            $this->getSerializationFormat($reflectionClass),
            strlen($className),
            $className
        );

        $this->attemptInstantiationViaUnSerialization($reflectionClass, $serializedString);

        return function () use ($serializedString) {
            return unserialize($serializedString);
        };
    }

    /