<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Storage;
use Auth;
use File;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image_file', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //リレーション
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    public function vocabulary()
    {
        return $this->hasMany(Vocabulary::class);
    }

    //ユーザー一覧を取得
    public function getAllUsers(Int $user_id)
    {
        return $this->Where('id', '<>', $user_id)->paginate(5);
    }

    //フォローする
    public function follow(Int $user_id)
    {
        return $this->follows()->attach($user_id);
    }
    //フォローを解除する
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }
    //フォローしてているか
    public function isfollowing(Int $user_id)
    {
        return (bool) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }
    //フォローされているか
    public function isfollowed(Int $user_id)
    {
        return (bool) $this->followers()->where('followed_id', $user_id)->first(['id']);
    }

    //followersテーブルとユーザーIDの紐づけ
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }
    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }

    //プロファイル更新
    public function updateProfile(array $params)
    {

        //パラメーターに画像ファイルがあれば
        if (isset($params['profile_image'])) {

            // $file_name = $params['profile_image']->store('public/user_images');

            //s3
            $file = $params['profile_image'];
            $file_name = Storage::disk('s3')->putFile('/user_images', $file, 'public');

            $this::where('id', $this->id)
                ->update([
                    'name'          => $params['name'],
                    'image_file'    => basename($file_name),
                    'email'         => $params['email'],
                ]);
        } else {
            $this::where('id', $this->id)
                ->update([
                    'name'          => $params['name'],
                    'email'         => $params['email'],
                ]);
        }

        return;
    }
}
