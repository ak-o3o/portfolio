<?php

use Illuminate\Database\Seeder;
use App\Vocabulary;

class VocabulariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 2; $i <= 10; $i++) {
            Vocabulary::create([
                'user_id' => 1,
                'vocabulary_ja' => "'こんにちは' . $i",
                'vocabulary_en' => "'hello' . $i",
            ]);
        }
    }
}
