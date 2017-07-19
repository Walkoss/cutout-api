<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Handler\CatalogHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class CatalogController
 * @package AppBundle\Controller\Provider
 * @Rest\RouteResource("catalogs")
 */
class CatalogController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Create a catalog
     *
     * @Rest\Post("/catalogs")
     * @param CatalogHandler $catalogHandler
     * @return \AppBundle\Entity\Catalog|string
     */
    public function newAction(CatalogHandler $catalogHandler)
    {
        return $catalogHandler->post();
    }
}