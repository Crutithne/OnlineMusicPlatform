<!-- resources/views/singer/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ $singer->image }}" class="card-img-top" alt="{{ $singer->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $singer->name }}</h5>
                    <p class="card-text">{{ $singer->description }}</p>
                    <a href="#" class="btn btn-primary">关注歌手</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">歌曲</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($singer->musics as $music)
                            <li class="list-group-item">
                                <a href="{{ route('music.show', $music->id) }}">{{ $music->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">专辑</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($singer->albums as $album)
                            <li class="list-group-item">
                                <a href="{{ route('album.show', $album->id) }}">{{ $album->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
