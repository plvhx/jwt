<?php

namespace Gandung\JWT\Tests\Adapter;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Adapter\ECDSAAdapter;
use Gandung\JWT\Manager\KeyManager;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\PemPublicKeySerializer;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ECDSAAdapterTest extends TestCase
{
    private function callDetermineGeneratorPointDirectly()
    {
        $adapter = ECDSAAdapter::create();
        $refl = new \ReflectionClass($adapter);
        $method = $refl->getMethod('determineGeneratorPoint');
        $method->setAccessible(true);
        $method->invokeArgs($adapter, ['shit']);
    }

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(ECDSAAdapter::class, ECDSAAdapter::create());
    }

    public function testCanSignGivenData()
    {
        $adapter = ECDSAAdapter::create();
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/secp256.pem');
        $hash = $adapter->createSigningHash('this is a text.', 'sha256');
        $pubSerializer = new DerPublicKeySerializer(
            $adapter->getMathAdapter()
        );
        $privSerializer = new PemPrivateKeySerializer(
            new DerPrivateKeySerializer($adapter->getMathAdapter(), $pubSerializer)
        );
        $priv = $privSerializer->parse($key->getContent());
        $sign = $adapter->sign($priv, $hash, 'sha256');
        $this->assertInternalType('string', $sign);
        $this->assertNotEmpty($sign);
    }

    public function testCanVerifySignOfGivenData()
    {
        $adapter = ECDSAAdapter::create();
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/secp256.pem');
        $privCert = \Gandung\JWT\__jwt_parseECDSAPrivateCert($key->getContent());
        $hash = $adapter->createSigningHash('this is a text.', 'sha256');
        $publicDerSerializer = new DerPublicKeySerializer($adapter->getMathAdapter());
        $pubSerializer = new PemPublicKeySerializer($publicDerSerializer);
        $privSerializer = new PemPrivateKeySerializer(
            new DerPrivateKeySerializer($adapter->getMathAdapter(), $publicDerSerializer)
        );
        $priv = $privSerializer->parse($privCert);
        $expectedSign = $adapter->sign($priv, $hash, 'sha256');
        $this->assertInternalType('string', $expectedSign);
        $this->assertNotEmpty($expectedSign);

        $key->setContentFromCertFile('cert/secp256.pub.pem');
        $pubCert = \Gandung\JWT\__jwt_parseECDSAPublicCert($key->getContent());
        $pub = $pubSerializer->parse($pubCert);
        $isSignMatched = $adapter->verify($expectedSign, $pub, $hash, 'sha256');
        $this->assertInternalType('boolean', $isSignMatched);
        $this->assertTrue($isSignMatched);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCanRaiseExceptionWhenDetermineGeneratorPointWithInvalidAlgorithm()
    {
        $this->callDetermineGeneratorPointDirectly();
    }
}
