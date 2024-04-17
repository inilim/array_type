<?php

namespace Inilim\ArrayType;

abstract class ArrayAsObject implements \ArrayAccess
{
    protected array $array = [];

    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->array[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->array[$offset] ?? null;
    }
}
