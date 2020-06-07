<?php

namespace Jdexx\EloquentRansack\Tests\Unit\Filters;

use Jdexx\EloquentRansack\Filters\NotEqualFilter;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class NotEqualFilterTest extends TestCase
{
    public function test_maps_to_equals(): void
    {
        $query = Post::query();
        $filter = new NotEqualFilter('name', 'jeff');

        $result = $filter->apply($query);

        $this->assertStringContainsString('where "name" != ?', $result->toSql());
    }
}
