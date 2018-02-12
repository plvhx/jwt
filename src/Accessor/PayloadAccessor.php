<?php

namespace Gandung\JWT\Accessor;

use Gandung\JWT\Validator\Validator;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class PayloadAccessor implements PayloadAccessorInterface
{
    /**
     * @var array
     */
    private $payload;

    /**
     * @var \Gandung\JWT\ValidatorInterface
     */
    private $validator;

    public function __construct($payload)
    {
        $this->payload = $payload;
        $this->configureValidator();
    }

    /**
     * {@inheritdoc}
     */
    public function getIssuedBy(): string
    {
        $this->validator->validateFromArray(
            $this->payload,
            new \Gandung\JWT\Validator\Constraints\Payload\IssuedBy
        );

        return $this->payload[\Gandung\JWT\Token\Claim::ISSUER];
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedTo(): string
    {
        $this->validator->validateFromArray(
            $this->payload,
            new \Gandung\JWT\Validator\Constraints\Payload\RelatedTo
        );

        return $this->payload[\Gandung\JWT\Token\Claim::SUBJECT];
    }

    /**
     * {@inheritdoc}
     */
    public function getIntendedFor(): string
    {
        $this->validator->validateFromArray(
            $this->payload,
            new \Gandung\JWT\Validator\Constraints\Payload\IntendedFor
        );

        return $this->payload[\Gandung\JWT\Token\Claim::AUDIENCE];
    }

    /**
     * {@inheritdoc}
     */
    public function getExpireAt(): \DateTimeInterface
    {
        $this->validator->validateFromArray(
            $this->payload,
            new \Gandung\JWT\Validator\Constraints\Payload\ExpirationTime
        );

        $exp = $this->payload[\Gandung\JWT\Token\Claim::EXPIRATION_TIME];

        return !($exp instanceof \DateTimeImmutable) && is_int($exp)
            ? new \DateTimeImmutable('@' . (string)$exp)
            : $exp;
    }

    /**
     * {@inheritdoc}
     */
    public function getCanOnlyBeUsedAfter(): \DateTimeInterface
    {
        $this->validator->validateFromArray(
            $this->payload,
            new \Gandung\JWT\Validator\Constraints\Payload\NotBefore
        );

        $nbf = $this->payload[\Gandung\JWT\Token\Claim::NOT_BEFORE];

        return !($nbf instanceof \DateTimeImmutable) && is_int($nbf)
            ? new \DateTimeImmutable('@' . (string)$nbf)
            : $nbf;
    }

    /**
     * {@inheritdoc}
     */
    public function getIssuedAt(): \DateTimeInterface
    {
        $this->validator->validateFromArray(
            $this->payload,
            new \Gandung\JWT\Validator\Constraints\Payload\IssuedAt
        );

        $iat = $this->payload[\Gandung\JWT\Token\Claim::ISSUED_AT];

        return !($iat instanceof \DateTimeImmutable) && is_int($iat)
            ? new \DateTimeImmutable('@' . (string)$iat)
            : $iat;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifiedBy(): string
    {
        $this->validator->validateFromArray(
            $this->payload,
            new \Gandung\JWT\Validator\Constraints\Payload\JWTID
        );

        return $this->payload[\Gandung\JWT\Token\Claim::JWT_ID];
    }

    /**
     * {@inheritdoc}
     */
    public function get(): array
    {
        return $this->payload;
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
