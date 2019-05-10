<?php

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

        \App\User::create([
            'first_name' => 'Samson',
            'last_name' => 'Johnson',
            'email' => 'samson@example.com',
            'email_verified_at' => new Datetime(),
            'password' => Hash::make('password'),
        ]);

        \App\User::create([
            'first_name' => 'Michael',
            'last_name' => 'Ibe',
            'email' => 'michael@example.com',
            'email_verified_at' => new Datetime(),
            'password' => Hash::make('password'),
        ]);

        \App\User::create([
            'first_name' => 'Alex',
            'last_name' => 'Oti',
            'email' => 'alex@example.com',
            'email_verified_at' => new Datetime(),
            'password' => Hash::make('password'),
        ]);

        \App\User::create([
            'first_name' => 'Samuel',
            'last_name' => 'Iro',
            'email' => 'samuel@example.com',
            'email_verified_at' => new Datetime(),
            'password' => Hash::make('password'),
        ]);
        \App\Poll::create([
            'name' => 'Polaris',
            'user_id' => 1,
            'interest_id' => 1,
            'expirydate' => new Datetime(),
        ]);
        \App\Poll::create([
            'name' => 'Bolaris',
            'user_id' => 2,
            'interest_id' => 1,
            'expirydate' => new Datetime(),
        ]);
        \App\Poll::create([
            'name' => 'Molaris',
            'user_id' => 3,
            'interest_id' => 1,
            'expirydate' => new Datetime(),
        ]);
        \App\Poll::create([
            'name' => 'Valaris',
            'user_id' => 4,
            'interest_id' => 1,
            'expirydate' => new Datetime(),
        ]);
    }
}
