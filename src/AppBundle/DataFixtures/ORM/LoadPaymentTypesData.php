<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\PaymentType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPaymentTypesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $paymentTypes = [
            [
                'code' => PaymentType::CC,
                'label' => 'Carte de crédit'
            ],
            [
                'code' => PaymentType::CASH,
                'label' => 'Liquide'
            ]
        ];

        foreach ($paymentTypes as $paymentType) {
            $entity = new PaymentType($paymentType['code'], $paymentType['label']);
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