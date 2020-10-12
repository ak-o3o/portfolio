<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'post_ja', 'post_en', 'reply_post_id',
    ];

    //リレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //タイムライン取得
    public function getUserTimeLine(Int $user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);
    }

    //post数取得
    public function getPostCount(Int $user_id)
    {
        return $this->where('user_id', $user_id)->count();
    }

    // 一覧画面
    public function getTimeLines(Int $user_id, array $follow_ids)
    {
        // 自身とフォローしているユーザIDを結合する
        $follow_ids[] = $user_id;

        return $this->whereIn('user_id', $follow_ids)->orderBy('created_at', 'DESC')->paginate(50);
    }

    //postを編集画面表示
    public function getEditPost(Int $user_id, Int $post_id)
    {
        return $this->where('user_id', $user_id)->where('id', $post_id)->first();
    }
    //postを編集(update)
    public function postUpdate(Int $post_id, array $data)
    {
        $this->id = $post_id;
        $this->post_ja = $data['post_ja'];
        $this->post_en = $data['post_en'];
        $this->update();

        return;
    }

    // 詳細画面
    public function getPost(Int $post_id)
    {
        return $this->with('user')->where('id', $post_id)->first();
    }

    //postを削除
    public function postDestroy(Int $user_id, Int $post_id)
    {
        return $this->where('user_id', $user_id)->where('id', $post_id)->delete();
    }
}
