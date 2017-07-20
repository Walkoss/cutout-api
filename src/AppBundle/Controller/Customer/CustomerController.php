<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Handler\CustomerHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class CustomerController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("customers")
 */
class CustomerController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/me")
     */
    public function meAction()
    {
        return $this->getUser();
    }

    public function patchAction(Customer $customer, CustomerHandler $customerHandler)
    {
        return $customerHandler->patch($customer);
    }

    public function putAction(Customer $customer, CustomerHandler $customerHandler)
    {
        return $customerHandler->put($customer);
    }
}