<?php

namespace Jdexx\EloquentRansack\Tests\Unit\Filters;

use Jdexx\EloquentRansack\Filters\NotInFilter;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class NotInFilterTest extends TestCase
{
    public function test_maps_to_In(): void
    {
        $query = Post::query();
        $filter = new NotInFilter('name', ['jeff']);

        $result = $filter->apply($query);

        $this->assertStringContainsString('where "name" not in (?)', $result->toSql());
    }
}
