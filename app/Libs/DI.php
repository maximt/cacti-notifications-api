<?php

namespace App\Libs;

class DI
{
    protected static $builder;

    public static function Container()
    {
        if (static::$builder) {
            return static::$builder;
        }
        
        $entityManager = require_once __DIR__ . "/EntityManager.php";
        $serializer = require_once __DIR__ . "/Serializer.php";

        $builder = new \DI\ContainerBuilder();

        $builder->useAnnotations(false);
        $builder->useAutowiring(false);

        $builder->addDefinitions([
            'EntityManager' => function () use ($entityManager) {
                return $entityManager;
            },
            'Serializer' => function () use ($serializer) {
                return $serializer;
            },
            'PushSender' => function () {
                return new \App\Services\Push\SenderService();
            },
            'PushSubscription' => function () {
                return new \App\Services\Push\SubscriptionService();
            },
            'Auth' => function () {
                return new \App\Services\Auth\AuthService();
            },
            'Notification' => function () {
                return new \App\Services\Notification\NotificationService();
            },
        ]);

        static::$builder = $builder->build();

        return static::$builder;
    }
}