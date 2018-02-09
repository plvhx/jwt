<?php

namespace Gandung\JWT;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface ValidatorInterface
{
    /**
     * Validate the given value.
     *
     * @param mixed $value
     */
    public function validate($value);
}
