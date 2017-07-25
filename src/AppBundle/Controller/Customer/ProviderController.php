<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Handler\ProviderHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class ProviderController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("providers")
 */
class ProviderController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("/providers")
     * @param ProviderHandler $providerHandler
     * @param ParamFetcherInterface $paramFetcher
     *
     * @Rest\QueryParam(name="is_available", requirements="(true|false)", description="Search providers available or not")
     *
     * @return mixed
     */
    public function cgetAction(ProviderHandler $providerHandler, ParamFetcherInterface $paramFetcher)
    {
        return $providerHandler->all($paramFetcher);
    }
}