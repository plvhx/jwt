<?php

namespace Gandung\JWT\Accessor;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface PayloadAccessorInterface extends AccessorInterface
{
    /**
     * Get "iss" claim.
     *
     * @return string
     */
    public function getIssuedBy(): string;

    /**
     * Get "sub" claim.
     *
     * @return string
     */
    public function getRelatedTo(): string;

    /**
     * Get "aud" claim.
     *
     * @return string
     */
    public function getIntendedFor(): string;

    /**
     * Get "exp" claim.
     *
     * @return \DateTimeInterface
     */
    public function getExpireAt(): \DateTimeInterface;

    /**
     * Get "nbf" claim.
     *
     * @return \DateTimeInterface
     */
    public function getCanOnlyBeUsedAfter(): \DateTimeInterface;

    /**
     * Get "iat" claim.
     *
     * @return \DateTimeInterface
     */
    public function getIssuedAt(): \DateTimeInterface;

    /**
     * Get "jti" claim.
     *
     * @return string
     */
    public function getIdentifiedBy(): string;
}
