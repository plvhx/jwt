<?php

namespace Gandung\JWT\TokenValidator;

use Gandung\JWT\ValidatorInterface;
use Gandung\JWT\Token\Claim;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ClaimHeader implements ValidatorInterface
{
    /**
     * For chainability purpose.
     */
    public static function create()
    {
        return new static;
    }
    
    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        return in_array($value, Claim::ALL, true);
    }
}
