<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Handler\CatalogTypeHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class CatalogTypeController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("catalog-types")
 */
class CatalogTypeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/catalog-types", name="_customer")
     * @param CatalogTypeHandler $catalogTypeHandler
     * @return \AppBundle\Entity\CatalogType[]|array
     */
    public function cgetAction(CatalogTypeHandler $catalogTypeHandler)
    {
        return $catalogTypeHandler->all();
    }
}