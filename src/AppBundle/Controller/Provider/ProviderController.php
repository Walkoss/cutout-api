<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Entity\Provider;
use AppBundle\Handler\ProviderHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ProviderController
 * @package AppBundle\Controller\Provider
 * @Rest\RouteResource("providers")
 */
class ProviderController extends FOSRestController
{
    /**
     * @Rest\Get("/me")
     */
    public function meAction()
    {
        return $this->getUser();
    }

    /**
     * Edit a provider (partially)
     *
     * @param Provider $provider
     * @param ProviderHandler $providerHandler
     * @return Provider|string
     */
    public function patchAction(Provider $provider, ProviderHandler $providerHandler)
    {
        if ($provider !== $this->getUser()) {
            throw new AccessDeniedException();
        }

        return $providerHandler->patch($provider);
    }

    /**
     * Edit a provider (fully)
     *
     * @param Provider $provider
     * @param ProviderHandler $providerHandler
     * @return Provider|string
     */
    public function putAction(Provider $provider, ProviderHandler $providerHandler)
    {
        if ($provider !== $this->getUser()) {
            throw new AccessDeniedException();
        }

        return $providerHandler->put($provider);
    }
}