<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;
use App\Models\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory()->count(100)->create();

        $users = User::all();

        // For each post, randomly like it by random users
        $posts->each(function ($post) use ($users) {
            $likedUsers = $users->random(rand(1, $users->count()));

            $post->likedBy()->attach($likedUsers);
        });
    }
}
