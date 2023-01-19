<?php

namespace App\Tool;

use Firebase\JWT\JWT as FirebaseJwt;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

class Jwt
{
    public static function encode($datas)
    {
        $time = time();

        $info = [
            //簽發者
            'iss' => env('APP_URL'),
            //接收者
            'aud' => env('APP_URL'),
            //發行時間
            'iat' => $time,
            //生效時間
            'nbf' => $time,
            //有效時間
            'exp' => $time + (86400 * env('JWT_LIMIT')),
        ];

        $payload = array_merge($info, $datas);

        $jwtToken = FirebaseJwt::encode($payload, env('APP_KEY'), 'HS256');

        return $jwtToken;
    }

    public static function decode($jwtToken)
    {
        $key = new Key(env('APP_KEY'), 'HS256');

        try {
            $payload = FirebaseJwt::decode($jwtToken, $key);

            return $payload;
        } catch (SignatureInvalidException $e) {
            return false;
        }
    }
}
