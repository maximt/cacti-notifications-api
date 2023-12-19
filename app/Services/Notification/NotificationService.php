<?php

namespace App\Services\Notification;

use App\Entity\Host;
use App\Entity\HostToNotify;
use App\Services\Service;

class NotificationService extends Service
{
    public function send()
    {
        $entityManager = $this->DI->get('EntityManager');
        $hostNotifyRepository = $entityManager->getRepository(HostToNotify::class);
        $hostRepository = $entityManager->getRepository(Host::class);

        $hosts = $hostRepository->getHosts();

        foreach ($hosts as $host) {
            if ($this->isHostDown($host)) {
                if (! $hostNotifyRepository->isHostExists($host)) {
                    $this->sendNotification($host, 'Host Down');
                    $hostNotifyRepository->addHost($host);
                }
            } elseif ($this->isHostUp($host)) {
                if ($hostNotifyRepository->isHostExists($host)) {
                    $this->sendNotification($host, 'Host Up');
                    $hostNotifyRepository->removeHost($host);
                }
            }
        }
    }

    private function isHostDown($host)
    {
        return $host->getStatus() == Host::HOST_DOWN;
    }

    private function isHostUp($host)
    {
        return $host->getStatus() == Host::HOST_UP;
    }

    private function sendNotification($host, $text)
    {
        $msg = "{$text}: {$host->getDescription()} ({$host->getHostname()})";
        echo "{$msg}\n";

        $push = $this->DI->get('PushSender');
        $push->sendMessage($msg);
    }
}
