<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // 可以批量赋值的字段
    protected $fillable = [
        'user_id',
        'object_type',
        'object_id',
        'reason',
        'report_time',
        'status',
    ];

    // 定义模型与其他模型之间的关系
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 用于获取报告对象的多态关联
    public function reportable()
    {
        return $this->morphTo();
    }
}
