<?php

namespace AppBundle\Controller\Provider;

use AppBundle\Entity\Provider;
use AppBundle\Form\ProviderType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Create a new Provider
     *
     * @Rest\Post("/register", name="_provider")
     */
    public function postAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $provider = new Provider();
        $form = $this->createForm(ProviderType::class, $provider);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($provider, $provider->getPlainPassword());
            $provider->setPassword($password);
            $provider->eraseCredentials();

            $em->persist($provider);
            $em->flush();

            return $provider;
        } else {
            throw new HttpException(400, (string)$form->getErrors(true));
        }
    }
}