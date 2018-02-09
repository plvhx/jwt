<?php

namespace Gandung\JWT\Tests\Algorithm\RSA;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Algorithm\RSA\RS512;
use Gandung\JWT\Tests\Exception\ConstantFromExternalModuleNotFoundException;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class RS512Test extends TestCase
{
    public function testIfConstantValueExistsFromOpensslDependency()
    {
        if (!defined('OPENSSL_ALGO_SHA256') ||
            !defined('OPENSSL_ALGO_SHA384') ||
            !defined('OPENSSL_ALGO_SHA512')) {
            throw new ConstantFromExternalModuleNotFoundException(
                "Install 'openssl' module first."
            );
        }

        $this->assertTrue(true);
    }

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(RS512::class, new RS512);
    }

    public function testCanGetAlgorithm()
    {
        $rs512 = new RS512;
        $this->assertEquals(\OPENSSL_ALGO_SHA512, $rs512->getAlgorithm());
    }

    public function testCanGetAlgorithmAlias()
    {
        $rs512 = new RS512;
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::RS512, $rs512->getAlgorithmAlias());
    }
}
