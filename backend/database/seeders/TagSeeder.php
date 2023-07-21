<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $tags = Tag::factory(5)->make();

            foreach ($tags as $tag) {
                $tag->user()->associate($user);
                $tag->save();
            }
        }
    }
}
