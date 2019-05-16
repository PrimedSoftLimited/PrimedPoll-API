<?php

use App\User;
use App\Poll;
use App\Intrest;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Admin::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        $faker = Faker::create();
            $email = [ 'alpha@example.com', 'bravo@example.com', 'charlie@example.com', 'delta@example.com', 'echo@example.com', 'foxtroit@example.com'];
                foreach ( $email as $email ) { 
            \App\User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => trim( strtolower( $email ) ),
                'email_verified_at' => new Datetime(),
                'password' => Hash::make('password'),
            ]);
        }

            $faker = Faker::create();
            $interest = [ 'football', 'politics', 'movie', 'tech', 'research', 'sex', 'relationship', 'money'];
                foreach ( $interest as $interest ) { 
            \App\Intrest::create([
                'intrest' => trim( strtolower( $interest ) ),
            ]);
        }

        $faker = Faker::create();
        $interestID = DB::table('intrests')->pluck('id');
        $userID= DB::table('users')->pluck('id');
        foreach (range(1,20) as $index) {
            \App\Poll::create([
            'user_id' => $faker->randomElement($userID),
            'interest_id' => $faker->randomElement($interestID),
            'name' => $faker->sentence,
            'expirydate' => $faker->dateTimeBetween($created_at = 'now', $expirydate = '+30 days'),
            ]);
        } 

        $faker = Faker::create();
        $pollID = DB::table('polls')->pluck('id');
        $options = ['true', 'false', 'others'];
        foreach (range(1,60) as $index) {
            \App\Option::create([
            'poll_id' => $faker->randomElement($pollID),
            'name' => $faker->randomElement($options),
            ]);
        } 

        $faker = Faker::create();
        $ownerID = DB::table('users')->pluck('id');
        $interestID = DB::table('intrests')->pluck('id');
        foreach (range(1,25) as $index) {
            \App\Userinterests::create([
            'owner_id' => $faker->randomElement($ownerID),
            'interest_id' => $faker->randomElement($interestID),
            ]);
        } 
    }
}
