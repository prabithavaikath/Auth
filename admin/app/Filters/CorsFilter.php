<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CorsFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($request->getMethod() === 'options') {
            return Services::response()->setStatusCode(200);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after response
    }
}
