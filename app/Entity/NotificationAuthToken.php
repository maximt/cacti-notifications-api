<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="NotificationAuthTokenRepository")
 * @Table(name="tray_notification_auth_token")
 */
class NotificationAuthToken
{
    /** @Id @Column(type="integer") @GeneratedValue */
    private int $id;

    /** @Column(type="string") */
    private string $username;

    /** @Column(type="string") */
    private string $token;

    /** @Column(type="datetime") */
    private DateTime $created;

    /** @Column(type="datetime", nullable=true) */
    private DateTime $last_logged;

    //TODO useragent
    public function __construct(string $username, string $token)
    {
        $this->username = $username;
        $this->token = $token;
        $this->created = new DateTime('now');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function getLastLogged(): DateTime
    {
        return $this->last_logged;
    }
    public function updateLastLogged(): void
    {
        $this->last_logged = new DateTime();
    }
}
