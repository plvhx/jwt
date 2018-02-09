# JSON Web Token

An implementation of JSON Web Token based on [RFC 7519](https://tools.ietf.org/html/rfc7519).

- [Dependencies](#dependencies)
- [Quick Start](#quick-start)
	- [Creating Signature](#creating-signature)
		- [HMAC](#hmac)
		- [RSA](#rsa)
		- [ECDSA](#ecdsa)
	- [Validating Signature](#validating-signature)
		- [HMAC](#hmac)
		- [RSA](#rsa)
		- [ECDSA](#ecdsa)
	- [Validating Token Constraints](#validating-token-constraints)

## Dependencies
- PHP 7.0+
- OpenSSL Extension
- Mbstring Extension
- GMP Extension

## Quick Start

### Creating Signature

### HMAC

```php
use Gandung\JWT\JWTFactory;

$key = JWTFactory::getKeyManager();
$key->setPassphrase('secret');
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
			'password' => 'this_is_me_who_want_to_get_in'
		]
	]);
$jwt = JWTFactory::getJwt();
$token = $jwt->createToken($header, $payload, $key);

echo sprintf("Token: %s\n", $token);
```

### RSA

```php
use Gandung\JWT\JWTFactory;

$key = JWTFactory::getKeyManager();
// See: cert/dummy256.pem (Private Key)
$key->setContentFromCertFile('cert/dummy256.pem');
$key->setPassphrase('umar123');
$header = JWTFactory::getJoseBuilder()
	->algorithm(\Gandung\JWT\Token\Algorithm::RS256)
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
			'password' => 'this_is_me_who_want_to_get_in'
		]
	]);
$jwt = JWTFactory::getJwt();
$token = $jwt->createToken($header, $payload, $key);

echo sprintf("Token: %s\n", $token);
```

### ECDSA

```php
use Gandung\JWT\JWTFactory;

$key = JWTFactory::getKeyManager();
// See: cert/secp256.pem (Elliptic-Curve Private Key)
$key->setContentFromCertFile('cert/secp256.pem');
$header = JWTFactory::getJoseBuilder()
	->algorithm(\Gandung\JWT\Token\Algorithm::ES256)
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
			'password' => 'this_is_me_who_want_to_get_in'
		]
	]);
$jwt = JWTFactory::getJwt();
$token = $jwt->createToken($header, $payload, $key);

echo sprintf("Token: %s\n", $token);
```

### Validating Signature

### HMAC

```php
use Gandung\JWT\JWTFactory;

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCIsImN0eSI6ImFwcGxpY2F0aW9uL2pzb24ifQ.eyJpc3MiOiJtZSIsImV4cCI6MTUxODE3ODU5MywiY3JlZGVudGlhbHMiOnsidXNlcm5hbWUiOiJtZSIsInBhc3N3b3JkIjoidGhpc19pc19tZV93aG9fd2FudF90b19nZXRfaW4ifX0.NbX9ZGfadSYlAdgCaDklIYb4Nw2UCfxRJxoKgxZVURo";
$key = JWTFactory::getKeyManager();
$key->setPassphrase('secret');
$header = JWTFactory::getJoseBuilder()
	->algorithm(\Gandung\JWT\Token\Algorithm::HS256)
	->type('JWT')
	->contentType('application/json');
$claim = JWTFactory::getClaimBuilder()
	->issuedBy('me')
	->expireAt(new \DateTimeImmutable('@1518178593'));
$payload = JWTFactory::getPayloadBuilder()
	->claim($claim)
	->userData([
		'credentials' => [
			'username' => 'me',
			'password' => 'this_is_me_who_want_to_get_in'
		]
	]);
$jwt = JWTFactory::getJwt();
$isSignatureMatched = $jwt->verifyToken($token, $jose, $payload, $key);

var_dump($isSignatureMatched);
```

### RSA

```php
use Gandung\JWT\JWTFactory;

$token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImN0eSI6ImFwcGxpY2F0aW9uL2pzb24ifQ.eyJpc3MiOiJtZSIsImV4cCI6MTUxODE3OTU0NSwiY3JlZGVudGlhbHMiOnsidXNlcm5hbWUiOiJtZSIsInBhc3N3b3JkIjoidGhpc19pc19tZV93aG9fd2FudF90b19nZXRfaW4ifX0.kU9EwxWNpWjxYv2JloBsH5HGnRzMIMi8yAH2dOi6EfipR4O_BrseFih_2uFeaNg-xKFl2UYTMDo_OtFt-z9FOx-iYHPjj3sHCMoR-KE2MZTj0-3TPFNZhq6iWqA9WTPxpIxFiJBryk6PbS33pMovZHdLAU6H-2CBd5mvc2oT7DITCORqYYGQl-CPUaaPJjml8t9qMPfii5XYu0A1vqz9iD1bLvk7XyOTAONbJvwcZwdqX_OXdvnsAQ0XpEtFEcso5w55DXnltUAADZABGdVvIorWYVOW52neNQYStW83r_XvUynx5QPvJ8oHWr2-ithSrSWgC1YHUCM5QAon8DmG7_8PGSYINwsq9DvKozZnCpuuUaMO7IfA2HMFS0hPxQFTJPXndKTcnB6HbPpWOTTWBROhI-IoZFjD1Yu4zMQSUhlmvTq3IiDhpVpvkojkEmb8GSnOD7Xvs5zfx-7ceqWICeWEzSKQoTXEldzcXHuO0Ia8ihzWQ9S0_YAuYWyS0PJtzLsjUfvCox-aqUt8r4xIlv2ZP3PpWCbXHh_YS6-88ea--HECScl2il1nyrO4j_F4cieP2EGUEizCUbQOB4BWNns_Dea4Zwdt8VLoTxbMwxqrYPRydaQhX1w16kQf8yu5FnN5UpK_BKgz4_N5pNKljSomr_Elbyn3p6ddmDUmweA";
$key = JWTFactory::getKeyManager();
// See: cert/dummy256.pem (Private Key)
$key->setContentFromCertFile('cert/dummy256.pem');
$key->setPassphrase('umar123');
$header = JWTFactory::getJoseBuilder()
	->algorithm(\Gandung\JWT\Token\Algorithm::RS256)
	->type('JWT')
	->contentType('application/json');
$claim = JWTFactory::getClaimBuilder()
	->issuedBy('me')
	->expireAt(new \DateTimeImmutable('@1518179545'));
$payload = JWTFactory::getPayloadBuilder()
	->claim($claim)
	->userData([
		'credentials' => [
			'username' => 'me',
			'password' => 'this_is_me_who_want_to_get_in'
		]
	]);
$jwt = JWTFactory::getJwt();
$isSignatureMatched = $jwt->verifyToken($token, $jose, $payload, $key);

var_dump($isSignatureMatched);
```

### ECDSA

```php
use Gandung\JWT\JWTFactory;

$token = "eyJhbGciOiJFUzI1NiIsInR5cCI6IkpXVCIsImN0eSI6ImFwcGxpY2F0aW9uL2pzb24ifQ.eyJpc3MiOiJtZSIsImV4cCI6MTUxODE4MDM3MSwiY3JlZGVudGlhbHMiOnsidXNlcm5hbWUiOiJtZSIsInBhc3N3b3JkIjoidGhpc19pc19tZV93aG9fd2FudF90b19nZXRfaW4ifX0.-rHgMBeVqA5sP_gP6301PZ9NWy93ZO0lBQnJw0g2qCrvF4oz0IjePN8kLVdqIJkGG8E26-5HktKJcCJROBJ5ig";
$key = JWTFactory::getKeyManager();
// See: cert/secp256.pem (Private Key)
$key->setContentFromCertFile('cert/secp256.pem');
$header = JWTFactory::getJoseBuilder()
	->algorithm(\Gandung\JWT\Token\Algorithm::ES256)
	->type('JWT')
	->contentType('application/json');
$claim = JWTFactory::getClaimBuilder()
	->issuedBy('me')
	->expireAt(new \DateTimeImmutable('@1518180371'));
$payload = JWTFactory::getPayloadBuilder()
	->claim($claim)
	->userData([
		'credentials' => [
			'username' => 'me',
			'password' => 'this_is_me_who_want_to_get_in'
		]
	]);
$jwt = JWTFactory::getJwt();
$isSignatureMatched = $jwt->verifyToken($token, $jose, $payload, $key);

var_dump($isSignatureMatched);
```

### Validating Token Constraints

```php
use Gandung\JWT\Validator\Validator;

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCIsImN0eSI6ImFwcGxpY2F0aW9uL2pzb24ifQ.eyJpc3MiOiJtZSIsImV4cCI6MTUxODE3ODU5MywiY3JlZGVudGlhbHMiOnsidXNlcm5hbWUiOiJtZSIsInBhc3N3b3JkIjoidGhpc19pc19tZV93aG9fd2FudF90b19nZXRfaW4ifX0.NbX9ZGfadSYlAdgCaDklIYb4Nw2UCfxRJxoKgxZVURo";
$validator = new Validator;
$validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\Algorithm);
$validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\ContentType);
$validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Jose\Type);
$validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\IssuedBy);
$validator->addConstraint(new \Gandung\JWT\Validator\Constraints\Payload\ExpirationTime);
$isValidated = $validator->validate($token);

var_dump($isValidated);
```

If you find any bugs, feel free to send me a pull request.