<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    // 可以批量赋值的字段
    protected $fillable = [
        'user_id',
        'title',
        'cover_image',
        'description',
        'favorite_count',
        'status',
    ];

    // 定义模型与其他模型之间的关系
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function playlist_tags()
    {
        return $this->hasMany(Playlist_Tag::class, 'playlist_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'playlist_tags', 'playlist_id', 'tag_id');
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_songs');
    }
}
