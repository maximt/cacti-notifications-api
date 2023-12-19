<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class HostRepository extends EntityRepository
{
    public function getHosts()
    {
        return $this->findAll();
    }

    public function getDownHosts()
    {
        return $this->findBy(['status' => Host::HOST_DOWN]);
    }
}
