<?php

namespace Jdexx\EloquentRansack\Filters;

use Illuminate\Database\Eloquent\Builder;

class ContainsFilter extends BaseFilter
{
    public function apply(Builder $query): Builder
    {
        $value = '%' . $this->getValue() . '%';
        return $query->where($this->getAttribute(), 'LIKE', $value);
    }
}
