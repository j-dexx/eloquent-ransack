<?php

namespace Jdexx\EloquentRansack\Tests\Unit\Filters;

use Jdexx\EloquentRansack\Filters\InFilter;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class InFilterTest extends TestCase
{
    public function test_maps_to_In(): void
    {
        $query = Post::query();
        $filter = new InFilter('name', ['jeff']);

        $result = $filter->apply($query);

        $this->assertStringContainsString('where "name" in (?)', $result->toSql());
    }

    public function test_if_empty_returns_query(): void
    {
        $query = Post::query();
        $filter = new InFilter('name', []);

        $result = $filter->apply($query);

        $this->assertStringNotContainsString('where "name" in (?)', $result->toSql());
    }

    public function test_if_array_with_empty_string_returns_query(): void
    {
        $query = Post::query();
        $filter = new InFilter('name', ['']);

        $result = $filter->apply($query);

        $this->assertStringNotContainsString('where "name" in (?)', $result->toSql());
    }
}
