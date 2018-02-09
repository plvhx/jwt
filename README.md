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
	->exp(new \DateTimeImmutable('@1518178593'));
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