<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Storage;
use League\Flysystem\Filesystem;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        //バリテーション
        $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4'
        ]);

        //imgがあれば保存し、ファイルパスを取得
        if ($request->hasFile('image_file')) {

            // $ext = '.' . $request->file('image_file')->extension();
            // Storage::disk('public')->putFileAs('user_images', $request->file('image_file'), $request->input('name') . '_usrimg' . $ext);
            // $img_path = storage_path('user_images/' . $request->input('name') . '_usrimg' . $ext);
            // $file_name = basename($img_path);
            //heroku用(バイナリで保存)
            $file_name = base64_encode(file_get_contents($request->file('image_file')));

            //DBインサート
            $member = new User([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'image_file' => $file_name,
            ]);

            //保存
            $member->save();

            //登録後の画面表示
            return view('after_register.after_register');
        } else {

            //DBインサート
            $member = new User([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);

            //保存
            $member->save();

            //登録後の画面表示
            return view('after_register.after_register');
        }
    }

    public function login(Request $request)
    {
        //バリデーション
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);

        if (Auth::check()) {
            return redirect()->route('home');
        }

        //認証
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->route('home');
        }
        return redirect()->back();
    }

    public function logout()
    {
        //ログアウト
        Auth::logout();

        //topページにリダイレクト
        return redirect()->route('top');
    }

    //ゲストログイン機能
    public function authenticate()
    {
        $email = 'guest@guest.com';
        $password = 'guestpass';

        if (\Auth::attempt(['email' => $email, 'password' => $password])) {
            // 認証に成功した
            return redirect()->route('home');
        }
        return back();
    }
}
