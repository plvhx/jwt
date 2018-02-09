<?php

namespace Gandung\JWT\TokenValidator;

use Gandung\JWT\ValidatorInterface;
use Gandung\JWT\Token\Jose;

class JoseHeader implements ValidatorInterface
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
        return in_array($value, Jose::ALL, true);
    }
}
