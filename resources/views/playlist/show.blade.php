<!-- resources/views/playlist/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ $playlist->cover }}" class="card-img-top" alt="{{ $playlist->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $playlist->title }}</h5>
                    <p class="card-text">{{ $playlist->description }}</p>
                    <a href="#" class="btn btn-primary">收藏歌单</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">歌曲列表</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($playlist->musics as $music)
                            <li class="list-group-item">
                                <a href="{{ route('music.show', $music->id) }}">{{ $music->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
