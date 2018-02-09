<?php

namespace Gandung\JWT\Tests\Algorithm\HMAC;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Algorithm\HMAC\HS256;
use Gandung\JWT\Manager\KeyManager;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class HS256Test extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(HS256::class, new HS256());
    }

    public function testCanSignGivenData()
    {
        $key = new KeyManager;
        $key->setPassphrase('gandung31337');
        $hs256 = new HS256;
        $signature = $hs256->sign('this is a text.', $key);
        $this->assertInternalType('string', $signature);
        $this->assertNotEmpty($signature);
    }

    public function testCanVerifySignatureOfGivenData()
    {
        $key = new KeyManager;
        $key->setPassphrase('gandung31337');
        $hs256 = new HS256;
        $signature = $hs256->sign('this is a text.', $key);
        $this->assertInternalType('string', $signature);
        $this->assertNotEmpty($signature);
        $isSignatureMatched = $hs256->verify($signature, 'this is a text.', $key);
        $this->assertInternalType('boolean', $isSignatureMatched);
        $this->assertTrue($isSignatureMatched);
    }

    public function testCanGetSignatureAlias()
    {
        $hs256 = new HS256;
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::HS256, $hs256->getAlgorithmAlias());
    }
}
