<?php

namespace Gandung\JWT;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface AlgorithmInterface
{
    /**
     * Get available algorithm based on implementation.
     *
     * @return mixed
     */
    public function getAlgorithm();

    /**
     * Get available algorithm alias for JWS (JSON Web Signature)
     *
     * Reference: RFC 7518 Section 3 (3.1) "alg" (Algorithm)
     * Header Parameter Values for JWS
     *
     * @return string
     */
    public function getAlgorithmAlias();
}
