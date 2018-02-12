<?php

namespace Gandung\JWT\Accessor;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface AccessorInterface
{
    /**
     * Get given JWT portion.
     *
     * @return array
     */
    public function get();
}
