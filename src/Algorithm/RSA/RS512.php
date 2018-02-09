<?php

namespace Gandung\JWT\Algorithm\RSA;

use Gandung\JWT\Algorithm\RSA as AbstractRSA;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class RS512 extends AbstractRSA
{
    /**
     * {@inheritdoc}
     */
    public function getAlgorithm()
    {
        return \OPENSSL_ALGO_SHA512;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithmAlias()
    {
        return \Gandung\JWT\Token\Algorithm::RS512;
    }
}
