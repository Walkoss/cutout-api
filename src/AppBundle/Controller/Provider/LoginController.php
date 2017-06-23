<?php

namespace AppBundle\Controller\Provider;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * @RouteResource("login", pluralize=false)
 */
class LoginController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Route(name="_provider")
     */
    public function postAction()
    {
        // route handled by Lexik JWT Authentication Bundle
        throw new \DomainException('You should never see this');
    }
}