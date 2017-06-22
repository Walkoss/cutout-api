<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ProviderType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProviderTypesData extends AbstractFixture implements OrderedFixtureInterface
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

            $this->addReference($entity->getCode(), $entity);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}