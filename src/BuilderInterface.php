<?php

namespace Gandung\JWT;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface BuilderInterface
{
    /**
     * Get the current builder value.
     *
     * @return array
     */
    public function getValue();
}
