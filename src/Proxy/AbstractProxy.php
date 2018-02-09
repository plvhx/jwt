<?php

namespace Gandung\JWT\Proxy;

use ProxyManager\Factory\LazyLoadingValueHolderFactory;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
abstract class AbstractProxy
{
    /**
     * @var LazyLoadingValueHolderFactory
     */
    private $proxy;

    public function __construct(LazyLoadingValueHolderFactory $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * For chainability purpose.
     */
    public static function create()
    {
        return new static(
            new LazyLoadingValueHolderFactory()
        );
    }

    /**
     * Create virtual proxy from given class name and constructor arguments.
     *
     * @param string $class
     * @param array $constructorArg
     * @return object
     */
    protected function instantiate($class, $constructorArg = [])
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                sprintf("Class '%s' not exists.", $class)
            );
        }

        $proxy = $this->proxy->createProxy(
            $class,
            function (
                &$wrappedObject,
                $proxy,
                $method,
                $parameters,
                &$initializer
            ) use (
                $class,
                $constructorArg
) {
                $wrappedObject = (new \ReflectionClass($class))->newInstanceArgs($constructorArg);
                $initializer = null;

                return true;
            }
        );

        return $proxy;
    }
}
