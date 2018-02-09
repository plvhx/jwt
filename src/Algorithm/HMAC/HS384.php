<?php

namespace Gandung\JWT\Algorithm\HMAC;

use Gandung\JWT\Algorithm\HMAC as AbstractHMAC;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class HS384 extends AbstractHMAC
{
    /**
     * {@inheritdoc}
     */
    public function getAlgorithm()
    {
        return 'sha384';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithmAlias()
    {
        return \Gandung\JWT\Token\Algorithm::HS384;
    }
}
