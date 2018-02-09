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

```
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
