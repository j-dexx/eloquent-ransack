<?php

namespace Jdexx\EloquentRansack\Tests\Unit\Filters;

use Jdexx\EloquentRansack\Filters\EqualsFilter;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class EqualsFilterTest extends TestCase
{
    public function test_maps_to_equals(): void
    {
        $query = Post::query();
        $filter = new EqualsFilter('name', 'jeff');

        $result = $filter->apply($query);

        $this->assertStringContainsString('where "name" = ?', $result->toSql());
    }
}
