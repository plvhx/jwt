<?php

namespace Gandung\JWT\Tests\Algorithm\RSA;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Algorithm\RSA\RS256;
use Gandung\JWT\Manager\KeyManager;
use Gandung\JWT\Tests\Exception\ConstantFromExternalModuleNotFoundException;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class RS256Test extends TestCase
{
    public function testIfConstantValueExistsFromOpensslDependency()
    {
        if (!defined('OPENSSL_ALGO_SHA256') ||
            !defined('OPENSSL_ALGO_SHA384') ||
            !defined('OPENSSL_ALGO_SHA512')) {
            throw new ConstantFromExternalModuleNotFoundException(
                "Install 'openssl' module first."
            );
        }

        $this->assertTrue(true);
    }

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(RS256::class, new RS256());
    }

    public function testCanSignGivenData()
    {
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/dummy256.pem');
        $key->setPassphrase('umar123');
        $rs256 = new RS256;
        $signature = $rs256->sign('this is a text.', $key);
        $this->assertInternalType('string', $signature);
        $this->assertNotEmpty($signature);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenSignDataWithBadKey()
    {
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/dummy256.pem');
        $rs256 = new RS256;
        $signature = $rs256->sign('this is a text.', $key);
    }

    public function testCanVerifySignatureOfGivenData()
    {
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/dummy256.pem');
        $key->setPassphrase('umar123');
        $rs256 = new RS256;
        $signature = $rs256->sign('this is a text.', $key);
        $this->assertInternalType('string', $signature);
        $this->assertNotEmpty($signature);
        $isSignatureMatched = $rs256->verify($signature, 'this is a text.', $key);
        $this->assertInternalType('boolean', $isSignatureMatched);
        $this->assertTrue($isSignatureMatched);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenVerifySignatureOfGivenDataWithBadKey()
    {
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/dummy256.pem');
        $key->setPassphrase('umar123');
        $rs256 = new RS256;
        $signature = $rs256->sign('this is a text.', $key);
        $this->assertInternalType('string', $signature);
        $this->assertNotEmpty($signature);
        $key->setPassphrase(null);
        $isSignatureMatched = $rs256->verify($signature, 'this is a text.', $key);
    }

    public function testCanGetAlgorithmAlias()
    {
        $rs256 = new RS256;
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::RS256, $rs256->getAlgorithmAlias());
    }
}
