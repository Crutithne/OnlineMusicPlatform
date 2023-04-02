<?php

namespace App\Http\Controllers;

use App\Models\Singer;
use App\Models\Singer_tag;
use App\Models\Tag;
use Illuminate\Http\Request;

class SingerController extends Controller
{
    // 显示歌手列表
    public function index()
    {
        // 从数据库中获取所有歌手
        $singers = Singer::all();

        // 返回视图并传入歌手数据
        return view('singer.index', compact('singers'));
    }

    // 显示创建歌手表单
    public function create()
    {
        // 获取所有标签
        $tags = Tag::all();

        // 返回视图并传入标签数据
        return view('singer.create', compact('tags'));
    }

    // 将新创建的歌手存储到数据库
    public function store(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image',
            'introduction' => 'nullable',
            'tags' => 'nullable|array',
        ]);

        // 处理上传的图片
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('singers');
        } else {
            $image = null;
        }

        // 创建新的歌手
        $singer = Singer::create([
            'name' => $request->input('name'),
            'image' => $image,
            'introduction' => $request->input('introduction'),
        ]);

        // 为歌手添加标签
        if ($request->has('tags')) {
            $singer->tags()->attach($request->input('tags'));
        }

        // 返回到歌手列表并显示成功消息
        return redirect()->route('singer.index')->with('success', '歌手创建成功！');  
    }

    // 显示歌手详情
    public function show(Singer $singer)
    {
        // 返回视图并传入歌手数据
        return view('singer.show', compact('singer'));
    }

    // 显示编辑歌手表单
    public function edit(Singer $singer)
    {
        // 获取所有标签
        $tags = Tag::all();

        // 返回视图并传入歌手和标签数据
        return view('singer.edit', compact('singer', 'tags'));
    }

    // 更新指定歌手在数据库中的信息
    public function update(Request $request, Singer $singer)
    {
        // 验证请求数据
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image',
            'introduction' => 'nullable',
            'tags' => 'nullable|array',
        ]);

        // 处理上传的图片
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('singers');
            $singer->image = $image;
        }

        // 更新歌手信息
        $singer->update([
            'name' => $request->input('name'),
            'introduction' => $request->input('introduction'),
        ]);

        // 更新歌手标签
        $singer->tags()->sync($request->input('tags'));

        // 返回到歌手详情页并显示成功消息
        return redirect()->route('singer.show', $singer)->with('success', '歌手信息更新成功！');
    }

    // 删除指定歌手
    public function destroy(Singer $singer)
    {
        // 删除歌手记录
        $singer->delete();

        // 返回到歌手列表并显示成功消息
        return redirect()->route('singer.index')->with('success', '歌手删除成功！');
    }
}
    
    
