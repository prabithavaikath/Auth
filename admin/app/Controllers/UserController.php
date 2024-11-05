<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends ResourceController
{
    protected $userModel;
    protected $serviceLibrary;
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
    public function deleteUser($id)
    {
         // Get the Authorization header
         $token = $this->request->getHeaderLine('Authorization');
         $token = str_replace('Bearer ', '', $token);  // Remove 'Bearer ' prefix, if present
 
         if (!$token) {
             return $this->failUnauthorized('Token required');
         }
 
         try {
             // Decode the JWT token
             $key = getenv('JWT_SECRET');
             $decoded = JWT::decode($token, new Key($key, 'HS256'));
 
             // Extract the role from the decoded token
             $userRole = $decoded->data->role ?? null;
 
             if (!$userRole) {
                 return $this->failUnauthorized('Invalid role in token');
             }
             
             $deleted = $this->userModel->delete($id); // Fix this to userModel
             if ($deleted) {
                 return $this->respond(['message' => 'User deleted successfully'], 200);
             }
             return $this->respond(['message' => 'User not found'], 404);
          
 
             // Return the data as JSON response
             return $this->respond($data, ResponseInterface::HTTP_OK);
 
         } catch (\Exception $e) {
             return $this->failUnauthorized('Invalid or expired token.');
         }
        
       
    }
    
    // In UserController
// public function updateUser($id)
// {
//     $data = $this->request->getJSON(); // Get JSON data from request
//     if ($this->userModel->find($id)) {
//         $this->userModel->update($id, $data);
//         return $this->respond(['message' => 'User updated successfully']);
//     } else {
//         return $this->failNotFound('User not found');
//     }
// }

// public function deleteUser($id)
// {
//     if ($this->userModel->find($id)) {
//         $this->userModel->delete($id); 
//         return $this->respondDeleted(['message' => 'User deleted successfully']);
//     } else {
//         return $this->failNotFound('User not found');
//     }
// }
}
