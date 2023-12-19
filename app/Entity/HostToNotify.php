<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="HostToNotifyRepository")
 * @Table(name="tray_host_to_notify")
 */
class HostToNotify
{
    /**
     * @Id
     * @Column(type="integer")
     */
    private int $id;
    /**
     * @Column(type="integer")
     */
    private int $status;  


    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
