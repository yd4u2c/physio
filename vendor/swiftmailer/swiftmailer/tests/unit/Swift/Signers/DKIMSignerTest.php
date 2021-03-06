0065006d006200650072002e0074006500730074002e0063006f006d000000000000000000';

        $login = $this->getAuthenticator();
        $message3 = $this->invokePrivateMethod('createMessage3', $login, [$domain, $username, $workstation, hex2bin($lmResponse), hex2bin($ntlmResponse)]);

        $this->assertEquals($this->message3, bin2hex($message3), '%s: We send the same information as the example is created with so this should be the same');
    }

    public function testGetDomainAndUsername()
    {
        $username = "DOMAIN\user";

        $login = $this->getAuthenticator();
        list($domain, $user) = $this->invokePrivateMethod('getDomainAndUsername', $login, [$username]);

        $this->assertEquals('DOMAIN', $domain, '%s: the fetched domain did not match');
        $this->assertEquals('user', $user, '%s: the fetched user did not match');
    }

    public function testGetDomainAndUsernameWithExtension()
    {
        $username = "domain.com\user";

        $login = $this->getAuthenticator();
        list($domain, $user) = $this->invokePrivateMethod('getDomainAndUsername', $login, [$username]);

        $this->assertEquals('domain.com', $domain, '%s: the fetched domain did not match');
        $this->assertEquals('user', $user, '%s: the fetched user did not match');
    }

    public function testGetDomainAndUsernameWithAtSymbol()
    {
        $username = 'user@DOMAIN';

        $login = $this->getAuthenticator();
        list($domain, $user) = $this->invokePrivateMethod('getDomainAndUsername', $login, [$username]);

        $this->assertEquals('DOMAIN', $domain, '%s: the fetched domain did not match');
        $this->assertEquals('user', $user, '%s: the fetched user did not match');
    }

    public function testGetDomainAndUsernameWithAtSymbolAndExtension()
    {
        $username = 'user@domain.com';

        $login = $this->getAuthenticator();
        list($domain, $user) = $this->invokePrivateMethod('getDomainAndUsername', $login, [$username]);

        $this->assertEquals('domain.com', $domain, '%s: the fetched domain did not match');
        $this->assertEquals('user', $user, '%s: the fetched user did not match');
    }

    public function testGetDomainAndUsernameWithoutDomain()
    {
        $username = 'user';

        $login = $this->getAuthenticator();
        list($domain, $user) = $this->invokePrivateMethod('getDomainAndUsername', $login, [$username]);

        $this->assertEquals('', $domain, '%s: the fetched domain did not match');
        $this->assertEquals('user', $user, '%s: the fetched user did not match');
    }

    public function testSuccessfulAuthentication()
    {
        $domain = 'TESTNT';
        $username = 'test';
        $secret = 'test1234';

        $ntlm = $this->getAuthenticator();
        $agent = $this->getAgent();
        $agent->shouldReceive('executeCommand')
              ->once()
              ->with('AUTH NTLM '.base64_encode(
                        $this->invokePrivateMethod('createMessage1', $ntlm)
                    )."\r\n", [334])
              ->andReturn('334 '.base64_encode(hex2bin('4e544c4d53535000020000000c000c003000000035828980514246973ea892c10000000000000000460046003c00000054004500530054004e00540002000c0054004500530054004e00540001000c004d0045004d0042004500520003001e006d0065006d006200650072002e0074006500730074002e0063006f006d0000000000')));
        $agent->shouldReceive('executeCommand')
              ->once()
              ->with(base64_encode(
                        $this->invokePrivateMethod('createMessage3', $ntlm, [$domain, $username, hex2bin('4d0045004d00420045005200'), hex2bin('bf2e015119f6bdb3f6fdb768aa12d478f5ce3d2401c8f6e9'), hex2bin('caa4da8f25d5e840974ed8976d3ada46010100000000000030fa7e3c677bc301f5ce3d2401c8f6e90000000002000c0054004500530054004e00540001000c004d0045004d0042004500520003001e006d0065006d006200650072002e0074006500730074002e0063006f006d000000000000000000')]
                    ))."\r\n", [235]);

        $this->assertTrue($ntlm->authenticate($agent, $username.'@'.$domain, $secret, hex2bin('30fa7e3c677bc301'), hex2bin('f5ce3d2401c8f6e9')), '%s: The buffer accepted all commands authentication should succeed');
    }

    /**
     * @expectedException \Swift_TransportException
     */
    public function testAuthenticationFailureSendRset()
    {
        $domain = 'TESTNT';
        $username = 'test';
        $secret = 'test1234';

        $ntlm = $this->getAuthenticator();
        $agent = $this->getAgent();
        $agent->shouldReceive('executeCommand')
              ->once()
              ->with('AUTH NTLM '.base64_encode(
                        $this->invokePrivateMethod('createMessage1', $ntlm)
                    )."\r\n", [334])
              ->andThrow(new Swift_TransportException(''));
        $agent->shouldReceive('executeCommand')
              ->once()
              ->with("RSET\r\n", [250]);

        $ntlm->authenticate($agent, $username.'@'.$domain, $secret, hex2bin('30fa7e3c677bc301'), hex2bin('f5ce3d2401c8f6e9'));
    }

    private function getAuthenticator()
    {
        return new Swift_Transport_Esmtp_Auth_NTLMAuthenticator();
    }

    private function getAgent()
    {
        return $this->getMockery('Swift_Transport_SmtpAgent')->shouldIgnoreMissing();
    }

    private function invokePrivateMethod($method, $instance, array $args = [])
    {
        $methodC = new ReflectionMethod($instance, trim($method));
        $methodC->setAccessible(true);

        return $methodC->invokeArgs($instance, $args);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

class Swift_Transport_Esmtp_Auth_PlainAuthenticatorTest extends \SwiftMailerTestCase
{
    private $agent;

    protected function setUp()
    {
        $this->agent = $this->getMockery('Swift_Transport_SmtpAgent')->shouldIgnoreMissing();
    }

    public function testKeywordIsPlain()
    {
        /* -- RFC 4616, 1.
        The name associated with this mechanism is "PLAIN".
        */

        $login = $this->getAuthenticator();
        $this->assertEquals('PLAIN', $login->getAuthKeyword());
    }

    public function testSuccessfulAuthentication()
    {
        /* -- RFC 4616, 2.
        The client presents the authorization identity (identity to act as),
        followed by a NUL (U+0000) character, followed by the authentication
        identity (identity whose password will be used), followed by a NUL
        (U+0000) character, followed by the clear-text password.
        */

        $plain = $this->getAuthenticator();

        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with('AUTH PLAIN '.base64_encode(
                        'jack'.chr(0).'jack'.chr(0).'pass'
                    )."\r\n", [235]);

        $this->assertTrue($plain->authenticate($this->agent, 'jack', 'pass'),
            '%s: The buffer accepted all commands authentication should succeed'
            );
    }

    /**
     * @expectedException \Swift_TransportException
     */
    public function testAuthenticationFailureSendRset()
    {
        $plain = $this->getAuthenticator();

        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with('AUTH PLAIN '.base64_encode(
                        'jack'.chr(0).'jack'.chr(0).'pass'
                    )."\r\n", [235])
             ->andThrow(new Swift_TransportException(''));
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with("RSET\r\n", [250]);

        $plain->authenticate($this->agent, 'jack', 'pass');
    }

    private function getAuthenticator()
    {
        return new Swift_Transport_Esmtp_Auth_PlainAuthenticator();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          