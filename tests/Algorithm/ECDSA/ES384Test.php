<?php

namespace Gandung\JWT\Tests\Algorithm\ECDSA;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Adapter\ECDSAAdapter;
use Gandung\JWT\Algorithm\ECDSA\ES384;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ES384Test extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(ES384::class, new ES384(ECDSAAdapter::create()));
    }

    public function testCanGetAlgorithm()
    {
        $es384 = new ES384(ECDSAAdapter::create());
        $this->assertEquals('sha384', $es384->getAlgorithm());
    }

    public function testCanGetAlgorithmAlias()
    {
        $es384 = new ES384(ECDSAAdapter::create());
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::ES384, $es384->getAlgorithmAlias());
    }
}
