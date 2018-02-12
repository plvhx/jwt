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
    public function getIssuedBy();

    /**
     * Get "sub" claim.
     *
     * @return string
     */
    public function getRelatedTo();

    /**
     * Get "aud" claim.
     *
     * @return string
     */
    public function getIntendedFor();

    /**
     * Get "exp" claim.
     *
     * @return \DateTimeInterface
     */
    public function getExpireAt();

    /**
     * Get "nbf" claim.
     *
     * @return \DateTimeInterface
     */
    public function getCanOnlyBeUsedAfter();

    /**
     * Get "iat" claim.
     *
     * @return \DateTimeInterface
     */
    public function getIssuedAt();

    /**
     * Get "jti" claim.
     *
     * @return string
     */
    public function GetIdentifiedBy();
}
