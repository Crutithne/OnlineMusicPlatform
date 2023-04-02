<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistSongTable extends Migration
{
    public function up()
    {
        Schema::create('playlist_songs', function (Blueprint $table) {
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedBigInteger('song_id');
        
            // 添加外键约束
            $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade');
            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
        
            $table->primary(['playlist_id', 'song_id']);
        });
        
    }


    public function down()
    {
        Schema::dropIfExists('playlist_song');
    }
}
