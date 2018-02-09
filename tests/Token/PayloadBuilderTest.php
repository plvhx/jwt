<?php

namespace Gandung\JWT\Tests\Token;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Token\ClaimBuilder;
use Gandung\JWT\Token\PayloadBuilder;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class PayloadBuilderTest extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(PayloadBuilder::class, new PayloadBuilder(new ClaimBuilder));
    }

    public function testCanBuildJWTPayloadAndGetItAfterwards()
    {
        $claim = (new ClaimBuilder)
            ->issuedBy('me')
            ->expireAt(new \DateTimeImmutable('@' . (time() + (3600 * 3))));
        $payload = (new PayloadBuilder)
            ->claim($claim)
            ->userData([
                'credentials' => [
                    'username' => 'me',
                    'password' => md5('me')
                ]
            ]);
        $data = $payload->getValue();
        $this->assertInternalType('array', $data);
        $this->assertNotEmpty($data);
    }
}
