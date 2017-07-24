<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\GenderType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGenderTypesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $genderTypes = [
            [
                'code' => GenderType::FEMALE,
                'label' => 'Femme'
            ],
            [
                'code' => GenderType::MALE,
                'label' => 'Homme'
            ],
            [
                'code' => GenderType::CHILD,
                'label' => 'Enfant'
            ]
        ];

        foreach ($genderTypes as $genderType) {
            $entity = new GenderType($genderType['code'], $genderType['label']);
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