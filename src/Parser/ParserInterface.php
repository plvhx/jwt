<?php

namespace Gandung\JWT\Parser;

use Gandung\JWT\Accessor\JoseHeaderAccessorInterface;
use Gandung\JWT\Accessor\PayloadAccessorInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface ParserInterface
{
	/**
	 * Parse JWT token.
	 *
	 * @param string $token
	 * @return void
	 */
	public function parse($token);

	/**
	 * Get signature from given JWT token.
	 *
	 * @param boolean $raw
	 * @return string
	 */
	public function getSignature($raw = true);

	/**
	 * Get JOSE header from given JWT token.
	 *
	 * @return JoseHeaderAccessorInterface
	 */
	public function getJoseHeader(): JoseHeaderAccessorInterface;

	/**
	 * Get payload from given JWT token.
	 *
	 * @return PayloadAccessorInterface
	 */
	public function getPayload(): PayloadAccessorInterface;
}