<?php

namespace Gandung\JWT\Tests\Algorithm\RSA;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Algorithm\RSA\RS384;
use Gandung\JWT\Tests\Exception\ConstantFromExternalModuleNotFoundException;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class RS384Test extends TestCase
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
        $this->assertInstanceOf(RS384::class, new RS384);
    }

    public function testCanGetAlgorithm()
    {
        $rs384 = new RS384;
        $this->assertEquals(\OPENSSL_ALGO_SHA384, $rs384->getAlgorithm());
    }

    public function testCanGetAlgorithmAlias()
    {
        $rs384 = new RS384;
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::RS384, $rs384->getAlgorithmAlias());
    }
}
