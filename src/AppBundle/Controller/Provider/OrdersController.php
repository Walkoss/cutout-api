<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Entity\Orders;
use AppBundle\Entity\Provider;
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
    public function cgetAction()
    {
        /** @var Provider $customer */
        $provider = $this->getUser();

        return $provider->getOrders();
    }

    /**
     * @param Orders $orders
     * @param OrderHandler $orderHandler
     * @Rest\Patch("/orders/{orders}/accept")
     * @return Orders
     */
    public function acceptAction(Orders $orders, OrderHandler $orderHandler)
    {
        return $orderHandler->accept($orders);
    }

    /**
     * @param Orders $orders
     * @param OrderHandler $orderHandler
     * @Rest\Patch("/orders/{orders}/refuse")
     * @return Orders
     */
    public function refuseAction(Orders $orders, OrderHandler $orderHandler)
    {
        return $orderHandler->refuse($orders);
    }
}