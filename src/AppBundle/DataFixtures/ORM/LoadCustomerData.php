<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Customer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker\Factory;

class LoadCustomerData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
        $customer = new Customer();

        $customer->setEmail('customer@cutout.dev');
        $customer->setFirstName($faker->firstName);
        $customer->setPhone($faker->phoneNumber);
        $customer->setLastName($faker->lastName);
        $customer->setLocation($this->getReference('LOCATION_2'));

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($customer, 'qwe123');
        $customer->setPassword($password);

        $manager->persist($customer);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}