<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends ResourceController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function fetchDataBasedOnRole()
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

            // Fetch data based on the user's role using UserModel
            $data = $this->userModel->getDataByRole($userRole);

            // Return the data as JSON response
            return $this->respond($data, ResponseInterface::HTTP_OK);

        } catch (\Exception $e) {
            return $this->failUnauthorized('Invalid or expired token.');
        }
    }
}
