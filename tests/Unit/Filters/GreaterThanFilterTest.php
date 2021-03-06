<?php

namespace Jdexx\EloquentRansack\Tests\Unit\Filters;

use Jdexx\EloquentRansack\Filters\GreaterThanFilter;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class GreaterThanFilterTest extends TestCase
{
    public function test_maps_to_In(): void
    {
        $query = Post::query();
        $filter = new GreaterThanFilter('id', 2);

        $result = $filter->apply($query);

        $this->assertStringContainsString('where "id" > ?', $result->toSql());
    }
}
