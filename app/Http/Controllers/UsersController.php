<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Follower;
use App\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Storage;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //ユーザー一覧表示
    public function index(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);
        return view('users.index', [
            'all_users' => $all_users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //user画面
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //投稿の詳細、個別ページの表示
    public function show(User $user, Post $post, Follower $follower)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $timelines = $post->getUserTimeLine($user->id);
        $post_count = $post->getPostCount($user->id);
        $follow_count = $follower->getFollowCount($user->id);
        $follower_count = $follower->getFollowerCount($user->id);

        return view('users.show', [
            'user'           => $user,
            'is_following'   => $is_following,
            'is_followed'    => $is_followed,
            'timelines'      => $timelines,
            'post_count'    => $post_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //user編集画面
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //user編集処理、validation
        $data = $request->all();
        //バリデーション
        $validator = Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ]);
        $validator->validate();
        $user->updateProfile($data);

        return redirect('users/' . $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //post削除
    }

    //フォロー機能
    public function follow(User $user)
    {
        $follower = auth()->user();
        //フォローしているか判定
        $is_following = $follower->isFollowing($user->id);
        if (!$is_following) {
            //フォローしていなければフォローする
            $follower->follow($user->id);
            return back();
        }
    }

    //フォロー解除機能
    public function unfollow(User $user)
    {
        $follower = auth()->user();
        //フォローしているか判定
        $is_following = $follower->isFollowing($user->id);
        if ($is_following) {
            //フォローしていれば解除する
            $follower->unfollow($user->id);
            return back();
        }
    }
}
