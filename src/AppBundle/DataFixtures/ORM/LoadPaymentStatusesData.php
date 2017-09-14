<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\PaymentStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPaymentStatusesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $paymentStatuses = [
            [
                'code' => PaymentStatus::PENDING,
                'label' => 'En attente'
            ],
            [
                'code' => PaymentStatus::UNPAID,
                'label' => 'Impayé'
            ],
            [
                'code' => PaymentStatus::PAID,
                'label' => 'Payé'
            ],
            [
                'code' => PaymentStatus::UNCAPTURED,
                'label' => 'Prelevé'
            ],
            [
                'code' => PaymentStatus::CAPTURED,
                'label' => 'Débité'
            ],
            [
                'code' => PaymentStatus::FAILED,
                'label' => 'Échoué'
            ],
            [
                'code' => PaymentStatus::CANCELLED,
                'label' => 'Annulé'
            ]
        ];

        foreach ($paymentStatuses as $paymentStatus) {
            $entity = new PaymentStatus($paymentStatus['code'], $paymentStatus['label']);
            $manager->persist($entity);

            $this->addReference('PAYMENT_' . $entity->getCode(), $entity);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}