<?php

namespace Gandung\JWT\Proxy;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class HMAC extends AbstractProxy
{
    /**
     * @return \Gandung\JWT\Algorithm\HMAC\HS256
     */
    public function getHS256()
    {
        return $this->instantiate(\Gandung\JWT\Algorithm\HMAC\HS256::class);
    }

    /**
     * @return \Gandung\JWT\Algorithm\ECDSA\ES384
     */
    public function getHS384()
    {
        return $this->instantiate(\Gandung\JWT\Algorithm\HMAC\HS384::class);
    }

    /**
     * @return \Gandung\JWT\Algorithm\ECDSA\ES512
     */
    public function getHS512()
    {
        return $this->instantiate(\Gandung\JWT\Algorithm\HMAC\HS512::class);
    }
}
