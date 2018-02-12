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
    public function getAlgorithm(): string;

    /**
     * Get JWK set url.
     *
     * @return string
     */
    public function getJwkSetUrl(): string;

    /**
     * Get JSON web key.
     *
     * @return string
     */
    public function getJsonWebKey(): string;

    /**
     * Get key ID.
     *
     * @return string
     */
    public function getKeyID(): string;

    /**
     * Get X509 url.
     *
     * @return string
     */
    public function getX509Url(): string;

    /**
     * Get X509 certificate chain.
     *
     * @return string
     */
    public function getX509CertificateChain(): string;
    
    /**
     * Get type.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get content type.
     *
     * @return string
     */
    public function getContentType(): string;
}
