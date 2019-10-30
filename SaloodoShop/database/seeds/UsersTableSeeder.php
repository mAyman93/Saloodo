<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emails = ['user1', 'user2', 'user3', 'user4', 'user5', 'user6'];
        for ($i = 0; $i < 6; $i++) { 
            DB::table('users')->insert([
                'email' => $emails[$i].'@gmail.com',
                'password' => md5($emails[$i] . env('JWT_SECRET')),
                'name' => $emails[$i]
            ]);
        }
    }
}
