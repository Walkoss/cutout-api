<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class GenderTypeHandler
{
    use ControllerTrait;

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
     * GenderTypeHandler constructor.
     * @param RequestStack $requestStack
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $entityManager
     * @param ContainerInterface $container
     * @internal param RequestStack $request
     * @internal param EntityRepository $entityRepository
     */
    public function __construct(RequestStack $requestStack, FormFactoryInterface $formFactory, EntityManager $entityManager, ContainerInterface $container)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    public function all()
    {
        return $this->entityManager->getRepository('AppBundle:GenderType')->findAll();
    }
}