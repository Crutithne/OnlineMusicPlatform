<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'songid',
        'artist',
        'album',
        'duration',
        'cover_image',
        'url',
        'status',
    ];

    /**
     * The playlists that belong to the song.
     */
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_songs');
    }
}
