<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Entity\Catalog;
use AppBundle\Entity\Provider;
use AppBundle\Handler\CatalogHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class CatalogController
 * @package AppBundle\Controller\Provider
 * @Rest\RouteResource("catalogs")
 */
class CatalogController extends FOSRestController
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

    /**
     * Get all Catalog from the authenticated provider
     *
     * @Rest\Get("/catalogs")
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllAction()
    {
        /** @var Provider $provider */
        $provider = $this->getUser();

        return $provider->getCatalogs();
    }

    /**
     * Delete a catalog
     *
     * @param Catalog $catalog
     */
    public function deleteAction(Catalog $catalog)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($catalog);
        $em->flush();
    }

    /**
     * Edit a catalog (partially)
     *
     * @param Catalog $catalog
     * @param CatalogHandler $catalogHandler
     * @return Catalog|string
     */
    public function patchAction(Catalog $catalog, CatalogHandler $catalogHandler)
    {
        return $catalogHandler->patch($catalog);
    }

    /**
     * Edit a catalog (fully)
     *
     * @param Catalog $catalog
     * @param CatalogHandler $catalogHandler
     * @return Catalog|string
     */
    public function putAction(Catalog $catalog, CatalogHandler $catalogHandler)
    {
        return $catalogHandler->put($catalog);
    }
}