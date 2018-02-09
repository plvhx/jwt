<?php

namespace Gandung\JWT\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Gandung\JWT\JWTFactory;
use Gandung\JWT\Validator\Validator;
use Gandung\JWT\ValidatorInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ValidatorTest extends TestCase
{
    /**
     * @var string
     */
    private $token;

    public function __construct()
    {
        parent::__construct();
        $this->token = $this->buildJWTToken();
    }

    public function testIsAnInstance()
    {
        $this->assertInstanceOf(Validator::class, new Validator);
    }

    public function testCanNormallyValidateCurrentToken()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\Algorithm);
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\Type);
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\ContentType);
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\IssuedBy);
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\ExpirationTime);
        $isTokenValid = $validator->validate($this->token);
        $this->assertInternalType('boolean', $isTokenValid);
        $this->assertTrue($isTokenValid);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCanRaiseExceptionWhenValidatingInvalidToken()
    {
        $invalidToken = explode('.', $this->token);
        unset($invalidToken[2]);
        $invalidToken = join('.', array_values($invalidToken));
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\Algorithm);
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\Type);
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\ContentType);
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\IssuedBy);
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\ExpirationTime);
        $isTokenValid = $validator->validate($invalidToken);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoJWKSetUrlInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\JWKSetUrl);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoJsonWebKeyInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\JsonWebKey);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoKeyIDInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\KeyID);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoX509CertChainInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\X509CertificateChain);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoX509UrlInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\X509Url);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoAudienceInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\IntendedTo);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoIssuedAtInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\IssuedAt);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoJWTIDInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\JWTID);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoNotBeforeInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\NotBefore);
        $validator->validate($this->token);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCanRaiseExceptionWhenValidatingTokenWithNoRelatedToInIt()
    {
        $validator = new Validator;
        $validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\RelatedTo);
        $validator->validate($this->token);
    }

    private function buildJWTToken()
    {
        $key = JWTFactory::getKeyManager();
        $key->setContentFromCertFile('cert/dummy256.pem');
        $key->setPassphrase('umar123');
        $jose = JWTFactory::getJoseBuilder()
            ->algorithm(\Gandung\JWT\Token\Algorithm::RS256)
            ->type('JWT')
            ->contentType('application/json');
        $claim = JWTFactory::getClaimBuilder()
            ->issuedBy('Paulus Gandung Prakosa')
            ->expireAt(new \DateTimeImmutable('@' . (time() + (3600 * 3))));
        $payload = JWTFactory::getPayloadBuilder()
            ->claim($claim)
            ->userData([
                'credentials' => [
                    'username' => 'gandung',
                    'password' => 'whatever_i_like'
                ]
            ]);
        $jwt = JWTFactory::getJwt();
        $token = $jwt->createToken($jose, $payload, $key);

        return $token;
    }
}
