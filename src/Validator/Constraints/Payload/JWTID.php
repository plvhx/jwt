<?php

namespace Gandung\JWT\Validator\Constraints\Payload;

use Gandung\JWT\Validator\Constraints\BaseConstraint;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class JWTID extends BaseConstraint
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return \Gandung\JWT\Token\Claim::JWT_ID;
    }
}
