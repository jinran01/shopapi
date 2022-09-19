<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //调用其他数据填充
        $this->call(MenuSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
    }
}
