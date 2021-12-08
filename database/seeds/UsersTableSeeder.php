<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create()
                                ->each(function ($user) {
                                    $user->profile()->save(factory(Profile::class)->make());
                                });
    }
}
