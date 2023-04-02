<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    // 用于批量赋值的属性，这些字段可以通过批量赋值来设置值
    protected $fillable = [
        'singer_id',
        'title',
        'duration',
        'upload_time',
        'music_file',
        'cover_image',
        'play_count',
        'status',
    ];

    // 定义模型与其他模型之间的关系
    public function singer()
    {
        return $this->belongsTo(Singer::class, 'singer_id');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'music_albums', 'music_id', 'album_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'music_tags', 'music_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id')->where('object_type', 'music');
    }
}
