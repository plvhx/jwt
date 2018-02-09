<?php

namespace Gandung\JWT\Token;

use Psr\Http\Message\UriInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface JoseBuilderInterface extends \Gandung\JWT\BuilderInterface
{
    public function algorithm($algo);

    public function jwkSetUrl(UriInterface $url);

    public function keyID($id);

    public function x509Url(UriInterface $url);

    public function type($type);

    public function contentType($type);
}
