<?php

namespace Gandung\JWT;

use Gandung\JWT\JWT;
use Gandung\JWT\Manager\KeyManagerInterface;
use Gandung\JWT\Token\JoseBuilderInterface;
use Gandung\JWT\Token\ClaimBuilderInterface;
use Gandung\JWT\Token\PayloadBuilderInterface;

class JWTFactory
{
    /**
     * Get JWT instance.
     *
     * @return JWT
     */
    public static function getJwt()
    {
        return JWT::create();
    }

    /**
     * Get JoseBuilder instance.
     *
     * @return JoseBuilderInterface
     */
    public static function getJoseBuilder()
    {
        return new \Gandung\JWT\Token\JoseBuilder;
    }

    /**
     * Get ClaimBuilder instance.
     *
     * @return ClaimBuilderInterface
     */
    public static function getClaimBuilder()
    {
        return new \Gandung\JWT\Token\ClaimBuilder;
    }

    /**
     * Get PayloadBuilder instance.
     *
     * @return PayloadBuilderInterface
     */
    public static function getPayloadBuilder()
    {
        return new \Gandung\JWT\Token\PayloadBuilder;
    }

    /**
     * Get KeyManager instance.
     *
     * @return KeyManagerInterface
     */
    public static function getKeyManager()
    {
        return new \Gandung\JWT\Manager\KeyManager;
    }
}
