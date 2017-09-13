<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;
use Doctrine\ORM\EntityManager;
use Stripe\Stripe;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
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
     * @var Container
     */
    private $container;

    /**
     * CustomerHandler constructor.
     * @param RequestStack $requestStack
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @param Container $container
     * @internal param RequestStack $request
     * @internal param EntityRepository $entityRepository
     */
    public function __construct(
        RequestStack $requestStack,
        FormFactoryInterface $formFactory,
        EntityManager $entityManager,
        UserPasswordEncoderInterface $encoder,
        Container $container
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->container = $container;
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
        $oldTokenId = $customer->getTokenId();
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

            $this->updateStripeTokenId($customer, $oldTokenId);

            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            return $customer;
        }

        return (string)$form->getErrors(true);
    }

    private function updateStripeTokenId(Customer $customer, $oldTokenId)
    {
        // Authenticate to stripe API
        Stripe::setApiKey($this->container->getParameter('stripe_sk_key'));
        $stripeCustomer = \Stripe\Customer::retrieve($customer->getStripeId());

        // If a new token has been submitted
        if ($customer->getTokenId() !== null
            && $customer->getStripeId() !== null
            && $customer->getTokenId() !== $oldTokenId) {

            // Delete old card on stripe
            if ($oldTokenId !== null) {
                $stripeCustomer->sources->retrieve($oldTokenId)->delete();
            }

            // Add the new one
            $source = $stripeCustomer->sources->create(array("source" => $customer->getTokenId()));
            $customer->setTokenId($source->id);
        } elseif ($customer->getTokenId() === null && $customer->getStripeId() !== null) {
            // Remove the old card on stripe if the new value of tokenId is null
            if ($oldTokenId !== null) {
                $stripeCustomer->sources->retrieve($oldTokenId)->delete();
            }
        }
    }
}