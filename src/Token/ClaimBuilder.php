<?php

namespace Gandung\JWT\Token;

use Gandung\JWT\Exception\ClaimTokenMismatchException;
use Gandung\JWT\TokenValidator\ClaimHeader;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ClaimBuilder implements ClaimBuilderInterface
{
    /**
     * @var array
     */
    private $claim = [];

    /**
     * {@inheritdoc}
     */
    public function issuedBy($issuer)
    {
        return $this->collectClaim(Claim::ISSUER, (string)$issuer);
    }

    /**
     * {@inheritdoc}
     */
    public function relatedTo($subject)
    {
        return $this->collectClaim(Claim::SUBJECT, $subject);
    }

    /**
     * {@inheritdoc}
     */
    public function intendedFor($audience)
    {
        return $this->collectClaim(Claim::AUDIENCE, $audience);
    }

    /**
     * {@inheritdoc}
     */
    public function expireAt(\DateTimeImmutable $expire)
    {
        return $this->collectClaim(Claim::EXPIRATION_TIME, $expire);
    }

    /**
     * {@inheritdoc}
     */
    public function canOnlyBeUsedAfter(\DateTimeImmutable $notBefore)
    {
        return $this->collectClaim(Claim::NOT_BEFORE, $notBefore);
    }

    /**
     * {@inheritdoc}
     */
    public function issuedAt(\DateTimeImmutable $issuedAt)
    {
        return $this->collectClaim(Claim::ISSUED_AT, $issuedAt);
    }

    /**
     * {@inheritdoc}
     */
    public function identifiedBy($id)
    {
        return $this->collectClaim(Claim::JWT_ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        if (isset($this->claim[Claim::EXPIRATION_TIME])) {
            $this->claim[Claim::EXPIRATION_TIME] = (int)$this->claim[Claim::EXPIRATION_TIME]->format('U');
        }

        if (isset($this->claim[Claim::NOT_BEFORE])) {
            $this->claim[Claim::NOT_BEFORE] = (int)$this->claim[Claim::NOT_BEFORE]->format('U');
        }

        if (isset($this->claim[Claim::ISSUED_AT])) {
            $this->claim[Claim::ISSUED_AT] = (int)$this->claim[Claim::ISSUED_AT]->format('U');
        }
        
        return $this->claim;
    }
    
    /**
     * Aggregate JWT claims list by pairing supplied claim into it's value.
     *
     * @param string $name
     * @param mixed $value
     * @return this
     */
    private function collectClaim($name, $value)
    {
        if (!ClaimHeader::create()->validate($name)) {
            throw new ClaimTokenMismatchException("Supply valid claim header name.");
        }
        
        $this->claim[$name] = $value;

        return $this;
    }
}
