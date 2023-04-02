<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Playlist_tags;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Models\Song;

class PlaylistController extends Controller
{
    // 显示所有歌单
    public function index()
    {
        $playlists = Playlist::all();
        return view('playlist.index', compact('playlists'));
    }

    // 显示创建歌单表单
    public function create()
    {
        $tags = Tag::all();
        return view('playlist.create', compact('tags'));
    }

    // 处理创建歌单表单提交的数据
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'cover_image' => 'image|nullable|max:1999',
            'description' => 'nullable',
            'tags' => 'array|nullable',
        ]);

        if ($request->hasFile('cover_image')) {
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $playlist = new Playlist([
            'title' => $request->title,
            'cover_image' => $fileNameToStore,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);
        $playlist->save();

        if (!empty($request->tags)) {
            $playlist->tags()->sync($request->tags);
        }

        return redirect()->route('playlist.index')->with('success', '歌单创建成功！');
    }

    // 显示指定歌单详情
    public function show(Playlist $playlist)
    {
        return view('playlist.show', compact('playlist'));
    }

    // 显示编辑歌单表单
    public function edit(Playlist $playlist)
    {
        $tags = Tag::all();
        return view('playlist.edit', compact('playlist', 'tags'));
    }

    // 处理编辑歌单表单提交的数据
    public function update(Request $request, Playlist $playlist)
    {
        $request->validate([
            'title' => 'required|max:255',
            'cover_image' => 'image|nullable|max:1999',
            'description' => 'nullable',
            'tags' => 'array|nullable',
        ]);

        if ($request->hasFile('cover_image')) {
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            $playlist->cover_image = $fileNameToStore;
        }

        $playlist->title = $request->title;
        $playlist->description = $request->description;
        $playlist->save();

        if (!empty($request->tags)) {
            $playlist->tags()->sync($request->tags);
        } else {
            $playlist->tags()->detach();
        }

        return redirect()->route('playlist.index')->with('success', '歌单更新成功！');
    }

    // 删除指定歌单
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route('playlist.index')->with('success', '歌单删除成功！');
    }

    // 创建默认试听歌单
    public function createDefaultPlaylist(Request $request)
    {
        $user = Auth::user();
        // \Log::info('User ID:', ['user_id' => $user->id]); // 添加调试信息

        $defaultPlaylist = $user->playlists()->where('title', '默认试听列表')->first();
        // \Log::info('Default playlist found:', ['defaultPlaylist' => $defaultPlaylist]); // 添加调试信息

        if (!$defaultPlaylist) {
            $defaultPlaylist = new Playlist([
                'title' => '默认试听列表',
                'user_id' => $user->id,
            ]);
            $defaultPlaylist->save();
        }

        return response()->json(['playlist_id' => $defaultPlaylist->id]);
    }

    // 添加歌曲到试听歌单
    public function addSongToPlaylist(Request $request, $playlistId)
    {
        $songId = $request->json('song_id');
        $songData = $request->input('song_data');
        $songUrl = $request->input('song_url');
        $playlist = Playlist::findOrFail($playlistId);
        // \Log::debug('Song data:', ['song_data' => $songData]);

        // 验证用户是否拥有该播放列表
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['error' => '无权操作'], 403);
        }

        // 检查歌曲是否已存在于 songs 表中
        $song = Song::where('songid', $songId)->first();

        // 如果歌曲不存在，则将其插入到 songs 表中
        if (!$song) {
            $song = new Song([
                // 'id' => $songData['id'],
                'songid' => $songData['id'],
                'title' => $songData['name'],
                'artist' => $songData['ar'][0]['name'],
                'url' => $songUrl,
                // 其他需要的歌曲信息
            ]);
            $song->save();
        }

        // 检查歌曲是否已经存在于播放列表中
        if ($playlist->songs->contains('songid', $songId)) {
            return response()->json(['error' => '歌曲已存在'], 400);
        }

        // 将歌曲添加到播放列表
        $playlist->songs()->attach($song->id);
        return response()->json(['message' => '歌曲添加成功']);
    }

    // 获取试听歌单列表
    public function getListeningPlaylist()
    {
        $user = Auth::user();
        $defaultPlaylist = $user->playlists()->where('title', '默认试听列表')->first();

        if ($defaultPlaylist) {
            return response()->json(['songs' => $defaultPlaylist->songs]);
        } else {
            return response()->json(['error' => '试听歌单未找到'], 404);
        }
    }

    // 加载页面获取试听歌单列表
    public function getDefaultPlaylistData(Request $request)
    {
        $user = Auth::user();
        $defaultPlaylist = $user->playlists()->where('title', '默认试听列表')->first();

        if ($defaultPlaylist) {
            $songs = $defaultPlaylist->songs;
            return response()->json(['songs' => $songs]);
        } else {
            return response()->json(['error' => '试听歌单不存在'], 404);
        }
    }
}
