<?php

namespace Jdexx\EloquentRansack\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class IgnoresRandomInputTest extends TestCase
{
    use RefreshDatabase;

    public function test_ignores_attributes_not_on_model(): void
    {
        $post = factory(Post::class)->create();
        $input = [
            'name_eq' => $post->name,
            'no_column_eq' => 'something'
        ];

        $results = Post::ransack($input)->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains(function ($result) use ($post) {
            return $result->id === $post->id;
        }));
    }

    public function test_ignores_input_not_matching_ransack_predicates(): void
    {
        $post = factory(Post::class)->create();
        $input = [
            'name_eq' => $post->name,
            'date_blah' => 'something',
        ];

        $results = Post::ransack($input)->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains(function ($result) use ($post) {
            return $result->id === $post->id;
        }));
    }
}
