<?php

namespace Inilim\ArrayType\Experimental;

abstract class ArrayObject
{
    /**
     * @var <string,string>
     */
    protected const METHODS        = [
        //               ref.new_static.return_mixed
        'setValueIfNotExists' => '101',
        'setValueIfNull'      => '101',
        'renameDotKey'        => '100',
        'onlyNestedArray'     => '010',
        'exceptNestedArray'   => '010',
        'fastArrayUnique'     => '010',
        'insertBefore'        => '100',
        'insertAfter'         => '100',
        'renameKey'           => '101',
        'getKeyOffset'        => '001',
        'isMultidimensional'  => '001',
        'sortBy'              => '010',
        'accessible'          => '001',
        'add'                 => '010',
        'collapse'            => '010',
        // 'value'               => '',
        // 'crossJoin'           => '',
        'join'                => '001',
        'query'               => '001',
        'prependKeysWith'     => '010',
        'mapWithKeys'         => '010',
        'map'                 => '010',
        'divide'              => '010',
        'dot'                 => '010',
        'flatten'             => '010',
        'pluck'               => '010',
        'set'                 => '100',
        'get'                 => '001',
        'forget'              => '100',
        'has'                 => '001',
        'hasAny'              => '001',
        'isAssoc'             => '001',
        'exists'              => '001',
        'only'                => '010',
        'except'              => '010',
        'prepend'             => '010',
        'pull'                => '101',
        'random'              => '001',
        'shuffle'             => '010',
        'take'                => '010',
        'undot'               => '010',
        'sortRecursive'       => '010',
        'sortRecursiveDesc'   => '010',
        'where'               => '010',
        // 'wrap'                => '',
        'dataGet'             => '001',
        'dataFill'            => '100',
        'dataSet'             => '100',
        'isList'              => '001',
        'head'                => '001',
        'last'                => '001',
    ];
    /**
     * @var string[]
     */
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
        if (!$this->hasMethod($name)) {
            throw new \RuntimeException('Call to undefined method ' . $name);
        }

        $c = static::METHODS[$name];

        // ------------------------------------------------------------------
        // ref.new_static.return_mixed
        // ------------------------------------------------------------------

        // например: setValueIfNotExists
        if ($c === '101') {
            // меняем текущий обьект по ссылке, возвращаем полученное значение из метода
            return \_arr()->$name($this->items, ...$args);
        }

        // например: get has hasAny isAssoc exists
        if ($c === '001') {
            // только возвращает значение метода
            return \_arr()->$name($this->items, ...$args);
        }

        // например: forget
        if ($c === '100') {
            // меняет текущий обьект, возвращает текущий обьект
            \_arr()->$name($this->items, ...$args);
            return $this;
        }

        // например: only except
        if ($c === '010') {
            // не меняет текущий обьект, возвращает новый массив из метода, отдаем новый обьект
            return new static(\_arr()->$name($this->items, ...$args));
        }
    }

    function getAll(): array
    {
        return $this->items;
    }

    function values(): array
    {
        return \array_values($this->items);
    }

    function keys(): array
    {
        return \array_keys($this->items);
    }

    function count(): int
    {
        return \sizeof($this->items);
    }

    // ------------------------------------------------------------------
    // 
    // ------------------------------------------------------------------

    private function hasMethod(string $name): bool
    {
        if (static::EXCEPT_METHODS && \in_array($name, static::EXCEPT_METHODS, true)) {
            return false;
        }
        return \array_key_exists($name, static::METHODS);
    }
}
