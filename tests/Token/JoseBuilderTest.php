<?php

namespace Gandung\JWT\Tests\Token;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Token\JoseBuilder;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class JoseBuilderTest extends TestCase
{
    private function callCollectJoseDirectly($name, $value)
    {
        $refl = new \ReflectionClass(JoseBuilder::class);
        $builder = $refl->getMethod('collectJose');
        $builder->setAccessible(true);
        $instance = $builder->invokeArgs(new JoseBuilder, [$name, $value]);
    }

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(JoseBuilder::class, new JoseBuilder);
    }

    /**
     * @expectedException \Gandung\JWT\Exception\AlgorithmHeaderValueMismatchException
     */
    public function testCanRaiseExceptionWhenGiveInvalidAlgorithm()
    {
        $builder = (new JoseBuilder)
            ->algorithm('invalid_algo');
    }

    public function testCanBuildJoseHeaderAndGetItAfterwards()
    {
        $builder = (new JoseBuilder)
            ->algorithm(\Gandung\JWT\Token\Algorithm::HS256)
            ->jwkSetUrl(new \Gandung\Psr7\Uri('http://example.org/jwk/set_url'))
            ->keyID(md5(uniqid()))
            ->x509Url(new \Gandung\Psr7\Uri('http://example.org/x509/cert.pem'))
            ->type('JWT')
            ->contentType('application/json');
        $this->assertInstanceOf(JoseBuilder::class, $builder);
        $jose = $builder->getValue();
        $this->assertInternalType('array', $jose);
        $this->assertNotEmpty($jose);
    }

    /**
     * @expectedException \Gandung\JWT\Exception\JoseTokenMismatchException
     */
    public function testCanRaiseExceptionWhileStoreValueInWrongJoseHeaderName()
    {
        $this->callCollectJoseDirectly('invalid_jose_header_name', 'shit');
    }
}
