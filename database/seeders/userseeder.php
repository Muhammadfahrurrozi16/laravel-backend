<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create();
        User::factory()->create([
            'name' => 'andi',
            'email' => 'andi21@gmail.com',
            'email_verified_at' => now(),
            'roles' => 'admin',
            'phone' => '089234567821',
            'bio' => 'flutter dev',
            'password' => Hash::make('123456'),
        ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'andi@gmail.com',
            'email_verified_at' => now(),
            'roles' => 'superadmin',
            'phone' => '089234567321',
            'bio' => 'laravel dev',
            'password' => Hash::make('123'),
        ]);
    }
}
