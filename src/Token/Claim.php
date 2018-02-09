<?php

namespace Gandung\JWT\Token;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface Claim
{
    const ALL = [
        self::ISSUER,
        self::SUBJECT,
        self::AUDIENCE,
        self::EXPIRATION_TIME,
        self::NOT_BEFORE,
        self::ISSUED_AT,
        self::JWT_ID
    ];

    /**
     * RFC 7519 Section 4 (4.1.1): "iss" Issuer Claim
     * The "iss" (issuer) claim identifies the principal that issued the JWT.
     * The processing of this claim is generally application specific.
     * The "iss" value is a case-sensitive string containing a StringOrURI value.
     * Use of this claim is optional.
     */
    const ISSUER = "iss";

    /**
     * RFC 7519 Section 4 (4.1.2): "sub" Subject Claim
     * The "sub" (subject) claim identifies the principal that is the subject
     * of the JWT.
     */
    const SUBJECT = "sub";

    /**
     * RFC 7519 Section 4 (4.1.3): "aud" Audience Claim
     * The "aud" (audience) claim identifies the recipients that the JWT is
     * intended for.
     */
    const AUDIENCE = "aud";

    /**
     * RFC 7519 Section 4 (4.1.4): "exp" Expiration Time Claim
     * The "exp" (expiration time) claim identifies the expiration time on
     * or after which the JWT MUST NOT be accepted for processing.
     */
    const EXPIRATION_TIME = "exp";

    /**
     * RFC 7519 Section 4 (4.1.5): "nbf" Not Before Claim
     * The "nbf" (not before) claim identifies the time before which the JWT
     * MUST NOT be accepted for processing.
     */
    const NOT_BEFORE = "nbf";

    /**
     * RFC 7519 Section 4 (4.1.6): "iat" Issued At Claim
     * The "iat" (issued at) claim identifies the time at which the JWT was
     * issued.
     */
    const ISSUED_AT = "iat";

    /**
     * RFC 7519 Section 4 (4.1.7): "jti" JWT ID Claim
     * The "jti" claim provides a unique identifier for the JWT.
     */
    const JWT_ID = "jti";
}
