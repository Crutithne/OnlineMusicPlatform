<!-- resources/views/playlist/create_edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">{{ $playlist->id ? '编辑歌单' : '创建歌单' }}</h2>
    <form method="POST" action="{{ $playlist->id ? route('playlist.update', $playlist->id) : route('playlist.store') }}" enctype="multipart/form-data">
        @csrf
        @if($playlist->id)
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="title" class="form-label">歌单标题</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $playlist->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="cover" class="form-label">歌单封面</label>
            <input type="file" class="form-control" id="cover" name="cover">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">歌单简介</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $playlist->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ $playlist->id ? '更新歌单' : '创建歌单' }}</button>
    </form>
</div>
@endsection
