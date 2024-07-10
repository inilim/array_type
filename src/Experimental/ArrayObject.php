<?php

namespace Inilim\ArrayType\Experimental;

abstract class ArrayObject
{
    protected const METHODS        = [
        //       pos ref return_static
        'get' => [0, false, false],
    ];
    protected const EXCEPT_METHODS = [];

    protected array $items = [];

    function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param string $name
     * @param mixed|array{} $args
     * @return mixed|static
     */
    function __call($name, $args)
    {
        if ($this->hasMethod($name)) {
            throw new \RuntimeException('Call to undefined method ' . $name);
        }

        // ------------------------------------------------------------------
        // 
        // ------------------------------------------------------------------

        list($pos, $ref, $return_static) = static::METHODS[$name];
        /**
         * @var int $pos позиция аргумента для массива
         * @var bool $ref
         * @var bool $return_static возвращает новый массив
         */

        // ------------------------------------------------------------------
        // 
        // ------------------------------------------------------------------

        $new_obj = null;
        if ($return_static) {
            $new_obj = new static;
        }

        // ------------------------------------------------------------------
        // 
        // ------------------------------------------------------------------

        $result = $this->execMethod($name, $this->items, $args);

        if ($new_obj === null) {
            return $result;
        } else {
            $new_obj->items = $result;
        }

        // ------------------------------------------------------------------
        // 
        // ------------------------------------------------------------------

        return $new_obj;
    }

    function toArray(): array
    {
        return $this->items;
    }

    // ------------------------------------------------------------------
    // 
    // ------------------------------------------------------------------

    /**
     * @return mixed
     */
    private function execMethod(string $name_method, array $array, array $args)
    {
        return \_arr()->{$name_method}($array, ...$args);
    }

    /**
     * @return mixed
     */
    private function execMethodRef(string $name_method, array $array, array $args)
    {
        return \_arr()->{$name_method}($array, ...$args);
    }

    private function hasMethod(string $name): bool
    {
        if (static::EXCEPT_METHODS && \in_array($name, static::EXCEPT_METHODS, true)) {
            return false;
        }
        return \array_key_exists($name, static::METHODS);
    }
}
