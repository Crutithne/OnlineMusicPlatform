<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Singer extends Model
{
    use HasFactory;

    // 可以批量赋值的字段
    protected $fillable = [
        'name',
        'image',
        'introduction',
        'create_time',
        'status',
    ];

    // 定义模型与其他模型之间的关系
    public function musics()
    {
        return $this->hasMany(Music::class, 'singer_id');
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'singer_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'singer_tags', 'singer_id', 'tag_id');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
