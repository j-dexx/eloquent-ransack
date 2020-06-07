<?php

namespace Jdexx\EloquentRansack\Filters;

use Illuminate\Database\Eloquent\Builder;

class NotInFilter extends BaseFilter
{
    public function apply(Builder $query): Builder
    {
        return $query->whereNotIn($this->getAttribute(), $this->getValue());
    }
}
