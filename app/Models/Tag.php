<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // 可以批量赋值的字段
    protected $fillable = [
        'name',
    ];

    // 定义模型与其他模型之间的关系
    public function musics()
    {
        return $this->belongsToMany(Music::class, 'music_tags', 'tag_id', 'music_id');
    }

    public function singers()
    {
        return $this->belongsToMany(Singer::class, 'singer_tags', 'tag_id', 'singer_id');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_tags', 'tag_id', 'playlist_id');
    }
}
