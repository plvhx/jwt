<?php

namespace Gandung\JWT\Tests\Proxy;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Proxy\AbstractProxy;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class AbstractProxyTest extends TestCase
{
    public function testCanGetInstance()
    {
        $mock = $this->getMockBuilder(AbstractProxy::class)
            ->setConstructorArgs([new \ProxyManager\Factory\LazyLoadingValueHolderFactory])
            ->getMockForAbstractClass();
        $this->assertInstanceOf(AbstractProxy::class, $mock);
    }

    public function testCanInstantiateGivenConcreteClassName()
    {
        $mock = $this->getMockBuilder(AbstractProxy::class)
            ->setConstructorArgs([new \ProxyManager\Factory\LazyLoadingValueHolderFactory])
            ->getMockForAbstractClass();
        $this->assertInstanceOf(AbstractProxy::class, $mock);
        $caller = function () {
            return $this->instantiate(
                \Gandung\JWT\Algorithm\ECDSA\ES256::class,
                [\Gandung\JWT\Adapter\ECDSAAdapter::create()]
            );
        };
        $inv = $caller->bindTo($mock, $mock);
        $this->assertInstanceOf(\Gandung\JWT\Algorithm\ECDSA\ES256::class, $inv());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCanRaiseExceptionWhileInstantiateNonexistClassName()
    {
        $mock = $this->getMockBuilder(AbstractProxy::class)
            ->setConstructorArgs([new \ProxyManager\Factory\LazyLoadingValueHolderFactory])
            ->getMockForAbstractClass();
        $this->assertInstanceOf(AbstractProxy::class, $mock);
        $caller = function () {
            return $this->instantiate(
                'Nonexistent\Class\Name\Will\Be\Fucked\For\Good',
                []
            );
        };
        $inv = $caller->bindTo($mock, $mock);
        $inv();
    }
}
