<?php

namespace Gandung\JWT\Algorithm;

use Gandung\JWT\Adapter\ECDSAAdapterInterface;
use Gandung\JWT\SignerInterface;
use Gandung\JWT\Manager\KeyManagerInterface;
use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\PemPublicKeySerializer;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
abstract class ECDSA implements SignerInterface
{
    /**
     * @var ECDSAAdapterInterface
     */
    private $adapter;

    /**
     * @var $private
     */
    private $private;

    /**
     * @var $public
     */
    private $public;

    public function __construct(ECDSAAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $publicDer = new DerPublicKeySerializer($this->adapter->getMathAdapter());
        $this->public = new PemPublicKeySerializer($publicDer);
        $this->private = new PemPrivateKeySerializer(
            new DerPrivateKeySerializer($this->adapter->getMathAdapter(), $publicDer)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function sign($payload, KeyManagerInterface $key)
    {
        return $this->adapter->sign(
            $this->getPrivateKey($key),
            $this->adapter->createSigningHash($payload, $this->getAlgorithm()),
            $this->getAlgorithm()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function verify($expected, $payload, KeyManagerInterface $key)
    {
        return $this->adapter->verify(
            $expected,
            $this->getPublicKey($key),
            $this->adapter->createSigningHash($payload, $this->getAlgorithm()),
            $this->getAlgorithm()
        );
    }

    /**
     * Get private key object from given certificate.
     *
     * @param string $key
     * @return PrivateKeyInterface
     */
    public function getPrivateKey(KeyManagerInterface $key)
    {
        return $this->private->parse($key->getContent());
    }

    /**
     * Get public key object from given certificate.
     *
     * @param string $key
     * @return PublicKeyInterface
     */
    public function getPublicKey(KeyManagerInterface $key)
    {
        return $this->public->parse($key->getContent());
    }
}
