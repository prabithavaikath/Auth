<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        // Create a regular user
        $userModel->createUser([
            'username' => 'regularuser',
            'email'    => 'user@example.com',
            'password' => 'userpassword',  
            'role'     => 'User',
        ]);

        // Create an admin user
        $userModel->createUser([
            'username' => 'adminuser',
            'email'    => 'admin@example.com',
            'password' => 'adminpassword',  
            'role'     => 'Admin',
        ]);

        // Create a superadmin user
        $userModel->createUser([
            'username' => 'superadminuser',
            'email'    => 'superadmin@example.com',
            'password' => 'superadminpassword',  
            'role'     => 'SuperAdmin',
        ]);
    }
}
