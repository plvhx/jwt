<?php

namespace Gandung\JWT\Tests\Proxy;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Proxy\ECDSA;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ECDSATest extends TestCase
{
    public function testCanGetInstanceForES256()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\ECDSA\ES256::class,
            ECDSA::create()->getES256()
        );
    }

    public function testCanGetInstanceForES384()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\ECDSA\ES384::class,
            ECDSA::create()->getES384()
        );
    }

    public function testCanGetInstanceForES512()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\ECDSA\ES512::class,
            ECDSA::create()->getES512()
        );
    }
}
