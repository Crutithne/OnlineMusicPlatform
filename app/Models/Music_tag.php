<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music_tag extends Model
{
    use HasFactory;

    // 指定数据表名称，因为我们使用的是多个单词的模型名称，需要显式指定对应的数据表
    protected $table = 'music_tags';

    // 定义模型与其他模型之间的关系
    public function music()
    {
        return $this->belongsTo(Music::class, 'music_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
