<?php

namespace Jdexx\EloquentRansack\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;
use Jdexx\EloquentRansack\Tests\TestCase;

class LessThanTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_returns_matching_posts(): void
    {
        $todayPost = factory(Post::class)->create([
            'date' => Carbon::now(),
        ]);
        $tomorrowPost = factory(Post::class)->create([
            'date' => Carbon::tomorrow(),
        ]);
        $input = [
            'date_lt' => Carbon::tomorrow(),
        ];

        $results = Post::ransack($input)->get();

        $this->assertCount(1, $results);
        $this->assertTrue($results->contains(function ($result) use ($todayPost) {
            return $result->id === $todayPost->id;
        }));
        $this->assertFalse($results->contains(function ($result) use ($tomorrowPost) {
            return $result->id === $tomorrowPost->id;
        }));
    }
}
