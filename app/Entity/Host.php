<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="HostRepository")
 * @Table(name="host")
 */
class Host
{
    const HOST_UNKNOWN = 0;
    const HOST_DOWN = 1;
    const HOST_RECOVERING = 2;
    const HOST_UP = 3;
    const HOST_ERROR = 4;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @Column(type="string")
     */
    private $hostname;
    /**
     * @Column(type="string")
     */
    private $description;
    /**
     * @Column(type="string")
     */
    private $notes;
    /**
     * @Column(type="integer")
     */
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    public function getHostname()
    {
        return $this->hostname;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
