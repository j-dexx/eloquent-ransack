<?php

namespace Jdexx\EloquentRansack\Tests\Unit\Filters;

use Jdexx\EloquentRansack\Filters\ContainsFilter;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class ContainsFilterTest extends TestCase
{
    public function test_maps_to_like(): void
    {
        $query = Post::query();
        $filter = new ContainsFilter('name', 'jeff');

        $result = $filter->apply($query);

        $this->assertStringContainsString('where "name" LIKE ?', $result->toSql());
        $this->assertContains('%jeff%', $result->getBindings());
    }
}
