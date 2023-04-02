<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Migration extends Model
{
    use HasFactory;

    // 定义可以进行批量赋值的字段，以防止批量赋值安全漏洞
    protected $fillable = [
        'migration',
        'batch',
    ];

    // 定义自动类型转换，根据数据表结构定义需要转换的字段类型
    protected $casts = [
        'batch' => 'integer',
    ];
}
