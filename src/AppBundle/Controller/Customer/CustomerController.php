<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Handler\CustomerHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Stripe\Stripe;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class CustomerController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("customers")
 */
class CustomerController extends FOSRestController
{
    /**
     * Retrieve current user informations
     *
     * @Rest\Get("/me")
     */
    public function meAction()
    {
        return $this->getUser();
    }

    /**
     * Retrieve the customer's credit card
     *
     * @Rest\Get("/cards")
     */
    public function getCardAction()
    {
        /** @var Customer $customer */
        $customer = $this->getUser();

        $cardId = $customer->getTokenId();
        if ($cardId !== null) {
            // Authenticate to stripe API
            Stripe::setApiKey($this->container->getParameter('stripe_sk_key'));
            $stripeCustomer = \Stripe\Customer::retrieve($customer->getStripeId());

            return $stripeCustomer->sources->retrieve($cardId)->jsonSerialize();
        }

        return null;
    }

    /**
     * Edit a customer (partially)
     *
     * @param Customer $customer
     * @param CustomerHandler $customerHandler
     * @return Customer|string
     */
    public function patchAction(Customer $customer, CustomerHandler $customerHandler)
    {
        if ($this->getUser() !== $customer) {
            throw new AccessDeniedException();
        }

        return $customerHandler->patch($customer);
    }

    /**
     * Edit a customer (fully)
     *
     * @param Customer $customer
     * @param CustomerHandler $customerHandler
     * @return Customer|string
     */
    public function putAction(Customer $customer, CustomerHandler $customerHandler)
    {
        if ($this->getUser() !== $customer) {
            throw new AccessDeniedException();
        }

        return $customerHandler->put($customer);
    }
}