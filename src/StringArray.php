<?php

namespace Inilim\ArrayType;

use Inilim\ArrayType\ArrayAsObject;

class StringArray extends ArrayAsObject
{
    public function offsetSet($offset, $value): void
    {
        if (!is_string($value)) throw new \ValueError(\sprintf('Value must be of type string, %s given', \gettype($value)));
        parent::offsetSet($offset, $value);
    }
}
