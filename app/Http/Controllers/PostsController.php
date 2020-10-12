<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\Comment;
use App\Follower;
use App\Vocabulary;
use App\Post as AppPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post, Follower $follower, Vocabulary $vocabulary)
    {
        //posts用
        $user = auth()->user();
        $follow_ids = $follower->followingIds($user->id);

        //vocabulary用
        $vocabularies = $vocabulary->getVocabularies($user->id);

        //follow_idだけ抜き出す(posts用)
        $following_ids = $follow_ids->pluck('followed_id')->toArray();
        $timelines = $post->getTimelines($user->id, $following_ids);

        return view('posts.index', [
            'user' => $user,
            'timelines' => $timelines,
            'vocabularies' => $vocabularies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //post作成画面
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //postを投稿
        {
            //バリデーション
            $this->validate($request, [
                'post_ja' => 'required|string|max:200|min:20',
                'post_en' => 'required|string|max:200|min:20',
            ]);

            //DBインサート
            $post = new Post([
                'user_id' => Auth::id(),
                'post_ja' => $request->input('post_ja'),
                'post_en' => $request->input('post_en'),
            ]);

            //保存
            $post->save();

            //homeにリダイレクト
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Comment $comment)
    {
        //postの詳細ページ
        $user = auth()->user();
        $post = $post->getpost($post->id);
        $comments = $comment->getComments($post->id);

        return view('posts.show', [
            'user'     => $user,
            'post' => $post,
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //編集画面表示
        $user = auth()->user();
        $posts = $post->getEditPost($user->id, $post->id);

        if (!isset($posts)) {
            return redirect('home');
        }

        return view('posts.edit', [
            'user'   => $user,
            'posts' => $posts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //post編集処理
        $data = $request->all();
        $validator = Validator::make($data, [
            'post_ja' => ['required', 'string', 'max:140'],
            'post_en' => ['required', 'string', 'max:140']
        ]);

        $validator->validate();
        $post->postUpdate($post->id, $data);

        return redirect('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $user = auth()->user();
        $post->postDestroy($user->id, $post->id);

        return back();
    }
}
