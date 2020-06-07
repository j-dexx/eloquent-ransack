<?php

namespace Jdexx\EloquentRansack\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter
{
    private string $attribute;
    /**
     * @var mixed $value;
     */
    private $value;

    public function __construct(string $attribute, $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;
    }

    abstract public function apply(Builder $query): Builder;

    protected function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * @return mixed
     */
    protected function getValue()
    {
        return $this->value;
    }
}
