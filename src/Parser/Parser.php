<?php

namespace Gandung\JWT\Parser;

use Gandung\JWT\Accessor\JoseHeaderAccessor;
use Gandung\JWT\Accessor\JoseHeaderAccessorInterface;
use Gandung\JWT\Accessor\PayloadAccessor;
use Gandung\JWT\Accessor\PayloadAccessorInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class Parser implements ParserInterface
{
	/**
	 * @var array
	 */
	private $portion;

	/**
	 * {@inheritdoc}
	 */
	public function parse($token)
	{
		$this->checkToken($token);

		$key = ['jose', 'payload', 'signature'];

		foreach ($this->portion as $k => $v) {
			if ($k === 0 || $k === 1) {
				$this->portion[$k] = json_decode(
					\Gandung\JWT\__jwt_base64UrlDecode($v),
					JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
				);
			} else {
				$this->portion[$k] = $v;
			}
		}

		$this->portion = array_combine($key, $this->portion);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSignature($raw = true)
	{
		if (!isset($this->portion['signature'])) {
			throw new \RuntimeException(
				"JWT portion doesn't have 'signature' index."
			);
		}

		return $raw === true
			? \Gandung\JWT\__jwt_base64UrlDecode($this->portion['signature'])
			: $this->portion['signature'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getJoseHeader(): JoseHeaderAccessorInterface
	{
		if (!isset($this->portion['jose'])) {
			throw new \RuntimeException(
				"JWT portion doesn't have 'jose' index."
			);
		}

		return new JoseHeaderAccessor($this->portion['jose']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPayload(): PayloadAccessorInterface
	{
		if (!isset($this->portion['payload'])) {
			throw new \RuntimeException(
				"JWT portion doesn't have 'payload' index."
			);
		}

		return new PayloadAccessor($this->portion['payload']);
	}

	/**
	 * Check if given JWT token is valid.
	 *
	 * @param string $token
	 */
	private function checkToken($token)
	{
		if (empty($token)) {
			throw new \InvalidArgumentException(
				"JWT token must not be empty."
			);
		}

		$this->portion = explode('.', $token);

		if (sizeof($this->portion) !== 3) {
			throw new \RuntimeException(
				"Invalid JWT token."
			);
		}
	}
}