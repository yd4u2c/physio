
    {modifier} function {reference}{method_name}({arguments_decl}){return_delim}{return_type}
    {
        $__phpunit_arguments = [{arguments_call}];
        $__phpunit_count     = func_num_args();

        if ($__phpunit_count > {arguments_count}) {
            $__phpunit_arguments_tmp = func_get_args();

            for ($__phpunit_i = {arguments_count}; $__phpunit_i < $__phpunit_count; $__phpunit_i++) {
                $__phpunit_arguments[] = $__phpunit_arguments_tmp[$__phpunit_i];
            }
        }

        $__phpunit_invocation = new \PHPUnit\Framework\MockObject\Invocation\ObjectInvocation(
            '{class_name}', '{method_name}', $__phpunit_arguments, '{return_type}', $this, {clone_arguments}
        );

        $__phpunit_invocation->setProxiedCall();

        $this->__phpunit_getInvocationMocker()->invoke($__phpunit_invocation);

        unset($__phpunit_invocation);

        call_user_func_array(array($this->__phpunit_originalObject, "{method_name}"), $__phpunit_arguments);
    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            