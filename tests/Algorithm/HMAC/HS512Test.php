<?php

namespace Gandung\JWT\Tests\Algorithm\HMAC;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Algorithm\HMAC\HS512;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class HS512Test extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(HS512::class, new HS512);
    }

    public function testCanGetAlgorithm()
    {
        $hs512 = new HS512;
        $this->assertEquals('sha512', $hs512->getAlgorithm());
    }

    public function testCanGetAlgorithmAlias()
    {
        $hs512 = new HS512;
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::HS512, $hs512->getAlgorithmAlias());
    }
}
