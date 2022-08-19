<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nickname' => 'Admin',
            'sponsor_id' => 0,
            'email' => 'admin@pheonix.tech',
            'hash' => md5('admin@pheonix.tech' . now()->timestamp),
            'password' => bcrypt('123456789')
        ]);
    }
}
