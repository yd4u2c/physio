interface: "%s".', $class, $r->name, $p->name, $type);

                        // see if the type-hint lives in the same namespace as the controller
                        if (0 === strncmp($type, $class, strrpos($class, '\\'))) {
                            $message .= ' Did you forget to add a use statement?';
                        }

                        throw new InvalidArgumentException($message);
                    }

                    $target = ltrim($target, '\\');
                    $args[$p->name] = $type ? new TypedReference($target, $type, $invalidBehavior, $p->name) : new Reference($target, $invalidBehavior);
                }
                // register the maps as a per-method service-locators
                if ($args) {
                    $controllers[$id.'::'.$r->name] = ServiceLocatorTagPass::register($container, $args);
                }
            }
        }

        $container->getDefinition($this->resolverServiceId)
            ->replaceArgument(0, $controllerLocatorRef = ServiceLocatorTagPass::register($container, $controllers));

        $container->setAlias($this->controllerLocator, (string) $controllerLocatorRef);
    }
}
                                                                                                                                                                                                                                                                                         