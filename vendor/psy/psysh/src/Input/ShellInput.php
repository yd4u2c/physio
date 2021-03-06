ontext();
        $e = new \Exception('wat');
        $context->setLastException($e);
        $this->assertSame($e, $context->getLastException());
        $this->assertSame($e, $context->get('_e'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage No most-recent exception
     */
    public function testLastExceptionThrowsSometimes()
    {
        $context = new Context();
        $context->getLastException();
    }

    public function testLastStdout()
    {
        $context = new Context();
        $context->setLastStdout('ouuuuut');
        $this->assertEquals('ouuuuut', $context->getLastStdout());
        $this->assertEquals('ouuuuut', $context->get('__out'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage No most-recent output
     */
    public function testLastStdoutThrowsSometimes()
    {
        $context = new Context();
        $context->getLastStdout();
    }

    public function testBoundObject()
    {
        $context = new Context();
        $this->assertNull($context->getBoundObject());

        $obj = new \StdClass();
        $context->setBoundObject($obj);
        $this->assertSame($obj, $context->getBoundObject());
        $this->assertSame($obj, $context->get('this'));

        $context->setBoundObject(null);
        $this->assertNull($context->getBoundObject());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unknown variable: $this
     */
    public function testBoundObjectThrowsSometimes()
    {
        $context = new Context();
        $context->get('this');
    }

    public function testBoundClass()
    {
        $context = new Context();
        $this->assertNull($context->getBoundClass());

        $context->setBoundClass('');
        $this->assertNull($context->getBoundClass());

        $context->setBoundClass('Psy\Shell');
        $this->assertEquals('Psy\Shell', $context->getBoundClass());

        $context->setBoundObject(new \StdClass());
        $this->assertNotNull($context->getBoundObject());
        $this->assertNull($context->getBoundClass());

        $context->setBoundClass('Psy\Shell');
        $this->assertEquals('Psy\Shell', $context->getBoundClass());
        $this->assertNull($context->getBoundObject());

        $context->setBoundClass(null);
        $this->assertNull($context->getBoundClass());
        $this->assertNull($context->getBoundObject());
    }

    public function testCommandScopeVariables()
    {
        $__function  = 'donkey';
        $__method    = 'diddy';
        $__class     = 'cranky';
        $__namespace = 'funky';
        $__file      = 'candy';
        $__line      = 'dixie';
        $__dir       = 'wrinkly';

        $vars = \compact('__function', '__method', '__class', '__namespace', '__file', '__line', '__dir');

        $context = new Context();
        $context->setCommandScopeVariables($vars);

        $this->assertEquals($vars, $context->getCommandScopeVariables());

        $this->assertEquals($__function, $context->get('__function'));
        $this->assertEquals($__method, $context->get('__method'));
        $this->assertEquals($__class, $context->get('__class'));
        $this->assertEquals($__namespace, $context->get('__namespace'));
        $this->assertEquals($__file, $context->get('__file'));
        $this->assertEquals($__line, $context->get('__line'));
        $this->assertEquals($__dir, $context->get('__dir'));

        $someVars = \compact('__function', '__namespace', '__file', '__line', '__dir');
        $context->setCommandScopeVariables($someVars);
    }

    public function testGetUnusedCommandScopeVariableNames()
    {
        $context = new Context();

        $this->assertEquals(
            ['__function', '__method', '__class', '__namespace', '__file', '__line', '__dir'],
            $context->getUnusedCommandScopeVariableNames()
        );

        $context->setCommandScopeVariables([
            '__function'  => 'foo',
            '__namespace' => 'bar',
            '__file'      => 'baz',
            '__line'      => 123,
            '__dir'       => 'qux',
        ]);

        $this->assertEquals(
            ['__method', '__class'],
            \array_values($context->getUnusedCommandScopeVariableNames())
        );
    }

    /**
     * @dataProvider specialAndNotSpecialVariableNames
     */
    public function testIsSpecialVariableName($name, $isSpecial)
    {
        $context = new Context();

        if ($isSpecial) {
            $this->assertTrue($context->isSpecialVariableName($name));
        } else {
            $this->assertFalse($context->isSpecialVariableName($name));
        }
    }

    public function specialAndNotSpecialVariableNames()
    {
        return [
            ['foo', false],
            ['psysh', false],
            ['__psysh', false],

            ['_', true],
            ['_e', true],
            ['__out', true],
            ['this', true],
            ['__psysh__', true],

            ['__function', true],
            ['__method', true],
            ['__class', true],
            ['__namespace', true],
            ['__file', true],
            ['__line', true],
            ['__dir', true],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       INDX( 	 �1�             (   �	  �       d � h               w&     � j     v&     �y-�pk� %=�Jc�FTs��<��y-�pk�                      C l a s s W i t h S e c r e t s . p h p       �&     h X     v&     u�pk���pk���pk���pk�                        C o d e C l e a n e r x&     x h     v&     7�pk� %=�Jc�FTs��<�7�pk�       �               C o d e C l e a n e r T e s t . p h p �&     ` P     v&     W>��pk�p� �pk�p� �pk�p� �pk�                        C o m m a n  y&     � l     v&     �B�pk� %=�Jc�a�u��<��B�pk� 0      '                C o n f i g u r a t i o n T e s t . p h p     z&     � x     v&     �J�pk� %=�Jc��x��<��J�pk�       �               C o n s o l e C o l o r F a c t o r y T e s t . p h p {&     p `     v&     a�N�pk� %=�Jc��x��<�a�N�pk� 0      �$               C o n t e x t T e s t . p h p �&     h T     v&     ���pk�)��=^%����pk����pk�                       	 E x c e p t i o n . p |&     p \     v&     U�S�pk  %=�Jc�|z��<�U�S�pk�                     F a k e S h e l l . p h p     �&     h R     v&     �VS�pk�-��pk�-��pk�-��pk�                        f i x t u r e s s t C �&     h T     v&     T��pk��f��pk��f��pk��f��pk�                       	 F o r m a t t e r t C �&     ` L     v&     G�pk� �>^%�G�pk�G�pk�                        I n p u t r T }&     x f     v&     �_�pk� %=�Jc���|��<��_�pk�       �	               P a r s e r T e s t C a s e . p h p   �&     h R     v&     }>��pk����>^%�}>��pk�}>��pk�                        R e a d l i n e t . p �&     h V     v&     8=۠pk�|��>^%�8=۠pk�8=۠pk�                       
 R e f l e c t i o n p ~&     p \     v&     h�m�pk� %=�Jc��?��<�h�m�pk� @      �4               S h e l l T e s t . p h p     �&     ` J     v&     2���pk��$�>^%�� ��pk�2���pk�                        S u d o T e s &     p Z     v&     u�pk� %=�Jc��?��<�u�pk�       �
               S u d o T e s t . p  p       �&     p \     v&     �'�pk�O?^%���pk��'�pk�                        T a b C o m p l e t i o n     �&     ` L     v&     p:�pk���
?^%�p:�pk�p:�pk�                        t o o l s     �&     ` J     v&     Sb �pk�� ?^%�Sb �pk�Sb �pk�                        U t i l       �&     p ^     v&     u3�pk�P].?^%�u3�pk�u3�pk�                        V e r s i o n U p d a t e r                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 