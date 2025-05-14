<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AssignUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $users = User::all();

        foreach ($users as $user) {
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }
        }
        
    }
}
