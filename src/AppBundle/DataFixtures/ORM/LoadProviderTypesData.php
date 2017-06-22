<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ProviderType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProviderTypesData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $providerTypes = [
            [
                'code' => ProviderType::COIFFEUR,
                'label' => 'Coiffeur'
            ]
        ];

        foreach ($providerTypes as $providerType) {
            $entity = new ProviderType($providerType['code'], $providerType['label']);
            $manager->persist($entity);
        }

        $manager->flush();
    }
}