<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'singer_id',
        'name',
        'cover_image',
        'release_time',
        'status',
    ];

    protected $casts = [
        'release_time' => 'datetime',
    ];

    public function singer()
    {
        return $this->belongsTo(Singer::class);
    }

    public function musics()
    {
        return $this->belongsToMany(Music::class, 'music_albums');
    }
}
