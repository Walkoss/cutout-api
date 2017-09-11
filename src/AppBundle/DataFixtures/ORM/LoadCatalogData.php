<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Catalog;
use AppBundle\Entity\CatalogType;
use AppBundle\Entity\GenderType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCatalogData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $catalogs = [
            [
                'catalog_type' => $this->getReference(CatalogType::COIFFURE),
                'gender_type' => $this->getReference(GenderType::MALE),
                'provider' => $this->getReference('PROVIDER_1'),
                'price' => 25
            ],
            [
                'catalog_type' => $this->getReference(CatalogType::COIFFURE),
                'gender_type' => $this->getReference(GenderType::FEMALE),
                'provider' => $this->getReference('PROVIDER_1'),
                'price' => 40
            ],
            [
                'catalog_type' => $this->getReference(CatalogType::COIFFURE),
                'gender_type' => $this->getReference(GenderType::CHILD),
                'provider' => $this->getReference('PROVIDER_1'),
                'price' => 12
            ]
        ];

        foreach ($catalogs as $catalog) {
            $catalogEntity = new Catalog();
            $catalogEntity->setCatalogType($catalog['catalog_type']);
            $catalogEntity->setGenderType($catalog['gender_type']);
            $catalogEntity->setProvider($catalog['provider']);
            $catalogEntity->setPrice($catalog['price']);

            $manager->persist($catalogEntity);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}