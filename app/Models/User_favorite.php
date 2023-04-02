<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_favorite extends Model
{
    use HasFactory;

    // 可以批量赋值的字段
    protected $fillable = [
        'user_id',
        'favorite_type',
        'object_id',
    ];

    // 关联 User 模型
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 获取收藏对象（多态关联）
    public function favoritable()
    {
        return $this->morphTo();
    }
}
