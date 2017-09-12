<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Handler\CatalogTypeHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class CatalogTypeController
 * @package AppBundle\Controller\Provider
 * @Rest\RouteResource("catalog-types")
 */
class CatalogTypeController extends FOSRestController
{
    /**
     * Get all CatalogType
     *
     * @Rest\Get("/catalog-types")
     * @param CatalogTypeHandler $catalogTypeHandler
     * @return \AppBundle\Entity\CatalogType[]|array
     */
    public function getAllAction(CatalogTypeHandler $catalogTypeHandler)
    {
        return $catalogTypeHandler->all();
    }
}