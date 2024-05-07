<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'mumu',
            'email' => 'mumu@example.com',
            'password' => Hash::make('password'),
        ]);

        $user = User::factory()->create([
            'name' => 'Leila',
            'email' => 'leila@gossipgirl.com',
            'password' => Hash::make('password'),
        ]);
        $permission = Permission::where('name', 'manage-users')->first();
        $user->permissions()->attach($permission);

        User::factory(20)->create();
    }
}
