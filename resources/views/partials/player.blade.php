<!-- player.blade.php -->
<div class="player fixed-bottom bg-light py-2"> <!-- 设置播放器为固定在底部，且背景为浅色 -->
    <div class="container">
        <div class="row">
            <div class="col-3 d-flex align-items-center">
                <img src="album-cover-url" alt="Album Cover" class="img-thumbnail" width="60" height="60"> <!-- 专辑图片，替换为实际的图片 URL -->
                <div class="ms-2">
                    <p class="mb-0">歌曲名称</p> <!-- 显示歌曲名称 -->
                    <p class="mb-0">歌手</p> <!-- 显示歌手 -->
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <!-- 播放器控制按钮 -->
                    <button id="previous-btn" class="btn btn-outline-secondary me-2">上一首</button> <!-- 上一首按钮 -->
                    <button id="play-pause-btn" class="btn btn-outline-primary me-2">播放</button> <!-- 播放按钮 -->
                    <button id="next-btn" class="btn btn-outline-secondary me-2">下一首</button> <!-- 下一首按钮 -->
                    <button class="btn btn-outline-secondary">随机</button> <!-- 随机播放按钮 -->
                </div>
                <div class="d-flex align-items-center mb-2">
                    <small class="text-muted">0:00</small> <!-- 当前播放时间 -->
                    <div class="progress mx-2 flex-grow-1"> <!-- 播放进度条 -->
                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">3:30</small> <!-- 歌曲总时间 -->
                </div>
                <!-- 歌词显示区域 -->
                <div class="lyrics text-center">
                    <p id="lyrics-text">歌词加载中...</p>
                </div>
            </div>
            <div class="col-3 d-flex align-items-center">
                <button class="btn btn-outline-secondary ms-auto me-2">音量</button> <!-- 音量按钮 -->
                <input type="range" class="form-range" min="0" max="100" value="75"> <!-- 音量控制滑块 -->
                <button id="playlist-toggle" class="btn btn-outline-secondary ms-2">播放列表</button> <!-- 播放列表按钮 -->
            </div>
        </div>
    </div>
    <!-- 添加一个隐藏的音频播放器实例，用于播放音乐 -->
    <audio id="player-instance" onended="playNextSong()" controls preload="none" style="display: none;"></audio>
</div>

<!-- 添加播放列表的 HTML 结构 -->
<div id="playlist" class="playlist card" style="display:none; width: 300px; margin-bottom: 50px;">
    <div class="card-header">
        播放列表
    </div>
    <ul class="list-group list-group-flush" id="playlist-list">
        <!-- 此处不再需要遍历 $playlist，因为我们将使用 JavaScript 动态添加列表项 -->
    </ul>
</div>


<!-- 添加 JavaScript 代码处理点击事件 -->
<script>
    const audioPlayer = document.getElementById('player-instance');
    const playPauseButton = document.getElementById('play-pause-btn');

    playPauseButton.addEventListener('click', () => {
        if (audioPlayer.paused) {
            audioPlayer.play();
            playPauseButton.textContent = '暂停';
        } else {
            audioPlayer.pause();
            playPauseButton.textContent = '播放';
        }
    });



    // 获取播放列表和播放列表按钮元素
    const playlist = document.getElementById('playlist');
    const playlistToggle = document.getElementById('playlist-toggle');

    // 为播放列表按钮添加点击事件
    playlistToggle.addEventListener('click', async () => {
        playlist.style.display = playlist.style.display === 'none' ? 'block' : 'none';

        // 获取最新的试听歌单
        const response = await fetch('/playlist/listening', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        if (response.status === 200) {
            const data = await response.json();
            const songs = data.songs;

            // 更新播放列表
            const playlistList = playlist.querySelector('.list-group');
            playlistList.innerHTML = '';

            songs.forEach(song => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';

                const title = document.createElement('span');
                title.className = 'song-title ms-2';
                title.textContent = song.title;

                const artist = document.createElement('span');
                artist.className = 'song-artist ms-2';
                artist.textContent = song.artist;

                listItem.appendChild(title);
                listItem.appendChild(artist);

                playlistList.appendChild(listItem);
            });
        } else {
            console.error('获取试听歌单失败，状态码:', response.status);
        }
    });

    async function fetchDefaultPlaylistData() {
        try {
            const response = await fetch('/playlist/default/data');
            if (response.status === 200) {
                const data = await response.json();
                const songList = document.querySelector('#playlist .list-group');
                songList.innerHTML = '';

                data.songs.forEach(song => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');
                    listItem.innerHTML = `
                    <span class="song-title ms-2">${song.title}</span>
                    <span class="song-artist ms-2">${song.artist}</span>
                `;

                    songList.appendChild(listItem);
                });
            } else {
                console.error('获取试听歌单数据失败，状态码:', response.status);
            }
        } catch (error) {
            console.error('获取试听歌单数据时出现错误:', error);
        }
    }

    // 在页面加载时获取试听歌单数据
    document.addEventListener('DOMContentLoaded', fetchDefaultPlaylistData);
</script>