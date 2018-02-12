<?php

namespace Gandung\JWT\Tests\Accessor;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Accessor\PayloadAccessor;
use Gandung\JWT\Token\PayloadBuilderInterface;
use Gandung\JWT\JWTFactory;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class PayloadAccessorTest extends TestCase
{
    /**
     * @var
     */
    private $payload;

    public function __construct()
    {
        parent::__construct();
        $claim = JWTFactory::getClaimBuilder()
            ->issuedBy('me')
            ->expireAt(new \DateTimeImmutable('@' . (time() + 3600)));
        $this->payload = JWTFactory::getPayloadBuilder()
            ->claim($claim)
            ->userData([
                'credentials' => [
                    'username' => 'me',
                    'password' => 'this_is_only_me_will_know'
                ]
            ]);
    }

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(PayloadAccessor::class, new PayloadAccessor($this->payload->getValue()));
    }

    public function testCanGetIssuedByDirective()
    {
        $accessor = new PayloadAccessor($this->payload->getValue());
        $this->assertInternalType('string', $accessor->getIssuedBy());
        $this->assertEquals('me', $accessor->getIssuedBy());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanGetRelatedToDirective()
    {
        $accessor = new PayloadAccessor($this->payload->getValue());
        $this->assertInternalType('string', $accessor->getRelatedTo());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanGetIntendedForDirective()
    {
        $accessor = new PayloadAccessor($this->payload->getValue());
        $this->assertInternalType('string', $accessor->getIntendedFor());
    }

    public function testCanGetExpireAtDirective()
    {
        $accessor = new PayloadAccessor($this->payload->getValue());
        $this->assertInstanceOf(\DateTimeImmutable::class, $accessor->getExpireAt());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanGetCanOnlyBeUsedAfterDirective()
    {
        $accessor = new PayloadAccessor($this->payload->getValue());
        $this->assertInstanceOf(\DateTimeImmutable::class, $accessor->getCanOnlyBeUsedAfter());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanGetIssuedAtDirective()
    {
        $accessor = new PayloadAccessor($this->payload->getValue());
        $this->assertInstanceOf(\DateTimeImmutable::class, $accessor->getIssuedAt());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanGetIdentifiedByDirective()
    {
        $accessor = new PayloadAccessor($this->payload->getValue());
        $this->assertInstanceOf(\DateTimeImmutable::class, $accessor->getIdentifiedBy());
    }

    public function testCanGetAll()
    {
        $accessor = new PayloadAccessor($this->payload->getValue());
        $this->assertInternalType('array', $accessor->get());
        $this->assertNotEmpty($accessor->get());
    }
}
