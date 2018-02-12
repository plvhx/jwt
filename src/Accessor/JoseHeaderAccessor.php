<?php

namespace Gandung\JWT\Accessor;

use Gandung\JWT\Validator\Validator;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class JoseHeaderAccessor implements JoseHeaderAccessorInterface
{
    /**
     * @var array
     */
    private $jose;

    /**
     * @var \Gandung\JWT\ValidatorInterface
     */
    private $validator;

    public function __construct($header)
    {
        $this->jose = $header;
        $this->configureValidator();
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm(): string
    {
        $this->validator->validateFromArray(
            $this->jose,
            new \Gandung\JWT\Validator\Constraints\Jose\Algorithm
        );

        return $this->jose[\Gandung\JWT\Token\Jose::ALGORITHM];
    }

    /**
     * {@inheritdoc}
     */
    public function getJwkSetUrl(): string
    {
        $this->validator->validateFromArray(
            $this->jose,
            new \Gandung\JWT\Validator\Constraints\Jose\JWKSetUrl
        );

        return $this->jose[\Gandung\JWT\Token\Jose::JWK_SET_URL];
    }

    /**
     * {@inheritdoc}
     */
    public function getJsonWebKey(): string
    {
        $this->validator->validateFromArray(
            $this->jose,
            new \Gandung\JWT\Validator\Constraints\Jose\JsonWebKey
        );

        return $this->jose[\Gandung\JWT\Token\Jose::JSON_WEB_KEY];
    }

    /**
     * {@inheritdoc}
     */
    public function getKeyID(): string
    {
        $this->validator->validateFromArray(
            $this->jose,
            new \Gandung\JWT\Validator\Constraints\Jose\KeyID
        );

        return $this->jose[\Gandung\JWT\Token\Jose::KEY_ID];
    }

    /**
     * {@inheritdoc}
     */
    public function getX509Url(): string
    {
        $this->validator->validateFromArray(
            $this->jose,
            new \Gandung\JWT\Validator\Constraints\Jose\X509Url
        );

        return $this->jose[\Gandung\JWT\Token\Jose::X509_URL];
    }

    /**
     * {@inheritdoc}
     */
    public function getX509CertificateChain(): string
    {
        $this->validator->validateFromArray(
            $this->jose,
            new \Gandung\JWT\Validator\Constraints\Jose\X509CertificateChain
        );

        return $this->jose[\Gandung\JWT\Token\Jose::X509_CERTIFICATE_CHAIN];
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        $this->validator->validateFromArray(
            $this->jose,
            new \Gandung\JWT\Validator\Constraints\Jose\Type
        );

        return $this->jose[\Gandung\JWT\Token\Jose::TYPE];
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType(): string
    {
        $this->validator->validateFromArray(
            $this->jose,
            new \Gandung\JWT\Validator\Constraints\Jose\ContentType
        );

        return $this->jose[\Gandung\JWT\Token\Jose::CONTENT_TYPE];
    }

    /**
     * {@inheritdoc}
     */
    public function get(): array
    {
        return $this->jose;
    }

    /**
     * Configure validator object.
     *
     * @param array $constraints
     * @return void
     */
    private function configureValidator($constraints = [])
    {
        $this->validator = new Validator;

        foreach ($constraints as $v) {
            $this->validator->addConstraint($v);
        }
    }
}
