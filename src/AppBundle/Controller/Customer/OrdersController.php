<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Orders;
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

    /**
     * @param Orders $orders
     * @param OrderHandler $orderHandler
     * @Rest\Patch("/orders/{orders}/cancel")
     * @return Orders
     */
    public function cancelAction(Orders $orders, OrderHandler $orderHandler)
    {
        return $orderHandler->cancel($orders);
    }

    /**
     * @param Orders $orders
     * @param OrderHandler $orderHandler
     * @Rest\Patch("/orders/{orders}/complete")
     * @return Orders
     */
    public function completeAction(Orders $orders, OrderHandler $orderHandler)
    {
        return $orderHandler->complete($orders);
    }
}