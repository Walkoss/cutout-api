<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Entity\Provider;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class ReviewsController
 * @package AppBundle\Controller\Provider
 * @Rest\RouteResource("reviews")
 */
class ReviewsController extends FOSRestController
{
    /**
     * Get all reviews from the authenticated provider
     *
     * @Rest\Get("/reviews", name="_provider")
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllAction()
    {
        /** @var Provider $provider */
        $provider = $this->getUser();

        return $provider->getReviews();
    }
}