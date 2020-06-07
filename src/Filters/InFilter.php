<?php

namespace Jdexx\EloquentRansack\Filters;

use Illuminate\Database\Eloquent\Builder;

class InFilter extends BaseFilter
{
    public function apply(Builder $query): Builder
    {
        $values = (array) $this->getValue();
        $values = array_filter($values);

        if (empty($values)) {
            return $query;
        }

        return $query->whereIn($this->getAttribute(), $values);
    }
}
