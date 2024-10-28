<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'role'];

    // Function to get user by username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
