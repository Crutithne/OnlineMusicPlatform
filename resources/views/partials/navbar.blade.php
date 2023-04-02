<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">在线音乐播放平台</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">音乐</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">歌手</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">歌单</a>
                </li>
            </ul>
            <form class="d-flex my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                <input class="form-control me-2" type="search" name="keyword" placeholder="搜索" aria-label="搜索" style="height: 30px;">
                <button class="btn btn-primary d-flex align-items-center justify-content-center" type="submit" style="color: white; height: 30px; width: 70px;">搜索</button>
            </form>

            <ul class="navbar-nav ms-auto">
                <!-- 如果用户已登录，显示用户名和个人中心链接 -->
                @if (Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ Auth::user()->username }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.show') }}">个人中心</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">登出</a>
                </li>
                @else
                <!-- 如果用户未登录，显示登录和注册链接 -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">登录</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">注册</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>