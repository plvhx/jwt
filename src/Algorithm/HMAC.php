<?php

namespace Gandung\JWT\Algorithm;

use Gandung\JWT\SignerInterface;
use Gandung\JWT\Manager\KeyManagerInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
abstract class HMAC implements SignerInterface
{
   
    /**
     * {@inheritdoc}
     */
    public function sign($payload, KeyManagerInterface $key)
    {
        return \hash_hmac($this->getAlgorithm(), $payload, $key->getPassphrase(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function verify($expected, $payload, KeyManagerInterface $key)
    {
        return \hash_equals($expected, $this->sign($payload, $key));
    }
}
