<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // 🔽 1対多の関係
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
