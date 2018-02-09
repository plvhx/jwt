<?php

namespace Gandung\JWT\Tests\Algorithm\ECDSA;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Adapter\ECDSAAdapter;
use Gandung\JWT\Algorithm\ECDSA\ES256;
use Gandung\JWT\Manager\KeyManager;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ES256Test extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(ES256::class, new ES256(ECDSAAdapter::create()));
    }

    public function testCanSignGivenData()
    {
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/secp256.pem');
        $es256 = new ES256(ECDSAAdapter::create());
        $signature = $es256->sign('this is a text.', $key);
        $this->assertInternalType('string', $signature);
        $this->assertNotEmpty($signature);
    }

    public function testCanVerifySignature()
    {
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/secp256.pem');
        $es256 = new ES256(ECDSAAdapter::create());
        $signature = $es256->sign('this is a text.', $key);
        $this->assertInternalType('string', $signature);
        $this->assertNotEmpty($signature);
        $key->setContentFromCertFile('cert/secp256.pub.pem');
        $isSignatureMatched = $es256->verify($signature, 'this is a text.', $key);
        $this->assertInternalType('boolean', $isSignatureMatched);
        $this->assertTrue($isSignatureMatched);
    }

    public function testCanGetAlgorithmAlias()
    {
        $es256 = new ES256(ECDSAAdapter::create());
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::ES256, $es256->getAlgorithmAlias());
    }
}
