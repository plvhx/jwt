<?php

namespace Gandung\JWT\Token;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface Jose
{
    const ALL = [
        self::ALGORITHM,
        self::JWK_SET_URL,
        self::JSON_WEB_KEY,
        self::KEY_ID,
        self::X509_URL,
        self::X509_CERTIFICATE_CHAIN,
        self::TYPE,
        self::CONTENT_TYPE
    ];

    /**
     * RFC 7515 Section 4 (4.1.1) "alg" Algorithm Header Paramter
     * The "alg" (algorithm) header parameter identifies the cryptographic
     * algorithm used to secure the JWS
     */
    const ALGORITHM = "alg";

    /**
     * RFC 7515 Section 4 (4.1.2) "jku" (JWK Set URL) Header Parameter
     * The "jku" (JWK Set URL) header parameter is a URI that refers
     * to a resource for a set of JSON-encoded public keys, one of which
     * corresponds to the key used to digitally sign the JWS.
     */
    const JWK_SET_URL = "jku";

    /**
     * RFC 7515 Section 4 (4.1.3) "jwk" (JSON Web Key) Header Parameter
     * The "jwk" (JSON Web Key) header parameter is the public key that corresponds
     * to the key used to digitally sign the JWS.
     */
    const JSON_WEB_KEY = "jwk";

    /**
     * RFC 7515 Section 4 (4.1.4) "kid" (Key ID) Header Parameter
     * The "kid" (key ID) header parameter is a hint indicating which key
     * was used to secure the JWS.
     */
    const KEY_ID = "kid";

    /**
     * RFC 7515 Section 4 (4.1.5) "x5u" (X.509 URL) Header Parameter
     * The "x5u" (X.509 URL) header parameter is a URI that refers to a
     * resource for the X.509 public key certificate or certificate chain
     * corresponding to the key used to digitally sign the JWS.
     */
    const X509_URL = "x5u";

    /**
     * RFC 7515 Section 4 (4.1.6) "x5c" (X509 Certificate Chain) Header Parameter
     * The "x5c" (X.509 certificate chain) header parameter contains the X.509 public key
     * certificate or certificate chain corresponding to the key used to digitally sign
     * the JWS.
     */
    const X509_CERTIFICATE_CHAIN = "x5c";

    /**
     * RFC 7515 Section 4 (4.1.9) "typ" (Type) Header Parameter
     * The "typ" header parameter is used by JWS applications to declare the media type
     * of this complete JWS.
     */
    const TYPE = "typ";

    /**
     * RFC 7515 Section 4 (4.1.10) "cty" (Content Type) Header Parameter
     * The "cty" (content type) header parameter is used by JWS applications
     * to declare the media type of the secured content (the payload).
     */
    const CONTENT_TYPE = "cty";
}
