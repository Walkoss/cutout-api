<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Review;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadReviewsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $reviews = [
            [
                'mark' => 5,
                'review' => 'Très belle prestation !',
                'customer' => $this->getReference('CUSTOMER_2'),
                'provider' => $this->getReference('PROVIDER_1')
            ],
            [
                'mark' => 2,
                'review' => 'Déçu de votre coiffure !',
                'customer' => $this->getReference('CUSTOMER_1'),
                'provider' => $this->getReference('PROVIDER_3')
            ],
        ];

        foreach ($reviews as $review) {
            $entity = new Review();
            $entity->setProvider($review['provider']);
            $entity->setMark($review['mark']);
            $entity->setCustomer($review['customer']);
            $entity->setReview($review['review']);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}