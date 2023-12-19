<?php

namespace App\Controllers;

use App\Libs\DI;
use Pecee\SimpleRouter\SimpleRouter as Router;

class PushController
{
    public function subscribe()
    {
        $endpoint = input('endpoint');
        $publicKey = input('publicKey');
        $authToken = input('authToken');

        $subscription = DI::Container()->get('PushSubscription');

        $subscription->subscribe(
            $endpoint, 
            $publicKey, 
            $authToken
        );

        Router::response()->json([
            'message' => ''
        ]);
    }

    public function resubscribe()
    {
        $endpoint = input('endpoint');
        $publicKey = input('publicKey');
        $authToken = input('authToken');

        $subscription = DI::Container()->get('PushSubscription');

        $subscription->resubscribe(
            $endpoint,
            $publicKey,
            $authToken
        );

        Router::response()->json([
            'message' => ''
        ]);
    }

    public function unsubscribe()
    {
        $endpoint = input('endpoint');

        $subscription = DI::Container()->get('PushSubscription');

        $subscription->unsubscribe(
            $endpoint
        );

        Router::response()->json([
            'message' => ''
        ]);
    }

    public function subscriptionOptions()
    {
        Router::response()->header('Allow: POST, PUT, DELETE, OPTIONS');
    }

}
