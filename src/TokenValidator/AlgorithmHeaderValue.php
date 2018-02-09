<?php

namespace Gandung\JWT\TokenValidator;

use Gandung\JWT\ValidatorInterface;
use Gandung\JWT\Token\Algorithm;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class AlgorithmHeaderValue implements ValidatorInterface
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
        return in_array($value, Algorithm::ALL, true);
    }
}
