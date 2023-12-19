<?php

namespace App\Controllers;

use App\Libs\DI;
use App\Entity\Host;
use Pecee\SimpleRouter\SimpleRouter as Router;

class HostsController
{

    public function getAll()
    {
        $DI = DI::Container();
        $entityManager = $DI->get('EntityManager');
        $hosts = $entityManager->getRepository(Host::class)->getHosts();
        
        Router::response()->header('Content-Type: application/json; charset=utf-8');
        return $DI->get('Serializer')->serialize([
            'message' => '',
            'hosts' => $hosts
        ], 'json');
    }

    public function getAllOptions()
    {
        Router::response()->header('Allow: GET, OPTIONS');
    }

    public function getDown()
    {
        $DI = DI::Container();
        $entityManager = $DI->get('EntityManager');
        $hosts = $entityManager->getRepository(Host::class)->getDownHosts();

        Router::response()->header('Content-Type: application/json; charset=utf-8');
        return $DI->get('Serializer')->serialize([
            'message' => '',
            'hosts' => $hosts
        ], 'json');
    }

    public function getDownOptions()
    {
        Router::response()->header('Allow: GET, OPTIONS');
    }

}
