<?php

namespace Gandung\JWT\Tests\Proxy;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Proxy\RSA;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class RSATest extends TestCase
{
    public function testCanGetInstanceForRS256()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\RSA\RS256::class,
            RSA::create()->getRS256()
        );
    }

    public function testCanGetInstanceForRS384()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\RSA\RS384::class,
            RSA::create()->getRS384()
        );
    }

    public function testCanGetInstanceForRS512()
    {
        $this->assertInstanceOf(
            \Gandung\JWT\Algorithm\RSA\RS512::class,
            RSA::create()->getRS512()
        );
    }
}
