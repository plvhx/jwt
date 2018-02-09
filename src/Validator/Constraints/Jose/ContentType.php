<?php

namespace Gandung\JWT\Validator\Constraints\Jose;

use Gandung\JWT\Validator\Constraints\BaseConstraint;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class ContentType extends BaseConstraint
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return \Gandung\JWT\Token\Jose::CONTENT_TYPE;
    }
}
