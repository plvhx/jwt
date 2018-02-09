<?php

namespace Gandung\JWT\Algorithm\ECDSA;

use Gandung\JWT\Algorithm\ECDSA as AbstractECDSA;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ES384 extends AbstractECDSA
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
        return \Gandung\JWT\Token\Algorithm::ES384;
    }
}
