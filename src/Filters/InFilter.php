<?php

namespace Jdexx\EloquentRansack\Filters;

use Illuminate\Database\Eloquent\Builder;

class InFilter extends BaseFilter
{
    public function apply(Builder $query): Builder
    {
        return $query->whereIn($this->getAttribute(), $this->getValue());
    }
}
