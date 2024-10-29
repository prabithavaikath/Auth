<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use \Firebase\JWT\JWT;

class AuthController extends ResourceController
{
    public function login()
    {
        $userModel = new UserModel();
        $data = $this->request->getJSON(true) ?? $this->request->getPost(); // Support JSON and form-data
        if (empty($data['username']) || empty($data['password'])) {
            return $this->failValidationError('Missing required fields.');
        }   
        $username =$data['username'];
        $password =$data['password'];

        // Fetch the user by username
        $user = $userModel->getUserByUsername($username);

        if (!empty($user) && password_verify($password, $user['password'])) {
            // Generate JWT token
            $token = generateJWT($user);
           // return $this->respond(['token' => $token], 200);
            return $this->respond(['token' => $token,'role'=>$user['role']], 200);
        }

        return $this->respond(['message' => 'Invalid credentials'], 401);
    }


    public function logout()
    {
        // For a stateless JWT-based system, logout is typically handled client-side by removing the token.
        return $this->respond(['message' => 'Logged out successfully'], 200);
    }
}
