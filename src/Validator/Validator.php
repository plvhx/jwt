<?php

namespace Gandung\JWT\Validator;

use Gandung\JWT\ValidatorInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class Validator implements ValidatorInterface
{
    /**
     * @var array
     */
    private $constraint = [];

    public function addConstraint(Constraints\ConstraintInterface $constraint)
    {
        $this->constraint[] = $constraint;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        $q = explode('.', $value);

        if (sizeof($q) !== 3) {
            throw new \InvalidArgumentException(
                "Supply valid JWT token."
            );
        }

        $m = $this->mergeUnserializedPortion(
            $this->unserializePortion($q[0]),
            $this->unserializePortion($q[1])
        );

        $this->normalizeConstraints();

        foreach ($this->constraint as $c) {
            if (!array_key_exists($c, $m)) {
                throw new \RuntimeException(
                    sprintf("Supplied JWT Token doesn't have '%s' constraint.", $c)
                );
            }
        }

        return true;
    }

    /**
     * Validate constraints from given array.
     *
     * @param array $array
     * @param null|object $key
     * @return boolean
     * @throws \RuntimeException when supplied array doesn't matched given constraint.
     */
    public function validateFromArray($array, $key = null)
    {
        if (is_null($key)) {
            $this->normalizeConstraints();

            foreach ($this->constraint as $c) {
                if (!array_key_exists($c, $array)) {
                    throw new \RuntimeException(
                        sprintf("Supplied data doesn't have '%s' constraint.", $c)
                    );
                }
            }
        } else {
            if (!array_key_exists($key->getValue(), $array)) {
                throw new \RuntimeException(
                    sprintf("Supplied data doesn't have '%s' constraint.", $key->getValue())
                );
            }
        }

        return true;
    }

    private function unserializePortion($portion)
    {
        return json_decode(
            \Gandung\JWT\__jwt_base64UrlDecode($portion),
            \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE
        );
    }

    private function mergeUnserializedPortion()
    {
        $res = [];

        foreach (func_get_args() as $v) {
            $res = array_merge_recursive($res, $v);
        }

        return $res;
    }

    private function normalizeConstraints()
    {
        $this->constraint = array_map(function ($q) {
            return $q->getValue();
        }, $this->constraint);
    }
}
