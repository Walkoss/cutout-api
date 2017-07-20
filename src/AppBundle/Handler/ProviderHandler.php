<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Provider;
use AppBundle\Form\ProviderType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProviderHandler
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * ProviderHandler constructor.
     * @param RequestStack $requestStack
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @internal param RequestStack $request
     * @internal param EntityRepository $entityRepository
     */
    public function __construct(RequestStack $requestStack, FormFactoryInterface $formFactory, EntityManager $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    public function patch(Provider $provider)
    {
        return $this->processForm($provider);
    }

    public function put(Provider $provider)
    {
        return $this->processForm($provider);
    }

    public function processForm(Provider $provider)
    {
        $form = $this->formFactory->create(
            ProviderType::class,
            $provider,
            [
                'method' => $this->request->getMethod(),
            ]
        );

        $form->submit($this->request->request->all(), 'PATCH' !== $this->request->getMethod());

        if ($form->isSubmitted() && $form->isValid()) {
            if ($provider->getPlainPassword() !== null) {
                $password = $this->encoder->encodePassword($provider, $provider->getPlainPassword());
                $provider->setPassword($password);
                $provider->eraseCredentials();
            }

            $this->entityManager->persist($provider);
            $this->entityManager->flush();

            return $provider;
        }

        return (string)$form->getErrors(true);
    }
}