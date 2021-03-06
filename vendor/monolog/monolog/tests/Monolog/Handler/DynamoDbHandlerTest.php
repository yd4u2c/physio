w TestHandler();
        $exception = new ExceptionTestHandler();
        $handler = new WhatFailureGroupHandler(array($exception, $test, $exception));
        $handler->pushProcessor(function ($record) {
            $record['extra']['foo'] = true;

            return $record;
        });
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasWarningRecords());
        $records = $test->getRecords();
        $this->assertTrue($records[0]['extra']['foo']);
    }
}

class ExceptionTestHandler extends TestHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(array $record)
    {
        parent::handle($record);

        throw new \Exception("ExceptionTestHandler::handle");
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          