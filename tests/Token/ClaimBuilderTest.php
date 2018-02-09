<?php

namespace Gandung\JWT\Tests\Token;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Token\ClaimBuilder;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ClaimBuilderTest extends TestCase
{
    private function callCollectClaimDirectly($name, $value)
    {
        $refl = new \ReflectionClass(ClaimBuilder::class);
        $collector = $refl->getMethod('collectClaim');
        $collector->setAccessible(true);
        $instance = $collector->invokeArgs($refl->newInstanceWithoutConstructor(), [$name, $value]);
    }

    public function testCanGetInstance()
    {
        $this->assertInstanceOf(ClaimBuilder::class, new ClaimBuilder);
    }

    public function testCanBuildJWTClaimAndGetItAfterwards()
    {
        $builder = (new ClaimBuilder)
            ->issuedBy('Paulus Gandung Prakosa')
            ->relatedTo('something')
            ->intendedFor('everybody')
            ->expireAt(new \DateTimeImmutable('@' . (time() + (3600 * 3))))
            ->canOnlyBeUsedAfter(new \DateTimeImmutable('@' . (time() - (3600 * 3))))
            ->issuedAt(new \DateTimeImmutable('@' . (time() - (3600 * 24))))
            ->identifiedBy(md5(uniqid()));
        $aggregated = $builder->getValue();
        $this->assertInternalType('array', $aggregated);
        $this->assertNotEmpty($aggregated);
    }

    /**
     * @expectedException \Gandung\JWT\Exception\ClaimTokenMismatchException
     */
    public function testCanRaiseExceptionWhileStoreValueInWrongClaimName()
    {
        $this->callCollectClaimDirectly('shit', 'this_is_truly_a_shit');
    }
}
