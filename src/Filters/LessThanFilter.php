<?php

namespace Jdexx\EloquentRansack\Filters;

use Illuminate\Database\Eloquent\Builder;

class LessThanFilter extends BaseFilter
{
    public function apply(Builder $query): Builder
    {
        return $query->where($this->getAttribute(), '<', $this->getValue());
    }
}
