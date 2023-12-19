<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="user_auth")
 */
class UserAuth
{
    /**
     * @Id
     * @Column(type="integer")
     */
    private int $id;
    /**
     * @Column(type="string")
     */
    private string $username;
    /**
     * @Column(type="string")
     */
    private string $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
