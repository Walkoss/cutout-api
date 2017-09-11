<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Location;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadLocationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $locations = [
            [
                'address' => $faker->address,
                'lat' => $faker->latitude,
                'lng' => $faker->longitude
            ],
            [
                'address' => $faker->address,
                'lat' => $faker->latitude,
                'lng' => $faker->longitude
            ]
        ];

        $i = 1;
        foreach ($locations as $location) {
            $entity = new Location();
            $entity->setAddress($location['address']);
            $entity->setLat($location['lat']);
            $entity->setLng($location['lng']);
            $this->addReference('LOCATION_' . $i, $entity);
            $i++;

            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}