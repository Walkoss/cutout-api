<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Handler\ProviderHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;

/**
 * Class ProviderController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("providers")
 */
class ProviderController extends FOSRestController
{
    /**
     * Get all Provider
     *
     * @Rest\Get("/providers")
     * @param ProviderHandler $providerHandler
     * @param ParamFetcherInterface $paramFetcher
     *
     * @Rest\QueryParam(name="is_available", requirements="(true|false)", description="Search providers available or not", default="true")
     * @Rest\QueryParam(name="gender_type", requirements="\d+", description="GenderType's id")
     * @Rest\QueryParam(name="catalog_type", requirements="\d+", description="CatalogType's id")
     *
     * @return mixed
     */
    public function getAllAction(ProviderHandler $providerHandler, ParamFetcherInterface $paramFetcher)
    {
        return $providerHandler->all($paramFetcher, $this->getUser());
    }
}