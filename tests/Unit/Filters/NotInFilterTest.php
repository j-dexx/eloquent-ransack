<?php

namespace Jdexx\EloquentRansack\Tests\Unit\Filters;

use Jdexx\EloquentRansack\Filters\NotInFilter;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class NotInFilterTest extends TestCase
{
    public function test_maps_to_in(): void
    {
        $query = Post::query();
        $filter = new NotInFilter('name', ['jeff']);

        $result = $filter->apply($query);

        $this->assertStringContainsString('where "name" not in (?)', $result->toSql());
    }

    public function test_if_empty_returns_query(): void
    {
        $query = Post::query();
        $filter = new NotInFilter('name', []);

        $result = $filter->apply($query);

        $this->assertStringNotContainsString('where "name" not in (?)', $result->toSql());
    }

    public function test_if_array_with_empty_string_returns_query(): void
    {
        $query = Post::query();
        $filter = new NotInFilter('name', ['']);

        $result = $filter->apply($query);

        $this->assertStringNotContainsString('where "name" not in (?)', $result->toSql());
    }
}
