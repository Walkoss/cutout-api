<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Handler\ReviewHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class ReviewController
 * @package AppBundle\Controller\Customer
 * @Rest\RouteResource("reviews")
 */
class ReviewsController extends FOSRestController
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
     * Get all Reviews from the authenticated customer
     *
     * @Rest\Get("/reviews", name="_customer")
     */
    public function getAllAction()
    {
        /** @var Customer $customer */
        $customer = $this->getUser();

        return $customer->getReviews();
    }
}