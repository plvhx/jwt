<?php

namespace Gandung\JWT;

use Gandung\JWT\Manager\KeyManagerInterface;
use Gandung\JWT\Token\JoseBuilderInterface;
use Gandung\JWT\Token\PayloadBuilderInterface;
use Gandung\JWT\Proxy\HMAC;
use Gandung\JWT\Proxy\RSA;
use Gandung\JWT\Proxy\ECDSA;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class JWT
{
    /**
     * @var array
     */
    private $algo = [];

    /**
     * @var array
     */
    private $proxy;

    public function __construct()
    {
        $this->proxy = [
            'hmac' => HMAC::create(),
            'rsa' => RSA::create(),
            'ecdsa' => ECDSA::create()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function createToken(
        JoseBuilderInterface $jose,
        PayloadBuilderInterface $payload,
        KeyManagerInterface $key
    ) {
        $portion = [];

        $portion[] = $jose->getValue();
        $portion[] = $payload->getValue();
        $currentAlgo = $portion[0]['alg'];

        $this->determineSigningAlgorithm($currentAlgo);
        $this->validateKey($key, $currentAlgo);

        $portion = join('.', \array_map(function ($q) {
            return \Gandung\JWT\__jwt_base64UrlEncode(
                \json_encode(
                    $q,
                    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                )
            );
        }, $portion));

        $signature = $this->algo[$currentAlgo]->sign($portion, $key);

        return $portion . '.' . \Gandung\JWT\__jwt_base64UrlEncode($signature);
    }

    /**
     * {@inheritdoc}
     */
    public function verifyToken(
        $expected,
        JoseBuilderInterface $jose,
        PayloadBuilderInterface $payload,
        KeyManagerInterface $key
    ) {
        $portion = [];
        $portion[] = $jose->getValue();
        $portion[] = $payload->getValue();
        $signature = \Gandung\JWT\__jwt_base64UrlDecode(
            explode('.', $expected)[2]
        );
        $currentAlgo = $portion[0]['alg'];

        $this->determineSigningAlgorithm($currentAlgo);

        $portion = join('.', \array_map(function ($q) {
            return \Gandung\JWT\__jwt_base64UrlEncode(
                \json_encode(
                    $q,
                    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                )
            );
        }, $portion));

        return $this->algo[$currentAlgo]->verify(
            $signature,
            $portion,
            $key
        );
    }

    private function determineSigningAlgorithm($algorithm)
    {
        if (!isset($this->algo[$algorithm])) {
            if ($algorithm[0] === 'H') {
                $this->algo[$algorithm] = \call_user_func([$this->proxy['hmac'], 'get' . $algorithm]);
            } elseif ($algorithm[0] === 'R') {
                $this->algo[$algorithm] = \call_user_func([$this->proxy['rsa'], 'get' . $algorithm]);
            } elseif ($algorithm[0] === 'E') {
                $this->algo[$algorithm] = \call_user_func([$this->proxy['ecdsa'], 'get' . $algorithm]);
            }
        }
    }

    private function validateKey(KeyManagerInterface $key, $algorithm)
    {
        $header = [
            'R' => ['BEGIN PRIVATE KEY', 'BEGIN ENCRYPTED PRIVATE KEY'],
            'E' => 'BEGIN EC PRIVATE KEY'
        ];

        if ($algorithm[0] === 'H') {
            return;
        }

        $content = $key->getContent();

        if (is_array($header[$algorithm[0]])) {
            foreach ($header[$algorithm[0]] as $h) {
                $isHeaderMatched = strpos($content, $h) === false
                    ? false
                    : true;

                if ($isHeaderMatched) {
                    break;
                }
            }
        } else {
            $isHeaderMatched = strpos($content, $header[$algorithm[0]]) === false
                ? false
                : true;
        }

        if ($algorithm[0] === 'R' || $algorithm[0] === 'E') {
            if (false === $isHeaderMatched) {
                throw new \InvalidArgumentException(
                    "PEM certificate must provided in RSA or ECDSA signing mode."
                );
            }
        }
    }
}
