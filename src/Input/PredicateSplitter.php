<?php

namespace Jdexx\EloquentRansack\Input;

use Jdexx\EloquentRansack\QueryBuilder;

class PredicateSplitter
{
    private array $input;

    public function __construct(array $input)
    {
        $this->input = $input;
    }

    public function call(): array
    {
        $data = [];
        foreach ($this->getInput() as $columnWithPredicate => $value) {
            $result = $this->manipulateInput($columnWithPredicate, $value);
            if (is_null($result)) {
                continue;
            }
            $data[] = $result;
        }
        return $data;
    }

    /**
     * @param mixed $value
     */
    private function manipulateInput(string $columnWithPredicate, $value): ?array
    {
        $matchingPredicates = $this->matchingPredicates($columnWithPredicate);
        if (empty($matchingPredicates)) {
            return null;
        }
        $predicate = $this->determinePredicate($matchingPredicates);
        $attributeName = $this->determineAttributeName($columnWithPredicate, $predicate);

        return [
            'attribute' => $attributeName,
            'predicate' => $predicate,
            'value' => $value,
        ];
    }

    private function determineAttributeName(string $columnWithPredicate, string $predicate): string
    {
        $predicateStart = strpos($columnWithPredicate, $predicate);
        // -1 to chop off the underscore
        return substr($columnWithPredicate, 0, $predicateStart - 1);
    }

    /**
     * Given predicates like in and not_in use the longest matching predicate
     */
    private function determinePredicate(array $predicates)
    {
        $lengths = array_map('strlen', $predicates);
        $maxLength = max($lengths);
        $key = array_search($maxLength, $lengths);
        return $predicates[$key];
    }

    private function matchingPredicates(string $columnWithPredicate): array
    {
        $predicates = array_keys(QueryBuilder::PREDICATE_FILTERS);
        $matchingPredicates = [];
        foreach ($predicates as $predicate) {
            if (false !== strpos($columnWithPredicate, $predicate)) {
                $matchingPredicates[] = $predicate;
            }
        }
        return $matchingPredicates;
    }

    private function getInput(): array
    {
        return $this->input;
    }
}
