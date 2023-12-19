<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Table;


/** @Entity @Table(name="tray_push_subscription", uniqueConstraints={@UniqueConstraint(name="idx", columns={"endpoint"})}) */
class PushSubscription
{
    /** @Id @Column(type="integer") @GeneratedValue */
    private string $id;  

    /** @Column(type="string", length=2048) */
    private string $endpoint;  

    /** @Column(type="string", length=256) */
    private string $publicKey; 

    /** @Column(type="string", length=128) */
    private string $authToken;  

    public function __construct(string $endpoint, string $publicKey, string $authToken)
    {
        $this->endpoint = $endpoint;
        $this->publicKey = $publicKey;
        $this->authToken = $authToken;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function setPublicKey(string $publicKey): void
    {
        $this->publicKey = $publicKey;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function setAuthToken(string $authToken): void
    {
        $this->authToken = $authToken;
    }
}
