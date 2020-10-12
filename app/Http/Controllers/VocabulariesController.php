<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vocabulary;
use Auth;
use Illuminate\Support\Facades\Validator;

class VocabulariesController extends Controller
{
    public function index()
    {
        //postsコントローラーに記載
    }

    // 追加処理
    public function store(Request $request)
    {
        //バリデーション
        $this->validate($request, [
            'vocabulary_ja' => 'required|string|max:200',
            'vocabulary_en' => 'required|string|max:200',
        ]);

        //DBインサート
        $vocabulary = new Vocabulary([
            'user_id' => Auth::id(),
            'vocabulary_ja' => $request->input('vocabulary_ja'),
            'vocabulary_en' => $request->input('vocabulary_en'),
        ]);

        //保存
        $vocabulary->save();

        //homeにリダイレクト
        return redirect()->route('home');
    }

    //編集画面
    public function edit(Vocabulary $vocabulary)
    {
        return view('vocabularies.edit')->with('vocabulary', $vocabulary);
    }

    public function update(Request $request, Vocabulary $vocabulary)
    {

        //vocabulary編集処理
        $data = $request->all();
        $validator = Validator::make($data, [
            'vocabulary_ja' => ['required', 'string', 'max:140'],
            'vocabulary_en' => ['required', 'string', 'max:140']
        ]);

        $validator->validate();
        $vocabulary->vocabularyUpdate($vocabulary->id, $data);

        return redirect('posts');

        // //DBインサート
        // $vocabulary = new Vocabulary([
        //     'vocabulary_ja' => $request->input('vocabulary_ja'),
        //     'vocabulary_en' => $request->input('vocabulary_en'),
        // ]);

        // //保存
        // $vocabulary->save();

        // //homeにリダイレクト
        // return redirect()->route('home');
    }

    // 削除処理
    public function destroy(Vocabulary $vocabulary)
    {
        $vocabulary->delete();
        //homeにリダイレクト
        return redirect()->route('home');
    }
}
