<?php

namespace Gandung\JWT\Proxy;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ECDSA extends AbstractProxy
{
    /**
     * @return \Gandung\JWT\Algorithm\ECDSA\ES256
     */
    public function getES256()
    {
        return $this->instantiate(
            \Gandung\JWT\Algorithm\ECDSA\ES256::class,
            [
                \Gandung\JWT\Adapter\ECDSAAdapter::create()
            ]
        );
    }

    /**
     * @return \Gandung\JWT\Algorithm\ECDSA\ES384
     */
    public function getES384()
    {
        return $this->instantiate(
            \Gandung\JWT\Algorithm\ECDSA\ES384::class,
            [
                \Gandung\JWT\Adapter\ECDSAAdapter::create()
            ]
        );
    }

    /**
     * @return \Gandung\JWT\Algorithm\ECDSA\ES512
     */
    public function getES512()
    {
        return $this->instantiate(
            \Gandung\JWT\Algorithm\ECDSA\ES512::class,
            [
                \Gandung\JWT\Adapter\ECDSAAdapter::create()
            ]
        );
    }
}
