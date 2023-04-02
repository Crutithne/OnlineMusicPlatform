<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\SingerController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;

// HomeController 路由
// 显示主页
Route::get('/', [HomeController::class, 'index'])->name('home');

//测试
Route::get('/test', [HomeController::class, 'test']);


// UserController 路由
// 显示注册页面
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register.show');

// 提交注册表单
Route::post('/register', [UserController::class, 'register'])->name('register');

// 显示登录页面
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.show');

// 提交登录表单
Route::post('/login', [UserController::class, 'login'])->name('login');

// 登出
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// 显示个人资料
Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show')->middleware('auth');

// 更新个人资料
Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

// 添加收藏
Route::post('/favorites/add', [UserController::class, 'addFavorite'])->name('favorites.add')->middleware('auth');

// 移除收藏
Route::post('/favorites/remove', [UserController::class, 'removeFavorite'])->name('favorites.remove')->middleware('auth');


// SingerController 路由
// 显示歌手列表
Route::get('/singers', [SingerController::class, 'index'])->name('singers.index');

// 显示创建新歌手表单
Route::get('/singers/create', [SingerController::class, 'create'])->name('singers.create');

// 处理创建新歌手的请求
Route::post('/singers', [SingerController::class, 'store'])->name('singers.store');

// 显示指定歌手的详情
Route::get('/singers/{singer}', [SingerController::class, 'show'])->name('singers.show');

// 显示编辑指定歌手表单
Route::get('/singers/{singer}/edit', [SingerController::class, 'edit'])->name('singers.edit');

// 处理更新指定歌手信息的请求
Route::put('/singers/{singer}', [SingerController::class, 'update'])->name('singers.update');

// 删除指定歌手
Route::delete('/singers/{singer}', [SingerController::class, 'destroy'])->name('singers.destroy');


// SearchController 路由
// 搜索
Route::get('/search', [SearchController::class, 'search'])
    ->name('search')
    ->middleware('web');


// PlaylistController 路由
// 获取所有歌单
Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlist.index');

// 显示创建歌单表单
Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlist.create');

// 提交新歌单
Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlist.store');

// 显示指定歌单详情
Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlist.show');

// 显示编辑歌单表单
Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');

// 更新歌单信息
Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlist.update');

// 删除歌单
Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlist.destroy');

// 创建试听歌单
Route::post('/playlist/createDefault', [PlaylistController::class, 'createDefaultPlaylist'])->middleware(['auth'])->name('playlist.createDefault');

// 添加歌曲到试听歌单
Route::post('/playlist/{playlistID}/addSong', [PlaylistController::class, 'addSongToPlaylist'])->middleware(['auth'])->name('playlist.addSong');

// 获取最新试听歌单
Route::get('/playlist/listening', [PlaylistController::class, 'getListeningPlaylist'])->middleware(['auth'])->name('playlist.listening');

// 加载页面获取试听列表
Route::get('/playlist/default/data', [PlaylistController::class, 'getDefaultPlaylistData'])->middleware(['auth'])->name('playlist.defaultData');




// MusicController 路由定义
// 显示所有音乐列表
Route::get('/musics', [MusicController::class,'index'])->name('musics.index');

// 显示创建新音乐的表单
Route::get('/musics/create', [MusicController::class,'create'])->name('musics.create');

// 处理新音乐的表单提交
Route::post('/musics', [MusicController::class,'store'])->name('musics.store');

// 显示特定音乐的详细信息
Route::get('/musics/{music}', [MusicController::class,'show'])->name('musics.show');

// 显示编辑特定音乐的表单
Route::get('/musics/{music}/edit', [MusicController::class,'edit'])->name('musics.edit');

// 处理特定音乐的表单更新提交
Route::put('/musics/{music}', [MusicController::class,'update'])->name('musics.update');

// 删除特定音乐
Route::delete('/musics/{music}', [MusicController::class,'destroy'])->name('musics.destroy');


// CommentController 路由
// 显示评论列表
// URL 示例: /comments/music/1
Route::get('comments/{objectType}/{objectId}', [CommentController::class, 'index'])->name('comments.index');

// 添加评论
// URL 示例: /comments/music/1
Route::post('comments/{objectType}/{objectId}', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

// 添加回复
// URL 示例: /comments/replies/1
Route::post('comments/replies/{commentId}', [CommentController::class, 'storeReply'])->middleware('auth')->name('comments.storeReply');

// 举报评论
// URL 示例: /comments/report/1
Route::post('comments/report/{commentId}', [CommentController::class, 'report'])->middleware('auth')->name('comments.report');







// 用户路由
// Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register.form');
// Route::post('/register', [UserController::class, 'register'])->name('register');
// Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.form');
// Route::post('/login', [UserController::class, 'login'])->name('login');
// Route::post('/logout', [UserController::class, 'logout'])->name('logout');
// // Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
// // Route::post('/login', [UserController::class, 'login']);
// // Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
// // Route::post('/register', [UserController::class, 'register']);
// Route::get('/profile', [UserController::class, 'profile'])->name('profile');
// Route::get('/user/profile', 'UserController@profile')->name('user.profile')->middleware('auth');
// Route::get('/favorites', [UserController::class, 'favorites'])->name('favorites');
// Route::get('/history', [UserController::class, 'history'])->name('history');



// // 音乐路由
// Route::get('/music', [MusicController::class, 'index'])->name('music.index');
// Route::get('/music/{id}', [MusicController::class, 'show'])->name('music.show');
// // Route::get('/music/{id}', 'MusicController@show')->name('music.show');


// // 歌手路由
// Route::get('/singer', [SingerController::class, 'index'])->name('singer.index');
// Route::get('/singer/{id}', [SingerController::class, 'show'])->name('singer.show');

// // 歌单路由
// Route::get('/playlist', [PlaylistController::class, 'index'])->name('playlist.index');
// Route::get('/playlist/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
// Route::get('/playlist/create', [PlaylistController::class, 'create'])->name('playlist.create');
// Route::post('/playlist', [PlaylistController::class, 'store'])->name('playlist.store');
// Route::get('/playlist/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
// Route::put('/playlist/{id}', [PlaylistController::class, 'update'])->name('playlist.update');

// // 评论路由
// Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');

// //资源路由
// Route::resource('users', UserController::class);
// Route::resource('musics', MusicController::class);
// Route::resource('singers', SingerController::class);
// Route::resource('playlists', PlaylistController::class);
// Route::resource('comments', CommentController::class);
