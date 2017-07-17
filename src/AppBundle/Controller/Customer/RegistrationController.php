<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @RouteResource("register", pluralize=false)
 */
class RegistrationController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Create a new Customer
     *
     * @Rest\Post("/register", name="_customer")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Customer
     */
    public function postAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($customer, $customer->getPlainPassword());
            $customer->setPassword($password);
            $customer->eraseCredentials();

            $em->persist($customer);
            $em->flush();

            return $customer;
        } else {
            throw new HttpException(400, (string)$form->getErrors(true));
        }
    }
}