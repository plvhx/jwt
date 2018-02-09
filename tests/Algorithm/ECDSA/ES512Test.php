<?php

namespace Gandung\JWT\Tests\Algorithm\ECDSA;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Adapter\ECDSAAdapter;
use Gandung\JWT\Algorithm\ECDSA\ES512;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ES512Test extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(ES512::class, new ES512(ECDSAAdapter::create()));
    }

    public function testCanGetAlgorithm()
    {
        $es512 = new ES512(ECDSAAdapter::create());
        $this->assertEquals('sha512', $es512->getAlgorithm());
    }

    public function testCanGetAlgorithmAlias()
    {
        $es512 = new ES512(ECDSAAdapter::create());
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::ES512, $es512->getAlgorithmAlias());
    }
}
