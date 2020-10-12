<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    // いいねしているかどうかの判定処理
    public function isFavorite(Int $user_id, Int $post_id)
    {
        return (bool) $this->where('user_id', $user_id)->where('post_id', $post_id)->first();
    }

    public function storeFavorite(Int $user_id, Int $post_id)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->save();

        return;
    }

    public function destroyFavorite(Int $favorite_id)
    {
        return $this->where('id', $favorite_id)->delete();
    }
}
