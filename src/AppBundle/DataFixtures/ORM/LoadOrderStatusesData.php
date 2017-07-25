<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\OrderStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadOrderStatusesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $orderStatuses = [
            [
                'code' => OrderStatus::ACCEPTED,
                'label' => 'Acceptée'
            ],
            [
                'code' => OrderStatus::PENDING,
                'label' => 'En attente'
            ],
            [
                'code' => OrderStatus::COMPLETED,
                'label' => 'Complétée'
            ],
            [
                'code' => OrderStatus::CANCELLED,
                'label' => 'Annulée'
            ],
            [
                'code' => OrderStatus::REFUSED,
                'label' => 'Refusée'
            ]
        ];

        foreach ($orderStatuses as $orderStatus) {
            $entity = new OrderStatus($orderStatus['code'], $orderStatus['label']);
            $manager->persist($entity);

            $this->addReference($entity->getCode(), $entity);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}