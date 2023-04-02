<!-- resources/views/music/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ $music->cover_image }}" class="card-img-top" alt="{{ $music->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $music->title }}</h5>
                    <p class="card-text">歌手：<a href="{{ route('singer.show', $music->singer->id) }}">{{ $music->singer->name }}</a></p>
                    <p class="card-text">时长：{{ $music->duration }}</p>
                    <p class="card-text">上传时间：{{ $music->created_at }}</p>
                    <p class="card-text">播放次数：{{ $music->play_count }}</p>
                    <a href="#" class="btn btn-primary">播放</a>
                    <a href="#" class="btn btn-secondary">添加到歌单</a>
                    <a href="#" class="btn btn-success">收藏</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">歌词</div>
                <div class="card-body">
                    <pre>{{ $music->lyrics }}</pre>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">评论</div>
                <div class="card-body">
                    <!-- 这里可以添加评论表单和评论列表的代码 -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
