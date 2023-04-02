<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Singer;
use App\Models\Playlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // 显示首页
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        return view('home');
    }
    
    // 显示首页
    // public function index()
    // {
    //     // 从数据库中获取热门歌曲（根据播放次数降序排序，取前 10 条）
    //     $hotMusics = Music::orderBy('play_count', 'desc')
    //         ->take(10)
    //         ->get();

    //     // 从数据库中获取热门歌手（根据某种条件，例如关注量降序排序，取前 10 条）
    //     $hotSingers = Singer::orderBy('followers', 'desc')
    //         ->take(10)
    //         ->get();

    //     // 从数据库中获取热门歌单（根据收藏次数降序排序，取前 10 条）
    //     $hotPlaylists = Playlist::orderBy('favorite_count', 'desc')
    //         ->take(10)
    //         ->get();

    //     // 返回首页视图，并将查询到的数据传递给视图
    //     return view('home', [
    //         'hotMusics' => $hotMusics,
    //         'hotSingers' => $hotSingers,
    //         'hotPlaylists' => $hotPlaylists,
    //     ]);
    // }
}





