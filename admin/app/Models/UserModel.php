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

        // Function to get user by username
        public function getUserByUsername($username)
        {
            return $this->where('username', $username)->first();
        }
    
    
    
    
        public function getDataByRole($role)
        {
            if ($role == 'User') {
                // Fetch only normal records for User role
                return $this->where('role', 'User')->findAll(); 
            } elseif ($role == 'Admin') {
                
                return $this->whereIn('role', ['Admin', 'User'])->findAll();
            } elseif ($role == 'SuperAdmin') {
                // Fetch all records with permission to add, delete, and update for SuperAdmin role
                return $this->findAll(); 
            } else {
                return []; // Return an empty array 
            }
        }
        // public function delete($id) {
        //     $this->userModel->delete($id);
        //     return $this->response->setStatusCode(204); // No Content on successful delete
        // }
        // public function update($id) {
        //     $data = $this->request->getJSON();
        //     $this->userModel->update($id, $data);
        //     return $this->response->setJSON(['message' => 'User updated successfully']);
        // }
}
