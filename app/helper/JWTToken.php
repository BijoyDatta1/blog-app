<?php

namespace App\helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    public static function CreateToke($userId,$userEmail, $time = 60)
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + (60 * $time),
            'userId' => $userId,
            'email' => $userEmail,
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public static function VerifyToken($token)
    {
        try {
            if ($token != null) {
                $key = env('JWT_KEY');
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return $decode;
            } else {
                return 'Unauthorize1';
            }
        } catch (Exception $e) {
            return 'Unauthorize';
        }
    }
}
