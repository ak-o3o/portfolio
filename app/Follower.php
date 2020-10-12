<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    //フォロー数を取得
    public function getFollowCount($user_id)
    {
        return $this->where('following_id', $user_id)->count();
    }

    //フォローワー数を取得
    public function getFollowerCount($user_id)
    {
        return $this->where('followed_id', $user_id)->count();
    }

    // フォローしているユーザのIDを取得
    public function followingIds(Int $user_id)
    {
        return $this->where('following_id', $user_id)->get('followed_id');
    }
}
