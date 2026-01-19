<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@crm.com',
                'password' => 'password123',
                'role' => 'Super Admin'
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@crm.com',
                'password' => 'password123',
                'role' => 'Admin'
            ],
            [
                'name' => 'Supervisor User',
                'email' => 'supervisor@crm.com',
                'password' => 'password123',
                'role' => 'Supervisor'
            ],
            [
                'name' => 'Counselor User',
                'email' => 'counselor@crm.com',
                'password' => 'password123',
                'role' => 'Counselor'
            ],
            [
                'name' => 'Application User',
                'email' => 'application@crm.com',
                'password' => 'password123',
                'role' => 'Application'
            ]
        ];

        foreach ($users as $userData) {
            $role = Role::where('name', $userData['role'])->first();
            
            if ($role) {
                User::firstOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'password' => Hash::make($userData['password']),
                        'role_id' => $role->id,
                    ]
                );
            }
        }
    }
}