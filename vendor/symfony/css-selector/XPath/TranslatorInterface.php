       }');
        } elseif ('Test\\'.__NAMESPACE__.'\ExtendsInternalsParent' === $class) {
            eval('namespace Test\\'.__NAMESPACE__.'; class ExtendsInternalsParent extends \\'.__NAMESPACE__.'\Fixtures\InternalClass implements \\'.__NAMESPACE__.'\Fixtures\InternalInterface { }');
        } elseif ('Test\\'.__NAMESPACE__.'\UseTraitWithInternalMethod' === $class) {
            eval('namespace Test\\'.__NAMESPACE__.'; class UseTraitWithInternalMethod { use \\'.__NAMESPACE__.'\Fixtures\TraitWithInternalMethod; }');
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          