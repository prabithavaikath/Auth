<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class ServiceLibrary {
    
   
    public function __construct() {
        // Load any dependencies here
        
    }

    public function returnRole($token){
        // Get the Authorization header
      
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
           
            return  $userRole;
            if (!$userRole) {
                return $this->failUnauthorized('Invalid role in token');
            }
           } catch (\Exception $e) {
               return $this->failUnauthorized('Invalid or expired token.');
           }
   }
}