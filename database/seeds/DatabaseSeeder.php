<?php

use App\User;
use App\Poll;
use App\Intrest;
use Carbon\Carbon;
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
            $email = [ 'chizaram@example.com', 'frebby@example.com', 'emmanuel@example.com', 'favour@example.com', 'jennifer@example.com', 'sammy@example.com', 'chibuzor@example.com', 'juni@example.com', 'jerry@example.com', 'francis@example.com'];
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
            \App\Interest::create([
                'title' => trim( strtolower( $interest ) ),
            ]);
        }

    }
}
