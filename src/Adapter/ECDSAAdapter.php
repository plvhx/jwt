<?php

namespace Gandung\JWT\Adapter;

use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\Math\GmpMathInterface;
use Mdanter\Ecc\Crypto\Signature\Signer;
use Mdanter\Ecc\Curves\NistCurve;
use Mdanter\Ecc\Random\RandomGeneratorFactory;
use Mdanter\Ecc\Random\RandomNumberGeneratorInterface;
use Mdanter\Ecc\Crypto\Signature\Signature;
use Mdanter\Ecc\Crypto\Signature\SignatureInterface;
use Mdanter\Ecc\Crypto\Signature\SignHasher;
use Mdanter\Ecc\Primitives\GeneratorPoint;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ECDSAAdapter implements ECDSAAdapterInterface
{
    /**
     * @var GmpMathInterface
     */
    private $adapter;

    /**
     * @var Signer
     */
    private $signer;

    /**
     * @var NistCurves
     */
    private $curve;

    /**
     * @var RandomGeneratorInterface
     */
    private $random;

    /**
     * Signature hash length hashmap.
     */
    private const SIGNATURE_LENGTH = [
        'sha256' => 64,
        'sha384' => 96,
        'sha512' => 132
    ];

    /**
     * Generator point hashmap.
     */
    private const GENERATOR_POINTS = [
        'sha256' => 'generator256',
        'sha384' => 'generator384',
        'sha512' => 'generator521'
    ];

    public function __construct(
        GmpMathInterface $adapter
    ) {
        $this->adapter = $adapter;
        $this->signer = EccFactory::getSigner($this->adapter);
        $this->curve = EccFactory::getNistCurves($this->adapter);
        $this->random = RandomGeneratorFactory::getRandomGenerator();
    }

    /**
     * For chainability purpose.
     */
    public static function create()
    {
        return new static(
            EccFactory::getAdapter()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function sign(
        PrivateKeyInterface $key,
        \GMP $hash,
        $algorithm
    ) {
        $signature = $this->signer->sign(
            $key,
            $hash,
            $this->random->generate($key->getPoint()->getOrder())
        );

        return \pack(
            'H*',
            \sprintf(
                "%s%s",
                $this->addSignaturePadding(
                    $signature->getR(),
                    self::SIGNATURE_LENGTH[$algorithm]
                ),
                $this->addSignaturePadding(
                    $signature->getS(),
                    self::SIGNATURE_LENGTH[$algorithm]
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function verify(
        $expected,
        PublicKeyInterface $key,
        \GMP $hash,
        $algorithm
    ) {
        return $this->signer->verify(
            $key,
            $this->parseExpectedSignature($expected, $algorithm),
            $hash
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createSigningHash($payload, $algorithm)
    {
        $hasher = new SignHasher($algorithm, $this->adapter);

        return $hasher->makeHash(
            $payload,
            $this->determineGeneratorPoint($algorithm)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getMathAdapter()
    {
        return $this->adapter;
    }

    /**
     * Parse previous generated signature.
     *
     * @param string $expected
     * @param string $algorithm
     * @return SignatureInterface
     */
    private function parseExpectedSignature($expected, $algorithm)
    {
        [$pointR, $pointS] = \str_split(
            \unpack('H*', $expected)[1],
            self::SIGNATURE_LENGTH[$algorithm]
        );

        return new Signature(
            \gmp_init($this->adapter->hexDec($pointR), 10),
            \gmp_init($this->adapter->hexDec($pointS), 10)
        );
    }

    /**
     * Append zero char into given ECDSA signature.
     *
     * @param \GMP $point
     * @param integer $length
     * @return string
     */
    private function addSignaturePadding(\GMP $point, $length)
    {
        return \str_pad($this->adapter->decHex((string)$point), $length, '0', \STR_PAD_LEFT);
    }

    /**
     * Determine ECDSA generator point based on given algorithm.
     *
     * @param string $algorithm
     * @return GeneratorPoint
     */
    private function determineGeneratorPoint($algorithm)
    {
        if (!array_key_exists($algorithm, self::GENERATOR_POINTS)) {
            throw new \InvalidArgumentException(
                "Invalid ECDSA hashing algorithm."
            );
        }

        return \call_user_func(
            [$this->curve, self::GENERATOR_POINTS[$algorithm]],
            $this->random
        );
    }
}
