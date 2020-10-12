<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 24; $i <= 50; $i++) {
            Post::create([
                'user_id' => 1,
                'post_ja' => 'こんにちはこんにちはこんにちはこんにちは' . $i,
                'post_en' => 'hellohellohellohello' . $i,
            ]);
        }
    }
}
