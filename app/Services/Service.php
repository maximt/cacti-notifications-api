<?php

namespace App\Services;

class Service
{
    protected $DI;

    public function __construct()
    {
        $this->DI = \App\Libs\DI::Container();
    }
}
