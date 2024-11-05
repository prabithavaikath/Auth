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
        // CORS Headers
        // header("Access-Control-Allow-Origin: *"); // Change '*' to your frontend URL for production
        // header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        // header("Access-Control-Allow-Headers: Content-Type, Authorization");

        // // Handle OPTIONS requests directly
        // if ($request->getMethod() === 'options') {
        //     return Services::response()->setStatusCode(200);
        // }

        // Extract and verify the JWT
        $token = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);

        if (!$token) {
            return Services::response()->setJSON(['message' => 'Token required'])->setStatusCode(401);
        }

        try {
            $decoded = validateJWT($token);  
            $userRole = $decoded->data->role;

            if (!in_array($userRole, $arguments)) {
                return Services::response()->setJSON(['message' => 'Access denied'])->setStatusCode(403);
            }
        } catch (\Exception $e) {
            return Services::response()->setJSON(['message' => 'Invalid token'])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optionally set headers in the after method for consistency
        // $response->setHeader('Access-Control-Allow-Origin', '*');
        // $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        // $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
