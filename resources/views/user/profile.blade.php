<!-- resources/views/user/profile.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">个人资料</div>
                <div class="card-body">
                    <p>用户名：{{ $user->username }}</p>
                    <p>邮箱：{{ $user->email }}</p>
                    <p>头像：<img src="{{ $user->avatar }}" alt="{{ $user->username }}" width="100" /></p>
                    <p>注册时间：{{ $user->created_at }}</p>
                    <p>最后登录时间：{{ $user->last_login_time }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">收藏的音乐</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($user->favorite_musics as $music)
                            <li class="list-group-item">
                                <a href="{{ route('music.show', $music->id) }}">{{ $music->title }}</a> - {{ $music->singer->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">收藏的歌单</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($user->favorite_playlists as $playlist)
                            <li class="list-group-item">
                                <a href="{{ route('playlist.show', $playlist->id) }}">{{ $playlist->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">播放历史</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($user->play_history as $music)
                            <li class="list-group-item">
                                <a href="{{ route('music.show', $music->id) }}">{{ $music->title }}</a> - {{ $music->singer->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
