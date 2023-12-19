<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use App\Entity\HostToNotify;


class HostToNotifyRepository extends EntityRepository
{

    public function getHosts()
    {
        return $this->findAll();
    }

    public function clearOrphaned()
    {
        $entityManager = $this->getEntityManager();

        $hosts_to_notify = $this->findAll();
        foreach($hosts_to_notify as $host_to_notify) {
            if (! $this->isHostOrphan($host_to_notify)) {
                $entityManager->remove($host_to_notify);
            }
        }

        $entityManager->flush();
    }

    private function isHostOrphan($host_to_notify)
    {
        $hostRepository = $this->getEntityManager()->getRepository(Host::class);
        return $hostRepository->count(['id' => $host_to_notify->getId()]);
    }

    public function isHostExists($host)
    {
        return $this->count(['id' => $host->getId()]);
    }

    public function addHost($host)
    {
        $host_to_notify = new HostToNotify();
        $host_to_notify->setId($host->getId());
        $host_to_notify->setStatus($host->getStatus());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($host_to_notify);
        $entityManager->flush();
    }

    public function removeHost($host)
    {
        $host_to_notify = $this->findOneById($host->getId());

        $entityManager = $this->getEntityManager();
        $entityManager->remove($host_to_notify);
        $entityManager->flush();
    }
}
