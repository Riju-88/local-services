<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AssignProviderRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $users = User::has('providers')->get(); // users who have one or more providers

        foreach ($users as $user) {
            if (! $user->hasRole('provider')) {
                $user->assignRole('provider');
            }
        }
    }
}
