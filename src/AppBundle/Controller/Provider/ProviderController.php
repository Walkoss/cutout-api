<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Entity\Provider;
use AppBundle\Handler\ProviderHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class ProviderController
 * @package AppBundle\Controller\Provider
 * @Rest\RouteResource("providers")
 */
class ProviderController extends FOSRestController implements ClassResourceInterface
{
    public function patchAction(Provider $provider, ProviderHandler $providerHandler)
    {
        return $providerHandler->patch($provider);
    }
}