<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 显示注册表单
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 用户注册
    public function register(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'username' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
        ]);

        // 创建新用户
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 登录用户
        Auth::login($user);

        // 重定向到主页
        return redirect()->route('home');
    }

    // 显示登录表单
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 用户登录
    public function login(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 验证用户凭证并登录
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            // 登录成功，重定向到主页
            return redirect()->route('home');
        } else {
            // 登录失败，返回错误信息
            return back()->withErrors(['email' => '邮箱或者密码错误。']);
        }
    }

    // 显示用户个人资料
    public function showprofile()
    {
        // 获取当前登录用户
        $user = Auth::user();

        // 获取用户收藏
        $favorites = $user->favorites;

        // 获取播放历史（这需要在 User 模型中添加相应的关联方法）
        $play_history = $user->play_history;

        // 返回用户个人资料视图
        return view('user.profile', compact('user', 'favorites', 'play_history'));
    }

    // 更新用户个人资料
    public function updateProfile(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email',
        ]);

        // 获取当前登录用户
        $user = Auth::user();

        // 更新用户资料
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);

        // 重定向到个人资料页面
        return redirect()->route('user.profile');
    }

    // 用户登出
    public function logout()
    {
        // 登出用户
        Auth::logout();

        // 重定向到登录页面
        return redirect()->route('login');
    }
    
    // 添加收藏
    public function addFavorite(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'favorite_type' => 'required|in:music,playlist',
            'object_id' => 'required|integer',
        ]);

        // 获取当前登录用户
        $user = Auth::user();

        // 添加收藏
        $favorite = new User_favorite([
            'favorite_type' => $request->favorite_type,
            'object_id' => $request->object_id,
        ]);

        $user->favorites()->save($favorite);

        // 返回成功信息
        return back()->with('success', 'Favorite added successfully!');
    }

    // 移除收藏
    public function removeFavorite(Request $request)
    {
        // 验证请求数据
        $request->validate([
            'favorite_type' => 'required|in:music,playlist',
            'object_id' => 'required|integer',
        ]);

        // 获取当前登录用户
        $user = Auth::user();

        // 移除收藏
        $user->favorites()->where([
            'favorite_type' => $request->favorite_type,
            'object_id' => $request->object_id,
        ])->delete();

        // 返回成功信息
        return back()->with('success', 'Favorite removed successfully!');
    }
}
