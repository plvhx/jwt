<?php

namespace Gandung\JWT\Tests\Algorithm\HMAC;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Algorithm\HMAC\HS384;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class HS384Test extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(HS384::class, new HS384);
    }

    public function testCanGetAlgorithm()
    {
        $hs384 = new HS384;
        $this->assertEquals('sha384', $hs384->getAlgorithm());
    }

    public function testCanGetAlgorithmAlias()
    {
        $hs384 = new HS384;
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::HS384, $hs384->getAlgorithmAlias());
    }
}
