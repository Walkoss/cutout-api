<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Entity\Orders;
use AppBundle\Entity\Provider;
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
     * Get all Orders from the authenticated provider
     *
     * @Rest\Get("/orders", name="_provider")
     */
    public function getAllAction()
    {
        /** @var Provider $customer */
        $provider = $this->getUser();

        return $provider->getOrders();
    }

    /**
     * Accept an order as a provider
     *
     * @param Orders $orders
     * @param OrderHandler $orderHandler
     * @Rest\Patch("/orders/{orders}/accept")
     * @return Orders
     */
    public function acceptAction(Orders $orders, OrderHandler $orderHandler)
    {
        if ($orders->getProvider() !== $this->getUser()) {
            throw new AccessDeniedException();
        }

        return $orderHandler->accept($orders);
    }

    /**
     * Refuse an order as a provider
     *
     * @param Orders $orders
     * @param OrderHandler $orderHandler
     * @Rest\Patch("/orders/{orders}/refuse")
     * @return Orders
     */
    public function refuseAction(Orders $orders, OrderHandler $orderHandler)
    {
        if ($orders->getProvider() !== $this->getUser()) {
            throw new AccessDeniedException();
        }

        return $orderHandler->refuse($orders);
    }
}