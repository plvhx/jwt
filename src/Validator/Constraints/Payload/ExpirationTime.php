<?php

namespace Gandung\JWT\Validator\Constraints\Payload;

use Gandung\JWT\Validator\Constraints\BaseConstraint;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ExpirationTime extends BaseConstraint
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return \Gandung\JWT\Token\Claim::EXPIRATION_TIME;
    }
}
