<?php

namespace Gandung\JWT\Proxy;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class RSA extends AbstractProxy
{
    /**
     * @return \Gandung\JWT\Algorithm\RSA\RS256
     */
    public function getRS256()
    {
        return $this->instantiate(\Gandung\JWT\Algorithm\RSA\RS256::class);
    }

    /**
     * @return \Gandung\JWT\Algorithm\ECDSA\ES384
     */
    public function getRS384()
    {
        return $this->instantiate(\Gandung\JWT\Algorithm\RSA\RS384::class);
    }

    /**
     * @return \Gandung\JWT\Algorithm\ECDSA\ES512
     */
    public function getRS512()
    {
        return $this->instantiate(\Gandung\JWT\Algorithm\RSA\RS512::class);
    }
}
