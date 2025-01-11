<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignRoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::where('name', 'admin')->first();
        $role = \Spatie\Permission\Models\Role::where('name', 'admin')->first();
        $user->assignRole($role);
    }
}
