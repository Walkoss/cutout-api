<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Provider;
use AppBundle\Handler\ReviewHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class ReviewController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("reviews")
 */
class ReviewsController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Create a review
     *
     * @Rest\Post("/reviews")
     * @param ReviewHandler $reviewHandler
     * @return \AppBundle\Entity\Review|string
     */
    public function newAction(ReviewHandler $reviewHandler)
    {
        return $reviewHandler->post();
    }

    /**
     * @Rest\Get("/reviews", name="_customer")
     */
    public function cgetAction()
    {
        /** @var Customer $customer */
        $customer = $this->getUser();

        return $customer->getReviews();
    }

    /**
     * @Rest\Get("/providers/{provider}/reviews")
     * @param Provider $provider
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProviderReviewsAction(Provider $provider)
    {
        return $provider->getReviews();
    }
}