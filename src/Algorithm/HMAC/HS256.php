<?php

namespace Gandung\JWT\Algorithm\HMAC;

use Gandung\JWT\Algorithm\HMAC as AbstractHMAC;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class HS256 extends AbstractHMAC
{
    /**
     * {@inheritdoc}
     */
    public function getAlgorithm()
    {
        return 'sha256';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithmAlias()
    {
        return \Gandung\JWT\Token\Algorithm::HS256;
    }
}
