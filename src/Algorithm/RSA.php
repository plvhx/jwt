<?php

namespace Gandung\JWT\Algorithm;

use Gandung\JWT\SignerInterface;
use Gandung\JWT\Manager\KeyManagerInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
abstract class RSA implements SignerInterface
{
    /**
     * {@inheritdoc}
     */
    public function sign($payload, KeyManagerInterface $key)
    {
        $priv = \openssl_get_privatekey(
            $key->getContent(),
            $key->getPassphrase()
        );

        if (false === $priv) {
            throw new \RuntimeException(
                sprintf("Error: %s\n", \openssl_error_string())
            );
        }

        \openssl_sign($payload, $signature, $priv, $this->getAlgorithm());

        return $signature;
    }

    /**
     * {@inheritdoc}
     */
    public function verify($expected, $payload, KeyManagerInterface $key)
    {
        $pub = $this->extractPublicKeyFromPrivateKeyFile($key);

        return \openssl_verify($payload, $expected, $pub, $this->getAlgorithm()) === 1;
    }

    /**
     * Extract public key from private key file.
     *
     * @param string $key
     */
    private function extractPublicKeyFromPrivateKeyFile(KeyManagerInterface $key)
    {
        $priv = \openssl_get_privatekey(
            $key->getContent(),
            $key->getPassphrase()
        );

        if (false === $priv) {
            throw new \RuntimeException(
                sprintf("Failed to get private key object: %s\n", \openssl_error_string())
            );
        }

        $details = \openssl_pkey_get_details($priv);

        return $details['key'];
    }
}
