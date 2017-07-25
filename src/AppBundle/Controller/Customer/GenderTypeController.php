<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Handler\GenderTypeHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class GenderTypeController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("gender-types")
 */
class GenderTypeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/gender-types", name="_customer")
     * @param GenderTypeHandler $genderTypeHandler
     * @return \AppBundle\Entity\GenderType[]|array
     */
    public function cgetAction(GenderTypeHandler $genderTypeHandler)
    {
        return $genderTypeHandler->all();
    }
}