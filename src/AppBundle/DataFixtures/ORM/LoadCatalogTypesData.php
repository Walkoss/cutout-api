<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\CatalogType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCatalogTypesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $catalogTypes = [
            [
                'code' => CatalogType::COIFFURE,
                'label' => 'Coiffure'
            ]
        ];

        foreach ($catalogTypes as $catalogType) {
            $entity = new CatalogType($catalogType['code'], $catalogType['label']);
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