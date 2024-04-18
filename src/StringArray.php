<?php

namespace Inilim\ArrayType;

use Inilim\ArrayType\ArrayObject;

/**
 * @method string[]|array{} toArray()
 * @method void offsetSet(mixed $offset, string $value)
 * @method string offsetGet(mixed $offset)
 */
class StringArray extends ArrayObject
{
    public function offsetSet($offset, $value): void
    {
        if (!is_string($value)) throw new \ValueError(\sprintf('Value must be of type string, %s given', \gettype($value)));
        if ($offset !== null) throw new \ValueError('Нельзя указывать ключ');
        parent::offsetSet($offset, $value);
    }

    public function current(): string
    {
        return $this->array[$this->pos];
    }

    public function key(): int
    {
        return $this->pos;
    }
}
