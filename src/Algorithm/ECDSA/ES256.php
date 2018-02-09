<?php

namespace Gandung\JWT\Algorithm\ECDSA;

use Gandung\JWT\Algorithm\ECDSA as AbstractECDSA;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ES256 extends AbstractECDSA
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
        return \Gandung\JWT\Token\Algorithm::ES256;
    }
}
