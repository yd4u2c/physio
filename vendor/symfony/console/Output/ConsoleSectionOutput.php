ParentClass()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new AddConsoleCommandPass(), PassConfig::TYPE_BEFORE_REMOVING);
        $className = 'Symfony\Component\Console\Tests\DependencyInjection\MyCommand';

        $parentId = 'my-parent-command';
        $childId = 'my-child-command';

        $parentDefinition = new Definition($className);
        $parentDefinition->setAbstract(true)->setPublic(false);

        $childDefinition = new ChildDefinition($parentId);
        $childDefinition->addTag('console.command')->setPublic(true);

        $container->setDefinition($parentId, $parentDefinition);
        $container->setDefinition($childId, $childDefinition);

        $container->compile();
        $command = $container->get($childId);

        $this->assertInstanceOf($className, $command);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The definition for "my-child-command" has no class.
     */
    public function testProcessOnChildDefinitionWithoutClass()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new AddConsoleCommandPass(), PassConfig::TYPE_BEFORE_REMOVING);

        $parentId = 'my-parent-command';
        $childId = 'my-child-command';

        $parentDefinition = new Definition();
        $parentDefinition->setAbstract(true)->setPublic(false);

        $childDefinition = new ChildDefinition($parentId);
        $childDefinition->addTag('console.command')->setPublic(true);

        $container->setDefinition($parentId, $parentDefinition);
        $container->setDefinition($childId, $childDefinition);

        $container->compile();
    }
}

class MyCommand extends Command
{
}

class NamedCommand extends Command
{
    protected static $defaultName = 'default';
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of the Symfony package.
