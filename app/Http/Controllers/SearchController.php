<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Models\Singer;
use App\Models\Playlist;
use GuzzleHttp\Client;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class SearchController extends Controller
{
    // 根据关键词搜索音乐、歌手和歌单
    public function search(Request $request)
    {
        // 从请求中获取关键词和页码
        $keyword = $request->input('keyword');
        $page = $request->input('page', 1);

        // 如果关键词为空，重定向到首页
        if (empty($keyword)) {
            return redirect('/');
        }

        // 实例化 Guzzle HTTP 客户端
        $client = new Client();

        // 调用网易云音乐 API 进行搜索
        $songResponse = $client->get('http://localhost:3000/cloudsearch', [
            'query' => [
                'keywords' => $keyword,
                'type' => 1, // 搜索类型：1 表示单曲
                'offset' => ($page - 1) * 15, // 偏移量
                'limit' => 15, // 每页数量
            ]
        ]);

        $singerResponse = $client->get('http://localhost:3000/cloudsearch', [
            'query' => [
                'keywords' => $keyword,
                'type' => 100, // 搜索类型：100 表示歌手
                'offset' => ($page - 1) * 15, // 偏移量
                'limit' => 15, // 每页数量
            ]
        ]);

        $playlistResponse = $client->get('http://localhost:3000/cloudsearch', [
            'query' => [
                'keywords' => $keyword,
                'type' => 1000, // 搜索类型：1000 表示歌单
                'offset' => ($page - 1) * 15, // 偏移量
                'limit' => 15, // 每页数量
            ]
        ]);

        // 解析 JSON 响应
        $songData = json_decode($songResponse->getBody(), true);
        $singerData = json_decode($singerResponse->getBody(), true);
        $playlistData = json_decode($playlistResponse->getBody(), true);

        // 获取搜索结果
        $songs = $songData['result']['songs'];
        $singers = $singerData['result']['artists'];
        $playlists = $playlistData['result']['playlists'];

        // 返回视图并将搜索结果传递给视图
        return view('search.results', [
            'keyword' => $keyword,
            'songs' => $songs,
            'singers' => $singers,
            'playlists' => $playlists,
        ]);
    }

}
