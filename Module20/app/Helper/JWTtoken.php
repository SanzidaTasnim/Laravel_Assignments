<?php

namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTtoken{

    public static function CreateToken($userEmail){
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'nbf' => time()*60*60,
            'userEmail' => $userEmail
        ];
        return JWT::encode($payload, $key, 'HS256');

    }
    public static function CreateTokenForSetPassword($userEmail){
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'nbf' => time()*60*5,
            'userEmail' => $userEmail
        ];
        return JWT::encode($payload, $key, 'HS256');

    }
    public static function VerifyToken($token){

        try{
            $key = env('JWT_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded->userEmail;
        } catch(Exception $e){
            return "Unauthorized";
        }

    }
}
?>
