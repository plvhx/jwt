<?php

namespace Gandung\JWT\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\Parser\Parser;
use Gandung\JWT\Parser\ParserInterface;
use Gandung\JWT\JWTFactory;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ParserTest extends TestCase
{
	/**
	 * @var string
	 */
	private $token;

	public function __construct()
	{
		parent::__construct();
		$q = "this_is_me_who_will_sign_your_ass";
		$key = JWTFactory::getKeyManager();
		$key->setPassphrase($q);
		$header = JWTFactory::getJoseBuilder()
			->algorithm(\Gandung\JWT\Token\Algorithm::HS256)
			->type('JWT')
			->contentType('application/json');
		$claim = JWTFactory::getClaimBuilder()
			->issuedBy('me')
			->expireAt(new \DateTimeImmutable('@' . (time() + 3600)));
		$payload = JWTFactory::getPayloadBuilder()
			->claim($claim)
			->userData([
				'credentials' => [
					'username' => 'me',
					'password' => password_hash($q, PASSWORD_BCRYPT)
				]
			]);
		$this->token = JWTFactory::getJwt()->createToken($header, $payload, $key);
	}

	public function testCanGetInstance()
	{
		$this->assertInstanceOf(ParserInterface::class, new Parser);
	}

	public function testCanParseJWTToken()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->parse($this->token);
	}

	public function testCanGetSignatureInRawModeFromJWTToken()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->parse($this->token);
		$signature = $parser->getSignature();
		$this->assertInternalType('string', $signature);
		$this->assertNotEmpty($signature);
	}

	public function testCanGetSignatureInBase64ModeFromJWTToken()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->parse($this->token);
		$signature = $parser->getSignature(false);
		$this->assertInternalType('string', $signature);
		$this->assertNotEmpty($signature);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testCanRaiseExceptionWhenGetTokenSignatureFromInvalidJWTToken()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->getSignature(false);
	}

	public function testCanGetJoseHeader()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->parse($this->token);
		$header = $parser->getJoseHeader();
		$this->assertInstanceOf(
			\Gandung\JWT\Accessor\JoseHeaderAccessorInterface::class,
			$header
		);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testCanRaiseExceptionWhenGetTokenHeaderFromInvalidJWTToken()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->getJoseHeader();
	}

	public function testCanGetPayload()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->parse($this->token);
		$payload = $parser->getPayload();
		$this->assertInstanceOf(
			\Gandung\JWT\Accessor\PayloadAccessorInterface::class,
			$payload
		);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testCanRaiseExceptionWhenGetTokenPayloadFromInvalidToken()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->getPayload();
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testCanRaiseExceptionWhenParsingEmptyJWTToken()
	{
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->parse('');
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testCanRaiseExceptionWhenParsingInvalidJWTToken()
	{
		$q = explode('.', $this->token);
		unset($q[0]);
		$i = join('.', $q);
		$parser = new Parser;
		$this->assertInstanceOf(ParserInterface::class, $parser);
		$parser->parse($i);
	}
}