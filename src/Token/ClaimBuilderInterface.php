<?php

namespace Gandung\JWT\Token;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface ClaimBuilderInterface extends \Gandung\JWT\BuilderInterface
{
    /**
     * See RFC 7519 Section 4 (4.1.1)
     *
     * @param string $issuer
     * @return void
     */
    public function issuedBy($issuer);

    /**
     * See RFC 7519 Section 4 (4.1.2)
     *
     * @param string $subject
     * @return void
     */
    public function relatedTo($subject);

    /**
     * See RFC 7519 Section 4 (4.1.3)
     *
     * @param string $audience
     * @return void
     */
    public function intendedFor($audience);

    /**
     * See RFC 7519 Section 4 (4.1.4)
     *
     * @param \DateTimeImmutable $expire
     * @return void
     */
    public function expireAt(\DateTimeImmutable $expire);

    /**
     * See RFC 7519 Section 4 (4.1.5)
     *
     * @param \DateTimeImmutable $notBefore
     * @return void
     */
    public function canOnlyBeUsedAfter(\DateTimeImmutable $notBefore);

    /**
     * See RFC Section 4 (4.1.6)
     *
     * @param \DateTimeImmutable $issuedAt
     * @return void
     */
    public function issuedAt(\DateTimeImmutable $issuedAt);

    /**
     * See RFC Section 4 (4.1.7)
     *
     * @param string $id
     * @return void
     */
    public function identifiedBy($id);
}
