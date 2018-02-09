<?php

namespace Gandung\JWT\Tests\Manager;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Manager\KeyManager;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class KeyManagerTest extends TestCase
{
    public function testCanGetInstance()
    {
        $this->assertInstanceOf(KeyManager::class, new KeyManager);
    }

    public function testCanSetContentAndGetAfterwards()
    {
        $key = new KeyManager;
        $key->setContent('this is a dummy content.');
        $content = $key->getContent();
        $this->assertInternalType('string', $content);
        $this->assertNotEmpty($content);
        $this->assertEquals('this is a dummy content.', $content);
    }

    public function testCanSetPassphraseAndGetAfterwards()
    {
        $key = new KeyManager;
        $key->setPassphrase('secret123');
        $pass = $key->getPassphrase();
        $this->assertInternalType('string', $pass);
        $this->assertNotEmpty($pass);
        $this->assertEquals('secret123', $pass);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCanRaiseExceptionWhenSetContentFromNonexistedFile()
    {
        $key = new KeyManager;
        $key->setContentFromCertFile('cert/this_is_a_file_that_not_exists.pem');
    }
}
