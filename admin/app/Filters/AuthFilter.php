<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Extract token from the Authorization header
        $token = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);  // Remove 'Bearer ' prefix, if present

        if (!$token) {
            return Services::response()->setJSON(['message' => 'Token required'])->setStatusCode(401);
        }

        try {
            // Decode JWT and verify its validity
            $decoded = validateJWT($token);  
            $userRole = $decoded->data->role;

            // Check if user role is allowed to access the route
            if (!in_array($userRole, $arguments)) {
                return Services::response()->setJSON(['message' => 'Access denied'])->setStatusCode(403);
            }
        } catch (\Exception $e) {
            return Services::response()->setJSON(['message' => 'Invalid token'])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action required after response
    }
}
