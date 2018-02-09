<?php

namespace Gandung\JWT\Token;

use Gandung\JWT\BuilderInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface PayloadBuilderInterface extends BuilderInterface
{
    /**
     * Push JWT claim portion into payload stack.
     *
     * @param array $claim
     */
    public function claim(ClaimBuilderInterface $claim);

    /**
     * Push user supplied data into payload stack.
     *
     * @param array $data
     */
    public function userData($data);
}
