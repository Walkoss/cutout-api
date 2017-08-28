<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Handler\OrderHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class OrdersController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("orders")
 */
class OrdersController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Create an order
     *
     * @Rest\Post("/orders")
     * @param OrderHandler $orderHandler
     * @return \AppBundle\Entity\Catalog|string
     */
    public function newAction(OrderHandler $orderHandler)
    {
        return $orderHandler->post();
    }

    /**
     * @Rest\Get("/orders", name="_customer")
     */
    public function cgetAction()
    {
        /** @var Customer $customer */
        $customer = $this->getUser();

        return $customer->getOrders();
    }
}