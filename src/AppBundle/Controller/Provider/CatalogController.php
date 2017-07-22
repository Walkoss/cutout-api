<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Entity\Catalog;
use AppBundle\Entity\Provider;
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

    public function cgetAction()
    {
        /** @var Provider $provider */
        $provider = $this->getUser();

        return $provider->getCatalogs();
    }

    public function deleteAction(Catalog $catalog)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($catalog);
        $em->flush();
    }

    public function patchAction(Catalog $catalog, CatalogHandler $catalogHandler)
    {
        return $catalogHandler->patch($catalog);
    }

    public function putAction(Catalog $catalog, CatalogHandler $catalogHandler)
    {
        return $catalogHandler->put($catalog);
    }
}