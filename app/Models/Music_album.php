<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music_album extends Model
{
    use HasFactory;

    // 指定数据表名称，因为我们使用的是多个单词的模型名称，需要显式指定对应的数据表
    protected $table = 'music_albums';

    // 定义模型与其他模型之间的关系
    public function music()
    {
        return $this->belongsTo(Music::class, 'music_id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
