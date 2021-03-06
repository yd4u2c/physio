#<(script|style).*?</\1>#s', '', $output);
        $output = preg_replace('/sf-dump-\d+/', 'sf-dump', $output);

        $this->assertSame($xOutput, trim($output));
        $this->assertSame(1, $collector->getDumpsCount());
        $collector->serialize();
    }

    public function testFlush()
    {
        $data = new Data([[456]]);
        $collector = new DumpDataCollector();
        $collector->dump($data);
        $line = __LINE__ - 1;

        ob_start();
        $collector->__destruct();
        $output = preg_replace("/\033\[[^m]*m/", '', ob_get_clean());
        $this->assertSame("DumpDataCollectorTest.php on line {$line}:\n456\n", $output);
    }

    public function testFlushNothingWhenDataDumperIsProvided()
    {
        $data = new Data([[456]]);
        $dumper = new CliDumper('php://output');
        $collector = new DumpDataCollector(null, null, null, null, $dumper);

        ob_start();
        $collector->dump($data);
        $line = __LINE__ - 1;
        $output = preg_replace("/\033\[[^m]*m/", '', ob_get_clean());

        $this->assertSame("DumpDataCollectorTest.php on line {$line}:\n456\n", $output);

        ob_start();
        $collector->__destruct();
        $this->assertEmpty(ob_get_clean());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         