<?php

namespace Jdexx\EloquentRansack\Tests\Unit;

use Jdexx\EloquentRansack\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Jdexx\EloquentRansack\QueryBuilder;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;

class QueryBuilderTest extends TestCase
{
    public function test_it_returns_an_eloquent_builder_instance(): void
    {
        $query = Post::query();
        $queryBuilder = new QueryBuilder($query, Post::class, []);

        $result = $queryBuilder->call();

        $this->assertInstanceOf(Builder::class, $result);
    }
}
