<?php

namespace Gandung\JWT\Tests\Accessor;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Accessor\JoseHeaderAccessor;
use Gandung\JWT\JWTFactory;
use Gandung\JWT\Token\JoseBuilderInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class JoseHeaderAccessorTest extends TestCase
{
    /**
     * @var JoseBuilderInterface
     */
    private $jose;

    public function __construct()
    {
        parent::__construct();
        $this->jose = JWTFactory::getJoseBuilder()
            ->algorithm(\Gandung\JWT\Token\Algorithm::HS256)
            ->type('JWT')
            ->contentType('application/json');
    }

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(JoseHeaderAccessor::class, new JoseHeaderAccessor($this->jose->getValue()));
    }

    public function testCanGetAlgorithmDirective()
    {
        $accessor = new JoseHeaderAccessor($this->jose->getValue());
        $this->assertInternalType('string', $accessor->getAlgorithm());
        $this->assertEquals(\Gandung\JWT\Token\Algorithm::HS256, $accessor->getAlgorithm());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanGetJwkSetUrlDirective()
    {
        $accessor = new JoseHeaderAccessor($this->jose->getValue());
        $this->assertInternalType('string', $accessor->getJwkSetUrl());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanGetKeyID()
    {
        $accessor = new JoseHeaderAccessor($this->jose->getValue());
        $this->assertInternalType('string', $accessor->getKeyID());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanGetX509Url()
    {
        $accessor = new JoseHeaderAccessor($this->jose->getValue());
        $this->assertInternalType('string', $accessor->getX509Url());
    }

    public function testCanGetType()
    {
        $accessor = new JoseHeaderAccessor($this->jose->getValue());
        $this->assertInternalType('string', $accessor->getType());
        $this->assertEquals('JWT', $accessor->getType());
    }

    public function testCanGetContentType()
    {
        $accessor = new JoseHeaderAccessor($this->jose->getValue());
        $this->assertInternalType('string', $accessor->getContentType());
        $this->assertEquals('application/json', $accessor->getContentType());
    }

    public function testCanGetAll()
    {
        $accessor = new JoseHeaderAccessor($this->jose->getValue());
        $this->assertInternalType('array', $accessor->get());
        $this->assertNotEmpty($accessor->getContentType());
    }
}
