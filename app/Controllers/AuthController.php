<?php

namespace App\Controllers;

use App\Libs\DI;
use Pecee\SimpleRouter\SimpleRouter as Router;

class AuthController
{
    public function login()
    {
        $username = input('username');
        $password = input('password');

        $auth = DI::Container()->get('Auth');

        $token = $auth->login($username, $password);

        Router::response()->header('Content-Type: application/json; charset=utf-8');
        return DI::Container()->get('Serializer')->serialize([
            'message' => $token ? '' : 'NOT_AUTHORIZED',
            'token' => $token
        ], 'json');
    }

    public function loginOptions()
    {
        Router::response()->header('Allow: POST, OPTIONS');
    }
}
