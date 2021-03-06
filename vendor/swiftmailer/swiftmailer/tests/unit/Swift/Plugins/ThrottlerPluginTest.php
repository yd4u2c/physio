ticator('LOGIN');
        $a3 = $this->createMockAuthenticator('CRAM-MD5');

        $a1->shouldReceive('authenticate')
           ->once()
           ->with($this->agent, 'jack', 'pass')
           ->andReturn(false);
        $a2->shouldReceive('authenticate')
           ->once()
           ->with($this->agent, 'jack', 'pass')
           ->andReturn(true);
        $a3->shouldReceive('authenticate')
           ->never()
           ->with($this->agent, 'jack', 'pass');

        $auth = $this->createHandler([$a1, $a2]);
        $auth->setUsername('jack');
        $auth->setPassword('pass');

        $auth->setKeywordParams(['PLAIN', 'LOGIN', 'CRAM-MD5']);
        $auth->afterEhlo($this->agent);
    }

    private function createHandler($authenticators)
    {
        return new Swift_Transport_Esmtp_AuthHandler($authenticators);
    }

    private function createMockAuthenticator($type)
    {
        $authenticator = $this->getMockery('Swift_Transport_Esmtp_Authenticator')->shouldIgnoreMissing();
        $authenticator->shouldReceive('getAuthKeyword')
                      ->zeroOrMoreTimes()
                      ->andReturn($type);

        return $authenticator;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 