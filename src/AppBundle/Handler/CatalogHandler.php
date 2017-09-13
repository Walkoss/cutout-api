<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Catalog;
use AppBundle\Form\CatalogType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CatalogHandler
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
     * ProviderHandler constructor.
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

    public function patch(Catalog $catalog)
    {
        return $this->processForm($catalog);
    }

    public function delete(Catalog $catalog)
    {
        $this->entityManager->remove($catalog);
        $this->entityManager->flush();
    }

    public function put(Catalog $catalog)
    {
        return $this->processForm($catalog);
    }

    public function post()
    {
        return $this->processForm(new Catalog());
    }

    public function processForm(Catalog $catalog)
    {
        $form = $this->formFactory->create(
            CatalogType::class,
            $catalog,
            [
                'method' => $this->request->getMethod(),
            ]
        );

        $form->submit($this->request->request->all(), 'PATCH' !== $this->request->getMethod());

        if ($form->isSubmitted() && $form->isValid()) {
            $catalog->setProvider($this->getUser());

            $this->entityManager->persist($catalog);
            $this->entityManager->flush();

            return $catalog;
        }

        return (string)$form->getErrors(true);
    }
}