<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    // 可以批量赋值的字段
    protected $fillable = [
        'comment_id',
        'user_id',
        'content',
        'reply_time',
        'likes',
        'status',
    ];

    // 定义模型与其他模型之间的关系
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
