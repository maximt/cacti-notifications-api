<?php

namespace App\Services\Push;

use App\Entity\PushSubscription;
use App\Libs\HttpException;
use App\Services\Service;

class SubscriptionService extends Service
{

    public function subscribe(string $endpoint, string $publicKey, string $authToken): void
    {
        $entityManager = $this->DI->get('EntityManager');
        $subscription = new PushSubscription(
            $endpoint, 
            $publicKey, 
            $authToken
        );
        $entityManager->persist($subscription);
        $entityManager->flush();
    }

    public function resubscribe(string $endpoint, string $publicKey, string $authToken): void
    {
        $entityManager = $this->DI->get('EntityManager');
        $pushSubscriptionRepository = $entityManager->getRepository(PushSubscription::class);
        $subscription = $pushSubscriptionRepository->findOneByEndpoint($endpoint);

        if(!$subscription){
            throw new HttpException('SUBSRIPTION_NOT_FOUND',404);
        }

        $subscription->setPublicKey($publicKey);
        $subscription->setAuthToken($authToken);
        $entityManager->flush();
    }

    public function unsubscribe(string $endpoint): void
    {
        $entityManager = $this->DI->get('EntityManager');
        $pushSubscriptionRepository = $entityManager->getRepository(PushSubscription::class);
        $subscription = $pushSubscriptionRepository->findOneByEndpoint($endpoint);
        
        if (!$subscription) {
            throw new HttpException('SUBSRIPTION_NOT_FOUND', 404);
        }

        $entityManager->remove($subscription);
        $entityManager->flush();
    }
}
