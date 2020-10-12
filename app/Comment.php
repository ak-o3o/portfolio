<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    //リレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    //詳細画面
    public function getComments(Int $post_id)
    {
        return $this->with('user')->where('post_id', $post_id)->get();
    }

    //コメント
    public function commentStore(Int $user_id, array $data)
    {
        $this->user_id = $user_id;
        $this->post_id = $data['post_id'];
        $this->comment = $data['comment'];
        $this->save();

        return;
    }
}
