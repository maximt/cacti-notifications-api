<?php

namespace App\Services\Push;

use App\Entity\PushSubscription;
use App\Services\Service;
use Exception;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use App\Services\Push\SubscriptionService;

class SenderService extends Service
{

    private function getSubscriptions()
    {
        $entityManager = $this->DI->get('EntityManager');
        $pushSubscriptionRepository = $entityManager->getRepository(PushSubscription::class);
        $subscriptions = $pushSubscriptionRepository->findAll();
        return $subscriptions;
    }

    private function validateConfig(): void
    {
        if (!($_ENV['PUSH_APP_SUBJECT'] && $_ENV['PUSH_APP_PUBLIC_KEY'] && $_ENV['PUSH_APP_PRIVATE_KEY'])) {
            throw new Exception('push not configured');
        }
    }

    public function _sendMessage(string $message, $subscriptions)
    {
        $auth = array(
                    'VAPID' => array(
                        'subject' => $_ENV['PUSH_APP_SUBJECT'],
                        'publicKey' => $_ENV['PUSH_APP_PUBLIC_KEY'],
                        'privateKey' => $_ENV['PUSH_APP_PRIVATE_KEY'],
                    ),
                );

        $webPush = new WebPush($auth);

        foreach ($subscriptions as $subscription_data) {
            $subscription = Subscription::create([
                'endpoint' => $subscription_data->getEndpoint(),
                'publicKey' => $subscription_data->getPublicKey(),
                'authToken' => $subscription_data->getAuthToken()
            ]);
            
            $webPush->queueNotification(
                $subscription,
                $message
            );
        }

        return $webPush->flush();
    }

    private function _handleReports($reports): void
    {
        foreach ($reports as $report) {
            if (!$report->isSuccess()) {
                $subService = new SubscriptionService();

                $endpoint = $report->getRequest()->getUri()->__toString();
                $subService->unsubscribe($endpoint);
            }
        }
    }

    public function sendMessage(string $message): void
    {
        $this->validateConfig();

        $subscriptions = $this->getSubscriptions();
        if (!$subscriptions) {
            return;
        }

        $reports = $this->_sendMessage($message, $subscriptions);

        $this->_handleReports($reports);
    }
}
