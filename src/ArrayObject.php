<?php

namespace Inilim\ArrayType;

abstract class ArrayObject implements \ArrayAccess, \Iterator
{
    protected array $array = [];

    private int $pos       = 0;
    private array $keys    = [];
    private bool $changed  = false;

    public function toArray(): array
    {
        return $this->array;
    }

    public function head(): mixed
    {
        return \_arr()->head($this->array);
    }

    public function last(): mixed
    {
        return \_arr()->last($this->array);
    }

    // ------------------------------------------------------------------
    // Iterator
    // ------------------------------------------------------------------

    public function rewind(): void
    {
        $this->pos = 0;
    }

    public function current(): mixed
    {
        $this->defineKeys();
        return $this->array[$this->keys[$this->pos]];
    }

    public function key(): mixed
    {
        $this->defineKeys();
        return $this->keys[$this->pos];
    }

    public function next(): void
    {
        ++$this->pos;
    }

    public function valid(): bool
    {
        $this->defineKeys();
        if (!array_key_exists($this->pos, $this->keys)) return false;
        return true;
        // return \array_key_exists($this->keys[$this->pos], $this->array);
    }

    // ------------------------------------------------------------------
    // 
    // ------------------------------------------------------------------

    private function defineKeys(): void
    {
        if (!$this->changed) return;
        $this->keys = \array_keys($this->array);
        $this->changed = false;
    }

    // ------------------------------------------------------------------
    // ArrayAccess
    // ------------------------------------------------------------------

    /**
     * $arr[] = value | $arr[key] = value
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
        $this->changed = true;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->array[$offset]);
        $this->changed = true;
    }

    public function offsetGet($offset): mixed
    {
        return $this->array[$offset] ?? null;
    }
}
