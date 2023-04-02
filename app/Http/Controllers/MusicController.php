<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Music_tag;
use App\Models\Music_album;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    // 显示所有音乐
    public function index()
    {
        $musics = Music::all();
        return view('music.index', compact('musics'));
    }

    // 显示创建新音乐的表单
    public function create()
    {
        $music_tags = Music_tag::all();
        $music_albums = Music_album::all();
        return view('music.create', compact('music_tags', 'music_albums'));
    }

    // 保存新创建的音乐
    public function store(Request $request)
    {
        $request->validate([
            'singer_id' => 'required|integer',
            'title' => 'required|max:255',
            'duration' => 'required|integer',
            'upload_time' => 'required|date',
            'music_file' => 'required|mimes:mp3,wav,flac|max:20000',
            'cover_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $music = new Music($request->all());

        if ($request->hasFile('music_file')) {
            $music_file = $request->file('music_file');
            $music_file_name = time() . '.' . $music_file->getClientOriginalExtension();
            $music_file->move(public_path('uploads/music'), $music_file_name);
            $music->music_file = $music_file_name;
        }

        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image');
            $cover_image_name = time() . '.' . $cover_image->getClientOriginalExtension();
            $cover_image->move(public_path('uploads/covers'), $cover_image_name);
            $music->cover_image = $cover_image_name;
        }

        $music->save();
        $music->tags()->sync($request->tags);
        $music->albums()->sync($request->albums);

        return redirect()->route('music.index')->with('success', '音乐添加成功！');
    }

    // 显示指定音乐的详细信息
    public function show(Music $music)
    {
        return view('music.show', compact('music'));
    }

    // 显示编辑音乐的表单
    public function edit(Music $music)
    {
        $music_tags = Music_tag::all();
        $music_albums = Music_album::all();
        return view('music.edit', compact('music', 'music_tags', 'music_albums'));
    }
    // 更新指定音乐
    public function update(Request $request, Music $music)
    {
        $request->validate([
            'singer_id' => 'required|integer',
            'title' => 'required|max:255',
            'duration' => 'required|integer',
            'upload_time' => 'required|date',
            'music_file' => 'mimes:mp3,wav,flac|max:20000',
            'cover_image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('music_file')) {
            $music_file = $request->file('music_file');
            $music_file_name = time() . '.' . $music_file->getClientOriginalExtension();
            $music_file->move(public_path('uploads/music'), $music_file_name);
            $music->music_file = $music_file_name;
        }

        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image');
            $cover_image_name = time() . '.' . $cover_image->getClientOriginalExtension();
            $cover_image->move(public_path('uploads/covers'), $cover_image_name);
            $music->cover_image = $cover_image_name;
        }

        $music->update($request->all());
        $music->tags()->sync($request->tags);
        $music->albums()->sync($request->albums);

        return redirect()->route('music.index')->with('success', '音乐更新成功！');
    }

    // 删除指定音乐
    public function destroy(Music $music)
    {
        $music->delete();
        return redirect()->route('music.index')->with('success', '音乐删除成功！');
    }
}

