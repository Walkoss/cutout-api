<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerHandler
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * CustomerHandler constructor.
     * @param RequestStack $requestStack
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @internal param RequestStack $request
     * @internal param EntityRepository $entityRepository
     */
    public function __construct(RequestStack $requestStack, FormFactoryInterface $formFactory, EntityManager $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    public function patch(Customer $customer)
    {
        return $this->processForm($customer);
    }

    public function put(Customer $customer)
    {
        return $this->processForm($customer);
    }

    public function processForm(Customer $customer)
    {
        $form = $this->formFactory->create(
            CustomerType::class,
            $customer,
            [
                'method' => $this->request->getMethod(),
            ]
        );

        $form->submit($this->request->request->all(), 'PATCH' !== $this->request->getMethod());

        if ($form->isSubmitted() && $form->isValid()) {
            if ($customer->getPlainPassword() !== null) {
                $password = $this->encoder->encodePassword($customer, $customer->getPlainPassword());
                $customer->setPassword($password);
                $customer->eraseCredentials();
            }

            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            return $customer;
        }

        return (string)$form->getErrors(true);
    }
}