<?php

namespace App\Middlewares;

use App\Libs\DI;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class Auth implements IMiddleware
{
    public function handle(Request $request): void
    {
        $auth = DI::Container()->get('Auth');

        $request->userId = $auth->authorize(
            $request->getHeader('Token')
        );
    }
}
