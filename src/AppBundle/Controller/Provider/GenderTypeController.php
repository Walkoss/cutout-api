<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Handler\GenderTypeHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class GenderTypeController
 * @package AppBundle\Controller\Provider
 * @Rest\RouteResource("gender-types")
 */
class GenderTypeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/gender-types")
     * @param GenderTypeHandler $genderTypeHandler
     * @return \AppBundle\Entity\GenderType[]|array
     */
    public function cgetAction(GenderTypeHandler $genderTypeHandler)
    {
        return $genderTypeHandler->all();
    }
}