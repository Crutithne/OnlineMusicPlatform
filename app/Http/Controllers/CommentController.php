<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reply;
use App\Models\Report;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // 显示评论列表
    public function index(string $objectType, int $objectId)
    {
        // 获取评论
        $comments = Comment::where('object_type', $objectType)
            ->where('object_id', $objectId)
            ->get();

        return view('comment.index', compact('comments'));
    }

    // 添加评论
    public function store(Request $request, string $objectType, int $objectId)
    {
        // 验证请求数据
        $request->validate([
            'content' => 'required|max:255',
        ]);

        // 创建评论
        Comment::create([
            'user_id' => auth()->user()->id,
            'object_type' => $objectType,
            'object_id' => $objectId,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', '评论已添加');
    }


    // 添加回复
    public function storeReply(Request $request, int $commentId)
    {
        // 验证请求数据
        $request->validate([
            'content' => 'required|max:255',
        ]);

        // 创建回复
        Reply::create([
            'comment_id' => $commentId,
            'user_id' => auth()->user()->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', '回复已添加');
    }

    // 举报评论
    public function report(Request $request, int $commentId)
    {
        // 验证请求数据
        $request->validate([
            'reason' => 'required|max:255',
        ]);

        // 创建举报
        Report::create([
            'comment_id' => $commentId,
            'user_id' => auth()->user()->id,
            'reason' => $request->input('reason'),
        ]);

        return back()->with('success', '举报已提交');
    }
}
