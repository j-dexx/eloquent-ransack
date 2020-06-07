<?php

namespace Jdexx\EloquentRansack;

use Illuminate\Database\Eloquent\Builder;
use Jdexx\EloquentRansack\Filters\BaseFilter;
use Jdexx\EloquentRansack\Filters\ContainsFilter;
use Jdexx\EloquentRansack\Filters\EqualsFilter;
use Jdexx\EloquentRansack\Filters\InFilter;
use Jdexx\EloquentRansack\Filters\LessThanFilter;
use Jdexx\EloquentRansack\Filters\LessThanOrEqualFilter;
use Jdexx\EloquentRansack\Filters\GreaterThanFilter;
use Jdexx\EloquentRansack\Filters\GreaterThanOrEqualFilter;
use Jdexx\EloquentRansack\Filters\NotEqualFilter;
use Jdexx\EloquentRansack\Filters\NotInFilter;
use Jdexx\EloquentRansack\Input\PredicateSplitter;

class QueryBuilder
{
    public const PREDICATE_FILTERS = [
        'cont' => ContainsFilter::class,
        'eq' => EqualsFilter::class,
        'not_eq' => NotEqualFilter::class,
        'in' => InFilter::class,
        'not_in' => NotInFilter::class,
        'lt' => LessThanFilter::class,
        'lte' => LessThanOrEqualFilter::class,
        'gt' => GreaterThanFilter::class,
        'gte' => GreaterThanOrEqualFilter::class,
    ];

    private array $modelAttributes;
    private array $input;
    private Builder $query;

    public function __construct(Builder $query, string $class, array $input)
    {
        $this->modelAttributes = $this->fetchDatabaseColumns($class);
        $this->query = $query;
        $this->input = array_filter($input);
    }

    public function call(): Builder
    {
        $query = $this->getQuery();

        foreach ($this->buildFilters() as $filter) {
            $filter->apply($query);
        }

        return $query;
    }

    private function getQuery(): Builder
    {
        return $this->query;
    }

    private function buildFilters(): array
    {
        $filters = [];
        $data = $this->splitPredicates();

        foreach ($data as $inputData) {
            $filter = $this->buildFilterForInput($inputData);
            if ($filter) {
                $filters[] = $filter;
            }
        }

        return $filters;
    }

    private function buildFilterForInput(array $data): ?BaseFilter
    {
        list(
            'attribute' => $attribute,
            'predicate' => $predicate,
            'value' => $value
        ) = $data;
        if ($this->modelDoesNotHaveAttribute($attribute)) {
            return null;
        }
        $filterClass = self::PREDICATE_FILTERS[$predicate];
        return new $filterClass($attribute, $value);
    }

    private function modelDoesNotHaveAttribute(string $attribute): bool
    {
        return !in_array($attribute, $this->getModelAttributes());
    }

    private function getModelAttributes(): array
    {
        return $this->modelAttributes;
    }

    private function getInput(): array
    {
        return $this->input;
    }

    private function fetchDatabaseColumns(string $class): array
    {
        $model = new $class();
        $table = $model->getTable();
        return $model->getConnection()->getSchemaBuilder()->getColumnListing($table);
    }

    private function splitPredicates(): array
    {
        $input = $this->getInput();
        $predicateSplitter = new PredicateSplitter($input);
        return $predicateSplitter->call();
    }
}
