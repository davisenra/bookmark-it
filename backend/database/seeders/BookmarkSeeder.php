<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $bookmarks = Bookmark::factory(10)->make();
            $tags = $user->tags->toArray();

            foreach ($bookmarks as $bookmark) {
                $tagId = $tags[array_rand($tags)]['id'];

                $bookmark->user()->associate($user);
                $bookmark->save();
                $bookmark->tags()->attach($tagId);
            }
        }
    }
}
