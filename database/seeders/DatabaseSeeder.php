<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tags = \App\Models\Tag::factory(8)->create();

         \App\Models\User::factory(10)->create()->each( function ($user) use ($tags){
            \App\Models\Event::factory(rand(2, 6))->create([
                'user_id' => $user->id
            ])->each(function ($event) use ($tags)

        {
             $event->tags()->attach($tags->random(3));
        });
        });

    }
}
