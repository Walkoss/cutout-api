<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Handler\CustomerHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

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
     * Edit a customer (partially)
     *
     * @param Customer $customer
     * @param CustomerHandler $customerHandler
     * @return Customer|string
     */
    public function patchAction(Customer $customer, CustomerHandler $customerHandler)
    {
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
        return $customerHandler->put($customer);
    }
}