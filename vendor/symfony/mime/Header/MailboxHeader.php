g>', array_shift($addresses));
    }

    public function testGetValueReturnsMailboxStringValue()
    {
        $header = new MailboxListHeader('From', [new NamedAddress('chris@swiftmailer.org', 'Chris Corbyn')]);
        $this->assertEquals('Chris Corbyn <chris@swiftmailer.org>', $header->getBodyAsString());
    }

    public function testGetValueReturnsMailboxStringValueForMultipleMailboxes()
    {
        $header = new MailboxListHeader('From', [new NamedAddress('chris@swiftmailer.org', 'Chris Corbyn'), new NamedAddress('mark@swiftmailer.org', 'Mark Corbyn')]);
        $this->assertEquals('Chris Corbyn <chris@swiftmailer.org>, Mark Corbyn <mark@swiftmailer.org>', $header->getBodyAsString());
    }

    public function testSetBody()
    {
        $header = new MailboxListHeader('From', []);
        $header->setBody($addresses = [new Address('chris@swiftmailer.org')]);
        $this->assertEquals($addresses, $header->getAddresses());
    }

    public function testGetBody()
    {
        $header = new MailboxListHeader('From', $addresses = [new Address('chris@swiftmailer.org')]);
        $this->assertEquals($addresses, $header->getBody());
    }

    public function testToString()
    {
        $header = new MailboxListHeader('From', [new NamedAddress('chris@example.org', 'Chris Corbyn'), new NamedAddress('mark@example.org', 'Mark Corbyn')]);
        $this->assertEquals('From: Chris Corbyn <chris@example.org>, Mark Corbyn <mark@example.org>', $header->toString());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      