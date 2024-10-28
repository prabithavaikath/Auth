<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'role'];

    // Method to add a new user 
    public function createUser($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }
}
