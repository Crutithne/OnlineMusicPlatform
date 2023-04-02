<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist_Tag extends Model
{
    use HasFactory;

    // 指定数据表名称，因为我们使用的是多个单词的模型名称，需要显式指定对应的数据表
    protected $table = 'playlist_tags';

    // 关闭模型中的时间戳 (created_at 和 updated_at)
    public $timestamps = false;

    // 用于批量赋值的属性，这些字段可以通过批量赋值来设置值
    protected $fillable = [
        'playlist_id',
        'tag_id',
    ];

    // 定义模型与其他模型之间的关系
    public function playlist()
    {
        return $this->belongsTo(Playlist::class, 'playlist_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
