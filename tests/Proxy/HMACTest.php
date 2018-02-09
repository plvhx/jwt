<?php

namespace Gandung\JWT\Tests\Proxy;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Proxy\HMAC;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class HMACTest extends TestCase
{
    public function testCanGetInstanceForHS256()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\HMAC\HS256::class,
            HMAC::create()->getHS256()
        );
    }

    public function testCanGetInstanceForHS384()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\HMAC\HS384::class,
            HMAC::create()->getHS384()
        );
    }

    public function testCanGetInstanceForHS512()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\HMAC\HS512::class,
            HMAC::create()->getHS512()
        );
    }
}
