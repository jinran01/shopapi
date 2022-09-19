<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
            [
                'name' => '超级管理员',
                'email' => 'super@a.com',
                'password' => bcrypt('123123'),
            ],
        );
        $user->assignRole('super_admin');
    }
}
