<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Orders;
use AppBundle\Handler\OrderHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class OrdersController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("orders")
 */
class OrdersController extends FOSRestController
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
     * Get all order from the authenticated customer
     *
     * @Rest\Get("/orders", name="_customer")
     */
    public function getAllAction()
    {
        /** @var Customer $customer */
        $customer = $this->getUser();

        return $customer->getOrders();
    }

    /**
     * Cancel an order
     *
     * @param Orders $orders
     * @param OrderHandler $orderHandler
     * @Rest\Patch("/orders/{orders}/cancel")
     * @return Orders
     */
    public function cancelAction(Orders $orders, OrderHandler $orderHandler)
    {
        if ($this->getUser() !== $orders->getCustomer()) {
            throw new AccessDeniedException();
        }

        return $orderHandler->cancel($orders);
    }

    /**
     * Mark an order as completed
     *
     * @param Orders $orders
     * @param OrderHandler $orderHandler
     * @Rest\Patch("/orders/{orders}/complete")
     * @return Orders
     */
    public function completeAction(Orders $orders, OrderHandler $orderHandler)
    {
        if ($this->getUser() !== $orders->getCustomer()) {
            throw new AccessDeniedException();
        }

        return $orderHandler->complete($orders);
    }
}