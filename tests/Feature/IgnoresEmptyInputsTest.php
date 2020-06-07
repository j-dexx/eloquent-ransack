<?php

namespace Jdexx\EloquentRansack\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class IgnoresEmptyInputsTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_input_is_null(): void
    {
        $post = factory(Post::class)->create();
        $otherPost = factory(Post::class)->create();
        $input = [
            'name_eq' => $post->name,
            'date_eq' => null,
        ];

        $results = Post::ransack($input)->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains(function ($result) use ($post) {
            return $result->id === $post->id;
        }));
        $this->assertFalse($results->contains(function ($result) use ($otherPost) {
            return $result->id === $otherPost->id;
        }));
    }

    public function test_when_input_is_empty_string(): void
    {
        $post = factory(Post::class)->create();
        $otherPost = factory(Post::class)->create();
        $input = [
            'name_eq' => $post->name,
            'date_eq' => '',
        ];

        $results = Post::ransack($input)->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains(function ($result) use ($post) {
            return $result->id === $post->id;
        }));
        $this->assertFalse($results->contains(function ($result) use ($otherPost) {
            return $result->id === $otherPost->id;
        }));
    }
}
