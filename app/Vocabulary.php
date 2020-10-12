<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $fillable = [
        'user_id', 'vocabulary_ja', 'vocabulary_en',
    ];

    //リレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // //vocabularyの一覧を取得
    public function getVocabularies(Int $user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);
    }

    //vacabularyを編集(update)
    public function vocabularyUpdate(Int $user_id, array $data)
    {
        $this->id = $user_id;
        $this->vocabulary_ja = $data['vocabulary_ja'];
        $this->vocabulary_en = $data['vocabulary_en'];
        $this->update();

        return;
    }
}
