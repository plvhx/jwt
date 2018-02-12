<?php

namespace Gandung\JWT\Tests;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\JWT;
use Gandung\JWT\JWTFactory;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class JWTTest extends TestCase
{
    private function callValidateKeyDirectly()
    {
        $key = JWTFactory::getKeyManager();
        $key->setContent('this is a text.');
        $refl = new \ReflectionClass(JWT::class);
        $method = $refl->getMethod('validateKey');
        $method->setAccessible(true);
        $method->invokeArgs(JWT::create(), [$key, \Gandung\JWT\Token\Algorithm::ES256]);
    }

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(JWT::class, JWT::create());
    }

    public function testCanGetInstanceFromFactory()
    {
        $this->assertInstanceOf(JWT::class, JWTFactory::getJwt());
    }

    public function testCanCreateTokenWithNoCertAlgoProvided()
    {
        $key = JWTFactory::getKeyManager();
        $key->setPassphrase('gandung31337');
        $jose = JWTFactory::getJoseBuilder()
            ->algorithm(\Gandung\JWT\Token\Algorithm::HS256)
            ->type('JWT')
            ->contentType('application/json');
        $claim = JWTFactory::getClaimBuilder()
            ->issuedBy('Paulus Gandung Prakosa')
            ->expireAt(new \DateTimeImmutable('@' . (time() + (3600 * 3))));
        $payload = JWTFactory::getPayloadBuilder()
            ->claim($claim)
            ->userData([
                'credentials' => [
                    'username' => 'gandung',
                    'password' => 'gandung31337'
                ]
            ]);
        $jwt = JWT::create();
        $token = $jwt->createToken($jose, $payload, $key);
        $this->assertInternalType('string', $token);
        $this->assertNotEmpty($token);
    }

    public function testCanCreateToken()
    {
        $key = JWTFactory::getKeyManager();
        $key->setContentFromCertFile('cert/dummy256.pem');
        $key->setPassphrase('umar123');
        $jose = JWTFactory::getJoseBuilder()
            ->algorithm(\Gandung\JWT\Token\Algorithm::RS256)
            ->type('JWT')
            ->contentType('application/json');
        $claim = JWTFactory::getClaimBuilder()
            ->issuedBy('Paulus Gandung Prakosa')
            ->expireAt(new \DateTimeImmutable('@' . (time() + (3600 * 3))));
        $payload = JWTFactory::getPayloadBuilder()
            ->claim($claim)
            ->userData([
                'credentials' => [
                    'username' => 'gandung',
                    'password' => 'gandung31337'
                ]
            ]);
        $jwt = JWT::create();
        $token = $jwt->createToken($jose, $payload, $key);
        $this->assertInternalType('string', $token);
        $this->assertNotEmpty($token);
    }

    public function testCanVerifyToken()
    {
        $key = JWTFactory::getKeyManager();
        $key->setContentFromCertFile('file://cert/secp256.pem');
        $jose = JWTFactory::getJoseBuilder()
            ->algorithm(\Gandung\JWT\Token\Algorithm::ES256)
            ->type('JWT')
            ->contentType('application/json');
        $claim = JWTFactory::getClaimBuilder()
            ->issuedBy('Paulus Gandung Prakosa')
            ->expireAt(new \DateTimeImmutable('@' . (time() * (3600 * 3))));
        $payload = JWTFactory::getPayloadBuilder()
            ->claim($claim)
            ->userData([
                'credentials' => [
                    'username' => 'gandung',
                    'password' => 'gandung31337'
                ]
            ]);
        $jwt = JWT::create();
        $token = $jwt->createToken($jose, $payload, $key);
        $this->assertInternalType('string', $token);
        $this->assertNotEmpty($token);
        $key->setContentFromCertFile('file://cert/secp256.pub.pem');
        $isSignatureMatched = $jwt->verifyToken($token, $jose, $payload, $key);
        $this->assertInternalType('boolean', $isSignatureMatched);
        $this->assertTrue($isSignatureMatched);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCanRaiseExceptionWhenValidateInvalidCertContent()
    {
        $this->callValidateKeyDirectly();
    }
}
