<?php

namespace Gandung\JWT\Adapter;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface ECDSAAdapterInterface
{
    /**
     * Wrapper for creating signing hash based on given private key.
     *
     * @param PrivateKeyInterface $key
     * @param \GMP $hash
     * @param string $algorithm
     * @return string
     */
    public function sign(PrivateKeyInterface $key, \GMP $hash, $algorithm);

    /**
     * Wrapper for verifying newly created signing hash with current
     * signing hash.
     *
     * @param string $expected
     * @param PublicKeyInterface $key
     * @param \GMP $hash
     * @param string $algorithm
     * @return boolean
     */
    public function verify($expected, PublicKeyInterface $key, \GMP $hash, $algorithm);

    /**
     * Wrapper for creating signing hash object.
     *
     * @param string $payload
     * @param string $algorithm
     * @return object
     */
    public function createSigningHash($payload, $algorithm);

    /**
     * Get GMP math adapter.
     *
     * @return GmpMathInterface
     */
    public function getMathAdapter();
}
