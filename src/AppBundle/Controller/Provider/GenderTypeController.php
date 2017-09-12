<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Handler\GenderTypeHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class GenderTypeController
 * @package AppBundle\Controller\Provider
 * @Rest\RouteResource("gender-types")
 */
class GenderTypeController extends FOSRestController
{
    /**
     * Get all GenderType
     *
     * @Rest\Get("/gender-types")
     * @param GenderTypeHandler $genderTypeHandler
     * @return \AppBundle\Entity\GenderType[]|array
     */
    public function getAllAction(GenderTypeHandler $genderTypeHandler)
    {
        return $genderTypeHandler->all();
    }
}