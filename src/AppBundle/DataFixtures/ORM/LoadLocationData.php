<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Location;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLocationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $locations = [
            [
                'address' => '9 Rue Maurice Grandcoing, 94200 Ivry-sur-Seine, France',
                'lat' => 48.813681,
                'lng' => 2.3927667
            ],
            [
                'address' => '26 Place de la Chapelle, 75018 Paris, France',
                'lat' => 48.8849736,
                'lng' => 2.3587068
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