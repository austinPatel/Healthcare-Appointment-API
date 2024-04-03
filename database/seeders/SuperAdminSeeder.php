<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(
            [
                User::ROLE_SUPER_ADMIN,
                User::ROLE_APP_USER,
            ]
        )->each(function ($roleName) {
            Role::create(['name' => $roleName]);
        });

        $user = User::where('email', 'admin@healthcareapi.com')->first();
        if (!$user) {
            $user = User::create(
                [
                    'name' => 'Healthcare Aecor Admin',
                    'email' => 'admin@healthcare.com',
                    'password' => Hash::make('Aecor@123#'),
                    'remember_token' => Str::random(60),
                    'email_verified_at' => Carbon::now(),
                ]
            );
        }
        $role = Role::findByName(User::ROLE_SUPER_ADMIN);
        $user->assignRole($role->id);
    }
}
