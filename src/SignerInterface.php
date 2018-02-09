<?php

namespace Gandung\JWT;

use Gandung\JWT\Manager\KeyManagerInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface SignerInterface extends AlgorithmInterface
{
    /**
     * Generate the hash of the given payload.
     *
     * @param string|array $payload
     * @param string $key
     * @return string
     */
    public function sign($payload, KeyManagerInterface $key);

    /**
     * Compare the expected hash with newly generated hash from
     * given payload and key.
     *
     * @param string $expected
     * @param string|array $payload
     * @return boolean
     */
    public function verify($expected, $payload, KeyManagerInterface $key);
}
