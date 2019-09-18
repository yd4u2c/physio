<?php
namespace SwaggerFixures;

use Exception;
use Swagger\Logger as SwgLogger;
use \Swagger\Logger;
use Swagger\Annotations as SWG;

/**
 * @SWG\Info(title="Fixture for ClassPropertiesTest", version="test")
 * @SWG\Definition()
 */
class Customer
{
    
    /**
     * The firstname of the customer.
     * @var string
     * @SWG\Property()
     */
    public $firstname;
    
    /**
     * @var string The lastname of the customer.
     * @SWG\Property()
     */
    public $lastname;
    
    /**
     * @SWG\Property()
     * @var string[]
     */
    public $tags;
    
    /**
     * @SWG\Property()
     * @var Customer
     */
    public $submittedBy;
    
    /**
     * @SWG\Property()
     * @var Customer[]
     */
    public $friends;

    /**
     * for ContextTest
     */
    public function testResolvingFullyQualifiedNames()
    {
        $test = new SwgLogger();
        $test2 = new Logger();
        $test3 = new SWG\Contact();
        throw new Exception();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 INDX( 	 �z�             (   �  �       i   �                g5     p Z     f5     �7�5qk� ����j�*�Q��<��7�5qk��       �                A n c e s t o r . p h p       h5     � z     f5     H��5qk� ����j��+T��<�H��5qk�x       r                A n c e s t o r W i t h o u t D o c B l o c k s . p h p       i5     h T     f5     �^�5qk� ����j��+T��<��^�5qk��       �               	 C h i l d . p h p     j5     � n     f5     6#�5qk� ����j��V��<�6#�5qk��       �                C h  l d W i t h D o c B l o c k s . p h p   k5     p Z     f5     ���5qk� ����j�<�X��<����5qk�       �               C u s t o m e r . p h p       l5     � j     f5     ���5qk� ����j�<�X��<����5qk�       A	               D y n a m i c R e f e r e n c e . p h p       m5     x d     f5     ��5qk� ����j��R[��<���5qk��       �                G r a n d A n c e s t o r . p h p     n5     p ^     f5     ���5qk� ����j��]��<����5qk��       �                H e l l o T r a i t . p h p  o5     x f     f5      6�5qk� ����j�G`��<� 6�5qk��      �               N e s t e d P r o p e r t y . p h p   p5     h R     f5     d��5qk� ����j�G`��<�d��5qk�8      1               p h p 7 . p h p       q5     h V     f5     ]�5qk� ����j��yb��<�]�5qk�       �              
 r o u t e s . p h p   r5     � t     f5     j��5qk� ����j��d��<�j��5qk�       �               T h i r d P a r t y A n n o t a t i o n s . p h p     s5     p `     f5     ,��5qk� ����j��d��< ,��5qk�H      F               U s i n g P h p D o c . p h p t5     p \     f5     ���5qk� ����j��>g��<����5qk��      �               U s i n g R e f s . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php
namespace SwaggerFixtures;

/**
 * @SWG\Info(title="Using a dynamic reference", version="unittest")
 */
class DynamicReference
{

    /**
     * @SWG\Post(
     *     path="/api/path",
     *     summary="Post to URL",
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="name",
     *                  type="string",
     *                  maximum=64
     *              ),
     *              @SWG\Property(
     *                  property="description",
     *                  type="string"
     *              )
     *          )
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Example extended response",
     *          ref