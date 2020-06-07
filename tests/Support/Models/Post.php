<?php

namespace Jdexx\EloquentRansack\Tests\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Jdexx\EloquentRansack\Ransackable;

class Post extends Model
{
    use Ransackable;
}
