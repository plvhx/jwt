<?php

namespace Gandung\JWT\Token;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class PayloadBuilder implements PayloadBuilderInterface
{
    /**
     * @var array
     */
    private $payload = [];

    /**
     * {@inheritdoc}
     */
    public function claim(ClaimBuilderInterface $claim)
    {
        return $this->collectPayload('claim', $claim->getValue());
    }

    /**
     * {@inheritdoc}
     */
    public function userData($data = [])
    {
        return $this->collectPayload('user-data', $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        $merged = [];

        foreach ($this->payload as $value) {
            $merged = \array_merge_recursive($merged, $value);
        }

        return $merged;
    }

    /**
     * Aggregate JWT payload by pairing it's name with it's value.
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    private function collectPayload($name, $value)
    {
        $this->payload[$name] = $value;

        return $this;
    }
}
