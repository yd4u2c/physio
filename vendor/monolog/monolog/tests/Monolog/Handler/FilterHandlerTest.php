->getRecord($level, 'test', array('test' => 1)));

        $attachment = $data['attachments'][0];
        $this->assertArrayHasKey('title', $attachment);
        $this->assertArrayHasKey('fields', $attachment);
        $this->assertSame($levelName, $attachment['title']);
        $this->assertSame(array(), $attachment['fields']);
    }

    public function testAddsShortAttachmentWithContextAndExtra()
    {
        $level = Logger::ERROR;
        $levelName = Logger::getLevelName($level);
        $context = array('test' => 1);
        $extra = array('tags' => array('web'));
        $record = new SlackRecord(null, null, true, null, true, true);
        $loggerRecord = $this->getRecord($level, 'test', $context);
        $loggerRecord['extra'] = $extra;
        $data = $record->getSlackData($loggerRecord);

        $attachment = $data['attachments'][0];
        $this->assertArrayHasKey('title', $attachment);
        $this->assertArrayHasKey('fields', $attachment);
        $this->assertCount(2, $attachment['fields']);
        $this->assertSame($levelName, $attachment['title']);
        $this->assertSame(
            array(
                array(
                    'title' => 'Extra',
                    'value' => sprintf('```%s```', json_encode($extra, $this->jsonPrettyPrintFlag)),
                    'short' => false
                ),
                array(
                    'title' => 'Context',
                    'value' => sprintf('```%s```', json_encode($context, $this->jsonPrettyPrintFlag)),
                    'short' => false
                )
            ),
            $attachment['fields']
        );
    }

    public function testAddsLongAttachmentWithoutContextAndExtra()
    {
        $level = Logger::ERROR;
        $levelName = Logger::getLevelName($level);
        $record = new SlackRecord(null, null, true, null);
        $data = $record->getSlackData($this->getRecord($level, 'test', array('test' => 1)));

        $attachment = $data['attachments'][0];
        $this->assertArrayHasKey('title', $attachment);
        $this->assertArrayHasKey('fields', $attachment);
        $this->assertCount(1, $attachment['fields']);
        $this->assertSame('Message', $attachment['title']);
        $this->assertSame(
            array(array(
                'title' => 'Level',
                'value' => $levelName,
                'short' => false
            )),
            $attachment['fields']
        );
    }

    public function testAddsLongAttachmentWithContextAndExtra()
    {
        $level = Logger::ERROR;
        $levelName = Logger::getLevelName($level);
        $context = array('test' => 1);
        $extra = array('tags' => array('web'));
        $record = new SlackRecord(null, null, true, null, false, true);
        $loggerRecord = $this->getRecord($level, 'test', $context);
        $loggerRecord['extra'] = $extra;
        $data = $record->getSlackData($loggerRecord);

        $expectedFields = array(
            array(
                'title' => 'Level',
                'value' => $levelName,
                'short' => false,
            ),
            array(
                'title' => 'Tags',
                'value' => sprintf('```%s```', json_encode($extra['tags'])),
                'short' => false
            ),
            array(
                'title' => 'Test',
                'value' => $context['test'],
                'short' => false
            )
        );

        $attachment = $data['attachments'][0];
        $this->assertArrayHasKey('title', $attachment);
        $this->assertArrayHasKey('fields', $attachment);
        $this->assertCount(3, $attachment['fields']);
        $this->assertSame('Message', $attachment['title']);
        $this->assertSame(
            $expectedFields,
            $attachment['fields']
        );
    }

    public function testAddsTimestampToAttachment()
    {
        $record = $this->getRecord();
        $slackRecord = new SlackRecord();
        $data = $slackRecord->getSlackData($this->getRecord());

        $attachment = $data['attachments'][0];
        $this->assertArrayHasKey('ts', $attachment);
        $this->assertSame($record['datetime']->getTimestamp(), $attachment['ts']);
    }

    public function testContextHasException()
    {
        $record = $this->getRecord(Logger::CRITICAL, 'This is a critical message.', array('exception' => new \Exception()));
        $slackRecord = new SlackRecord(null, null, true, null, false, true);
        $data = $slackRecord->getSlackData($record);
        $this->assertInternalType('string', $data['attachments'][0]['fields'][1]['value']);
    }

    public function testExcludeExtraAndContextFields()
    {
        $record = $this->getRecord(
            Logger::WARNING,
            'test',
            array('info' => array('library' => 'monolog', 'author' => 'Jordi'))
        );
        $record['extra'] = array('tags' => array('web', 'cli'));

        $slackRecord = new SlackRecord(null, null, true, null, false, true, array('context.info.library', 'extra.tags.1'));
        $data = $slackRecord->getSlackData($record);
        $attachment = $data['attachments'][0];

        $expected = array(
            array(
                'title' => 'Info',
                'value' => sprintf('```%s```', json_encode(array('author' => 'Jordi'), $this->jsonPrettyPrintFlag)),
                'short' => false
            ),
            array(
                'title' => 'Tags',
                'value' => sprintf('```%s```', json_encode(array('web'))),
                'short' => false
            ),
        );

        foreach ($expected as $field) {
            $this->assertNotFalse(array_search($field, $attachment['fields']));
            break;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     