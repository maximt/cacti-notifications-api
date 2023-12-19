<?php

namespace App;

use App\Entity\Host;
use App\Entity\UserAuth;
use App\Entity\NotificationAuthToken;
use App\Middlewares\Auth;

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Router;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../vendor/pecee/simple-router/helpers.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

Router::setDefaultNamespace('App\Controllers');

Router::group([
    'prefix' => $_ENV['URL_PREFIX'],
    'middleware' => [
        // ProccessRawBody::class
    ]
], function () {
    Router::post('/login', 'AuthController@login');
    // hook for api options requests
    Router::options('/login', 'AuthController@loginOptions');
    Router::options('/hosts/all', 'HostsController@getAllOptions');
    Router::options('/hosts/down', 'HostsController@getDownOptions');
    Router::options('/subscription', 'PushController@subscriptionOptions');

    Router::group([
        'middleware' => [
            Auth::class
        ]
    ], function () {
        Router::get('/hosts/all', 'HostsController@getAll');
        Router::get('/hosts/down', 'HostsController@getDown');

        Router::post('/subscription', 'PushController@subscribe');
        Router::put('/subscription', 'PushController@resubscribe');
        Router::delete('/subscription', 'PushController@unsubscribe');
    });

    Router::error(function (Request $request, \Exception $exception) {
        $response = Router::response();

        $data = [];

        if (is_a($exception, 'App\Libs\HttpException')) {
            $data['message'] = $exception->getMessage();
            $response->httpCode($exception->getCode());
        } else {
            $data['message'] = 'ERROR'; //$exception->getMessage();
            $response->httpCode(500);
        }

        $response->json($data);
    });
});

Router::start();
