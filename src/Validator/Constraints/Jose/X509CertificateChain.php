<?php

namespace Gandung\JWT\Validator\Constraints\Jose;

use Gandung\JWT\Validator\Constraints\BaseConstraint;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class X509CertificateChain extends BaseConstraint
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return \Gandung\JWT\Token\Jose::X509_CERTIFICATE_CHAIN;
    }
}
