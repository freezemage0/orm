<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 24.09.2020
 * Time: 22:20
 */

namespace Freezemage\Type;


class Collection implements \Iterator, \ArrayAccess
{
    protected $data;
    protected $pointer;

    public static function fromArray(array $data): Collection
    {
        $instance = new Collection();
        $instance->data = $data;

        return $instance;
    }

    public function __construct()
    {
        $this->data = array();
    }

    public function prepend($item): Collection
    {
        array_unshift($this->data, $item);
        return $this;
    }

    public function append($item): Collection
    {
        $this->data[] = $item;
        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function current()
    {
        return $this->offsetGet($this->pointer);
    }

    public function next()
    {
        $this->pointer++;
    }

    public function key()
    {
        return $this->pointer;
    }

    public function valid()
    {
        return $this->offsetExists($this->pointer);
    }

    public function rewind()
    {
        $this->pointer = 0;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}