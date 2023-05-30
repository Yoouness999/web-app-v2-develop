<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TestUserSeeder extends Seeder {

    public function run()
    {
        $faker = \Faker\Factory::create('fr_BE');

        $user = User::where('email', 'test@cherrypulp.com')->withTrashed()->first();

        if (!$user) {
            $user = User::create([
                'email' => 'test@cherrypulp.com',
                'password' => bcrypt('test')
            ]);
        }

        /**
         * Fill default user info
         */
        $user->fill([
            'first_name' => "test",
            "last_name" => "test",
        ]);

        /**
         * Delete all items related to user
         */
        $items = \App\Item::where('user_id', $user->id)->get();

        if ($items) {
            $items->delete();
        }
    }

}
