<?php

namespace AppBundle\Controller\Provider;

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
    public function patchAction(Orders $order, OrderHandler $orderHandler)
    {
        return $orderHandler->patch($order);
    }

    public function putAction(Orders $order, OrderHandler $orderHandler)
    {
        return $orderHandler->put($order);
    }
}