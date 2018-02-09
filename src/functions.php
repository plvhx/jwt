<?php

namespace Gandung\JWT;

use Gandung\JWT\Token\ClaimBuilderInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */

if (!function_exists('__jwt_base64UrlEncode')) {
    /**
     * @ref RFC 7515 Appendix C: Notes on implementing base64url without padding.
     * @desc Encode given data using base64 url
     *
     * @param string $buf
     * @return string
     */
    function __jwt_base64UrlEncode($buf)
    {
        return \str_replace('=', '', \strtr(\base64_encode($buf), '+/', '-_'));
    }
}

if (!function_exists('__jwt_base64UrlDecode')) {
    /**
     * @ref RFC 7515 Appendix C: Notes on implementing base64url without padding.
     * @desc Decode given data using base64 url
     *
     * @param string $buf
     * @return array
     */
    function __jwt_base64UrlDecode($buf)
    {
        $repl = strtr($buf, '-_', '+/');

        /**
         * If length is not divisible by 4, then pad with trailing '='
         */
        if ($rem = \strlen($repl) % 4) {
            $repl .= \str_repeat('=', 4 - $rem);
        }

        return \base64_decode(\strtr($repl, '-_', '+/'));
    }
}

if (!function_exists("__jwt_mergePayload")) {
    /*
	 * Merge populated claim with given payload data.
	 *
	 * @param ClaimBuilderInterface $claim
	 * @param array $q
	 * @return array
	 */
    function __jwt_mergePayload(ClaimBuilderInterface $claim, $q)
    {
        return \array_merge_recursive($claim->getValue(), $q);
    }
}

if (!function_exists("__jwt_parseCert")) {
    function __jwt_parseCert($cert, $certHeader, $certFooter)
    {
        $pattern = '/' .
            '(\-{5}' . $certHeader . '\-{5})(.*)(\-{5}' . $certFooter . '\-{5})' .
            '/';

        preg_match(
            $pattern,
            str_replace(["\n", "\r", PHP_EOL], '', $cert),
            $matches
        );

        return $matches[2];
    }
}

if (!function_exists("__jwt_parseECDSAPublicCert")) {
    function __jwt_parseECDSAPublicCert($cert)
    {
        return __jwt_parseCert($cert, 'BEGIN PUBLIC KEY', 'END PUBLIC KEY');
    }
}

if (!function_exists("__jwt_parseECDSAPrivateCert")) {
    function __jwt_parseECDSAPrivateCert($cert)
    {
        return __jwt_parseCert($cert, 'BEGIN EC PRIVATE KEY', 'END EC PRIVATE KEY');
    }
}
