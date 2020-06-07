<?php

namespace Jdexx\EloquentRansack;

use Illuminate\Database\Eloquent\Builder;

trait Ransackable
{
    public function scopeRansack(Builder $query, array $input): Builder
    {
        $ransackQueryBuilder = new QueryBuilder($query, self::class, $input);
        return $ransackQueryBuilder->call();
    }
}
