Some description');
        $option2 = new InputOption('foo', 'f', InputOption::VALUE_OPTIONAL, 'Some description', true);
        $this->assertFalse($option->equals($option2));

        $option = new InputOption('foo', 'f', null, 'Some description');
        $option2 = new InputOption('bar', 'f', null, 'Some description');
        $this->assertFalse($option->equals($option2));

        $option = new InputOption('foo', 'f', null, 'Some description');
        $option2 = new InputOption('foo', '', null, 'Some description');
        $this->assertFalse($option->equals($option2));

        $option = new InputOption('foo', 'f', null, 'Some description');
        $option2 = new InputOption('foo', 'f', InputOption::VALUE_OPTIONAL, 'Some description');
        $this->assertFalse($option->equals($option2));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 