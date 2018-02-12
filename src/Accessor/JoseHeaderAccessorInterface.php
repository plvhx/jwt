<?php

namespace Gandung\JWT\Accessor;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface JoseHeaderAccessorInterface extends AccessorInterface
{
    /**
     * Get algorithm.
     *
     * @return string
     */
    public function getAlgorithm();

    /**
     * Get JWK set url.
     *
     * @return string
     */
    public function getJwkSetUrl();

    /**
     * Get key ID.
     *
     * @return string
     */
    public function getKeyID();

    /**
     * Get X509 url.
     *
     * @return string
     */
    public function getX509Url();

    /**
     * Get type.
     *
     * @return string
     */
    public function getType();

    /**
     * Get content type.
     *
     * @return string
     */
    public function getContentType();
}
