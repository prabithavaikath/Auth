<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Function to register a new user
    public function register()
    {

        $data = $this->request->getJSON(true) ?? $this->request->getPost(); // Support JSON and form-data

        if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['role'])) {
            return $this->failValidationError('Missing required fields.');
        }     

        $userId = $this->userModel->createUser($data);
   
        // Check if user creation was successful
        if ($userId) {
            return $this->respond(['message' => 'User registered successfully', 'user_id' => $userId], 201);
        } else {
            return $this->failServerError('Failed to register user');
        }
    }
}
