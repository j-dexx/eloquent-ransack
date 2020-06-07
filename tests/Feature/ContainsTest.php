<?php

namespace Jdexx\EloquentRansack\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class ContainsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_returns_matching_posts(): void
    {
        $post = factory(Post::class)->create([
            'name' => 'abcdef',
        ]);
        $otherPost = factory(Post::class)->create();
        $input = [
            'name_cont' => 'bcde',
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
