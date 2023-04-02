@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3 class="mb-3">热门推荐</h3>
            <div class="row">
                @for($i = 0; $i < 4; $i++)
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">歌单标题</h5>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <h3 class="mb-3">最新音乐</h3>
            <div class="row">
                @for($i = 0; $i < 4; $i++)
                <div class="col-md-3">
                    <div class="card mb-4" >
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">音乐标题</h5>
                            <p class="card-text">歌手名</p>
                        </div>
                    </div>  
                </div>
                @endfor
            </div>
        </div>

        <div class="col-md-4">
            <h3 class="mb-3">热门歌手</h3>
            <ul class="list-group mb-4">
                @for($i = 0; $i < 5; $i++)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    歌手名
                    <span class="badge bg-primary rounded-pill">关注</span>
                </li>
                @endfor
            </ul>
        </div>
        
    </div>
</div>
@endsection
