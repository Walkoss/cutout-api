<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Provider;
use AppBundle\Entity\ProviderType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker\Factory;

class LoadProviderData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $provider = new Provider();

        $provider->setEmail('provider@cutout.dev');
        $provider->setName($faker->company);
        $provider->setPhone($faker->phoneNumber);
        $provider->setIban($faker->iban('fr_FR'));
        $provider->setIsFreelance(false);
        $provider->setLocation($this->getReference('LOCATION_1'));
        $provider->setDescription('La coiffure est notre passion, faire de votre instant coiffure un moment de détente pour vous, une véritable pause, afin de vous rendre unique.

Nous attachons le plus grand soin à la qualité de nos services, nous prenons le temps de vous écouter afin de vous proposer ce qu’il vous conviendra le mieux en respectant votre personnalité.

Faites confiance à nos coiffeurs stylistes certifiés pour révéler la beauté de vos cheveux et mettre en valeur votre capital séduction.');
        $provider->setSiret($faker->siret);
        $provider->setRange(1);
        $provider->setProviderType($this->getReference(ProviderType::COIFFEUR));

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($provider, 'qwe123');
        $provider->setPassword($password);

        $manager->persist($provider);
        $this->addReference('PROVIDER_1', $provider);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}