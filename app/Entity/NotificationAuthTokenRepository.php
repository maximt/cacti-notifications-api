<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;

class NotificationAuthTokenRepository extends EntityRepository
{
    public function clearExpired(int $days): void
    {
        $date_expired = new DateTimeImmutable("-{$days} days");

        $qb = $this->createQueryBuilder('qb');
        $qb->delete();
        $qb->where('qb.created < :date_expired');
        $qb->setParameter('date_expired', $date_expired);

        $qb->getQuery()->execute();
    }

}
