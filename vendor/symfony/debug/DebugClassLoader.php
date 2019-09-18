<?php

namespace Symfony\Component\Debug\Tests\Fixtures;

/**
 * @method string interfaceMethod()
 * @method        sameLineInterfaceMethod($arg)
 * @method sameLineInterfaceMethodNoBraces
 *
 * Ignored
 * @method
 * @method
 *
 * Not ignored
 * @method newLineInterfaceMethod() Some description!
 * @method \stdClass newLineInterfaceMethodNoBraces Description
 *
 * Invalid
 * @method unknownType invalidInterfaceMethod()
 * @method unknownType|string invalidInterfaceMethodNoBraces
 *
 * Complex
 * @method              complexInterfaceMethod($arg, ...$args)
 * @method string[]|int complexInterfaceMethodTyped($arg, int ...$args) Description ...
 *
 * Static
 * @method static Foo&Bar staticMethod()
 * @method static staticMethodNoBraces
 * @method static \stdClass staticMethodTyped(int $arg) Description
 * @method static \stdClass[] staticMethodTypedNoBraces
 */
interface VirtualInterface
{
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           INDX( 	 Ot�            (   �  �       �t i r               .     x f     .     �$�pk� ސ����b����<��$�pk�8      7               I n t e r n a l T r a i t 2 . p h p   .     � �     .     �})�pk� ސ����b����<��})�pk�p      k               L o g g e r T h a t S e t A n E r r o r H a n d l e r . p h p .     � v     .     IB.�pk� ސ�����F���<�IB.�pk��       {                N o n D e p r e c a t e d I n t e r f a c e . p h p   .     p ^     .     ��0�pk� ސ��������< ��0�pk�P       O                n o t P s r 0 B i s . p h p   .     p \     .     �3�pk� ސ��������<��3�pk�H       B                P E A R C l a s s . p h p     ".     ` J     .     �R�pk���T� %��R�pk��R�pk�                        p s r 4 l y N .     x d     .     j5�pk� ސ����i���<�j5�pk�P       L                r e a l l y N o t P s r 0 . p h p     .     � �     .     C�7�pk� ސ�����n���<�C�7�pk��      �              # S u b C l a s s W i t h A n n o t a  e d P a r a m e t e r s . p h p .     p Z     .     .:�pk� ސ����0����<�.:�pk�(       $                T h r o w i n g . p h p       .     x h     .     f�<�pk� ސ����0����<�f�<�pk�                       T o S t r i n g T h r o w e r . p h p .     � �     .     ^�>�pk� ސ����u3���<�^�>�pk��       �                 T r a i t W i t h A n n o t a t e d P a r a m e t e r s . p h p       .     � x     .     �UA�pk� ސ��������<��UA�pk��       �                T r a i t W  t h I n t e r n a l M e t h o d . p h p .     x b     .     ��C�pk��gF� %��gF� %���C�pk��       �                V i r t u a l C l a s s . p h p       .     � t     .     �F�pk���H� %���H� %��F�pk�8      1               V i r t u a l C l a s s M a g i c C a l l . p h p     .     � j     .     ��J�pk�C,K� %�C,K� %���J�pk�       �               V i r t u a l I n t e r f a c e . p h p        .     � p     .     �@M�pk���M� %���M� %��@M�pk��       �                V i  t u a l S u b I n t e r f a c e . p h p !.     x b     .     :�O�pk���O� %���O� %�:�O�pk��       y                V i r t u a l T r a i t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 --TEST--
Test DebugClassLoader with previously loaded parents
--FILE--
<?php

namespace Symfony\Component\Debug\Tests\Fixtures;

use Symfony\Component\Debug\DebugClassLoader;

$vendor = __DIR__;
while (!file_exists($vendor.'/vendor')) {
    $vendor = \dirname($vendor);
}
require $vendor.'/vendor/autoload.php';

class_exists(FinalMethod::class);

set_error_handler(function ($type, $msg) { echo $msg, "\n"; });

DebugClassLoader::enable();

class_exists(ExtendedFinalMethod::class);

?>
--EXPECTF--
The "Symfony\Component\Debug\Tests\Fixtures\FinalMethod::finalMethod()" method is considered final. It may change without further notice as of its next major version. You should not extend it from "Symfony\Component\Debug\Tests\Fixtures\ExtendedFinalMethod".
The "Symfony\Component\Debug\Tests\Fixtures\FinalMethod::finalMethod2()" method is considered final. It may change without further notice as of its next major version. You should not extend it from "Symfony\Component\Debug\Tests\Fixtures\ExtendedFinalMethod".
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     --TEST--
Test catching fatal errors when handlers are nested
--INI--
display_errors=0
--FILE--
<?php

namespace Symfony\Component\Debug;

$vendor = __DIR__;
while (!file_exists($vendor.'/vendor')) {
    $vendor = \dirname($vendor);
}
require $vendor.'/vendor/autoload.php';

set_error_handler('var_dump');
set_exception_handler('var_dump');

ErrorHandler::register(null, false);

if (true) {
    class foo extends missing
    {
    }
}

?>
--EXPECTF--
object(Symfony\Component\Debug\Exception\ClassNotFoundException)#%d (8) {
  ["message":protected]=>
  string(131) "Attempted to load class "missing" from namespace "Symfony\Component\Debug".
Did you forget a "use" statement for another namespace?"
  ["string":"Exception":private]=>
  string(0) ""
  ["code":protected]=>
  int(0)
  ["file":protected]=>
  string(%d) "%s"
  ["line":protected]=>
  int(%d)
  ["trace":"Exception":private]=>
  array(%d) {%A}
  ["previous":"Exception":private]=>
  NULL
  ["severity":protected]=>
  int(1)
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   --TEST--
Test rethrowing in custom exception handler
--FILE--
<?php

namespace Symfony\Component\Debug;

$vendor = __DIR__;
while (!file_exists($vendor.'/vendor')) {
    $vendor = \dirname($vendor);
}
require $vendor.'/vendor/autoload.php';

if (true) {
    class TestLogger extends \Psr\Log\AbstractLogger
    {
        public function log($level, $message, array $context = [])
        {
            echo $message, "\n";
        }
    }
}

set_exception_handler(function ($e) { echo 123; throw $e; });
ErrorHandler::register()->setDefaultLogger(new TestLogger());
ini_set('display_errors', 1);

throw new \Exception('foo');
?>
--EXPECTF--
Uncaught Exception: foo
123
Fatal error: Uncaught %s:25
Stack trace:
%a
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             