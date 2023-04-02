<!-- resources/views/search/results.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">搜索结果</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">音乐</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">封面</th>
                                <th scope="col">歌曲</th>
                                <th scope="col">歌手</th>
                                <th scope="col">专辑</th>
                                <th scope="col">时长</th>
                                <th scope="col">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($songs as $song)
                            <tr>
                                <td style="vertical-align: middle;">
                                    <img src="{{ $song['al']['picUrl'] }}" alt="{{ $song['name'] }}" width="31" height="31">
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="#">{{ $song['name'] }}</a>
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="#">{{ $song['ar'][0]['name'] }}</a>
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="#">{{ $song['al']['name'] }}</a>
                                </td>
                                <td style="vertical-align: middle;">{{ gmdate("i:s", $song['dt'] / 1000) }}</td>
                                <td style="vertical-align: middle;">
                                    <button class="btn btn-primary btn-sm play-btn" data-id="{{ $song['id'] }}" data-song="{{ json_encode($song) }}">试听</button>
                                    <button class="btn btn-success btn-sm">收藏</button>
                                    <button class="btn btn-danger btn-sm">下载</button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <!-- 如果还有上一页，显示上一页按钮 -->

                            <a href="" class="btn btn-primary btn-sm">&lt; 上一页</a>

                        </div>
                        <div class="text-center">
                            <!-- 显示当前页码 -->
                            第  页，共  页
                        </div>
                        <div>
                            <!-- 如果还有下一页，显示下一页按钮 -->

                            <a href="" class="btn btn-primary btn-sm">下一页 &gt;</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 添加一个全局变量来存储当前的播放列表
    let playlistData = [];

    // 获取播放器实例
    const playerInstance = document.getElementById('player-instance');

    // 为每个试听按钮添加事件监听器
    document.querySelectorAll('.play-btn').forEach((button) => {
        button.addEventListener('click', async (event) => {
            const songId = event.target.dataset.id;

            const songData = JSON.parse(event.target.dataset.song);
            const songUrl = await getSongUrl(songId);
            if (songUrl) {
                // 将歌曲添加到播放列表
                playlistData.push({
                    song_id: songId,
                    song_data: songData,
                    song_url: songUrl
                });

                // 播放添加的歌曲
                playerInstance.src = songUrl;
                playerInstance.play();
                playPauseButton.textContent = '暂停';
                // 更新播放器组件的歌曲信息
                updatePlayerInfo(songData);
            } else {
                alert('获取音乐播放链接失败');
            }
        });
    });


    // 获取歌曲播放链接的函数
    async function getSongUrl(songId) {
        const response = await fetch(`http://localhost:3000/song/url?id=${songId}`);
        if (response.status === 200) {
            const data = await response.json();
            return data.data[0].url;
        } else {
            console.error('获取音乐播放链接失败，状态码:', response.status);
            return null;
        }
    }

    // 更新播放器组件的歌曲信息
    function updatePlayerInfo(songData) {
        // 获取需要更新的元素
        const albumCover = document.querySelector('.player img');
        const songName = document.querySelector('.player .mb-0:nth-child(1)');
        const artistName = document.querySelector('.player .mb-0:nth-child(2)');

        // 更新元素的内容
        albumCover.src = songData['al']['picUrl'];
        songName.textContent = songData['name'];
        artistName.textContent = songData['ar'][0]['name'];
    }

    async function getDefaultPlaylist() {
        // 获取 CSRF 令牌
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch('/playlist/createDefault', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        // 检查响应状态码
        if (response.status === 200) {
            const data = await response.json();
            console.log('默认播放列表 ID:', data.playlist_id); // 添加调试信息
            return data.playlist_id;
        } else {
            console.error('获取默认播放列表失败，状态码:', response.status); // 添加调试信息
            alert('请先登录！');
        }
    }

    document.querySelectorAll('.play-btn').forEach((button) => {
        button.addEventListener('click', async (event) => {
            console.log('试听按钮被点击');
            const songId = event.target.dataset.id;

            const songUrl = await getSongUrl(songId);
            // if (songUrl) {
            //     const player = document.querySelector('#player-instance');
            //     player.src = songUrl;
            //     player.play();
            // } else {
            //     alert('获取音乐播放链接失败');
            // }

            // 获取默认播放列表
            const defaultPlaylistId = await getDefaultPlaylist();

            const songData = JSON.parse(event.target.dataset.song);
            // 向后端发送请求，将歌曲添加到试听列表
            try {
                const response = await fetch(`/playlist/${defaultPlaylistId}/addSong`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        song_id: songId,
                        song_data: songData, // 添加歌曲详细数据到请求主体中
                        song_url: songUrl
                    })
                });


                if (response.ok) {
                    alert('歌曲已添加到试听列表');

                    // 添加歌曲信息到播放器组件的 playlistData 数组
                    playlistData.push({
                        song_id: songId,
                        song_data: songData,
                        song_url: songUrl
                    });

                    // 播放添加的歌曲
                    currentIndex = playlistData.length - 1;
                    playSong(currentIndex);
                } else {
                    const error = await response.json();
                    if (error.error === '歌曲已存在') {
                        alert('歌曲已在试听列表中');
                    } else {
                        alert(`无法添加歌曲：${error.error}`);
                    }
                }

            } catch (error) {
                alert(`请求失败：${error.message}`);
            }

            // 在添加歌曲到试听列表之后，立即更新播放列表
            await fetchDefaultPlaylistData();

        });
    });

    async function getSongUrl(songId) {
        const response = await fetch(`http://localhost:3000/song/url?id=${songId}`);
        if (response.status === 200) {
            const data = await response.json();
            return data.data[0].url;
        } else {
            console.error('获取音乐播放链接失败，状态码:', response.status);
            return null;
        }
    }
</script>

@endpush