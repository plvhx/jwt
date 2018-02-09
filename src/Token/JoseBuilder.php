<?php

namespace Gandung\JWT\Token;

use Gandung\JWT\Exception\AlgorithmHeaderValueMismatchException;
use Gandung\JWT\Exception\JoseTokenMismatchException;
use Gandung\JWT\TokenValidator\AlgorithmHeaderValue;
use Gandung\JWT\TokenValidator\JoseHeader;
use Psr\Http\Message\UriInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class JoseBuilder implements JoseBuilderInterface
{
    /**
     * @var array
     */
    private $jose = [];

    /**
     * {@inheritdoc}
     */
    public function algorithm($algo)
    {
        if (!AlgorithmHeaderValue::create()->validate($algo)) {
            throw new AlgorithmHeaderValueMismatchException("Supply valid algorithm header value.");
        }

        return $this->collectJose(Jose::ALGORITHM, $algo);
    }

    /**
     * {@inheritdoc}
     */
    public function jwkSetUrl(UriInterface $url)
    {
        return $this->collectJose(Jose::JWK_SET_URL, (string)$url);
    }

    /**
     * {@inheritdoc}
     */
    public function keyID($id)
    {
        return $this->collectJose(Jose::KEY_ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function x509Url(UriInterface $url)
    {
        return $this->collectJose(Jose::X509_URL, (string)$url);
    }

    /**
     * {@inheritdoc}
     */
    public function type($type)
    {
        return $this->collectJose(Jose::TYPE, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function contentType($type)
    {
        return $this->collectJose(Jose::CONTENT_TYPE, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->jose;
    }
    
    /**
     * Aggregate JOSE header by pairing it's name with it's value.
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    private function collectJose($name, $value)
    {
        if (!JoseHeader::create()->validate($name)) {
            throw new JoseTokenMismatchException("Supply valid JOSE header name.");
        }
        
        $this->jose[$name] = $value;

        return $this;
    }
}
