<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Orders;
use AppBundle\Entity\OrderStatus;
use AppBundle\Entity\PaymentStatus;
use AppBundle\Form\OrdersType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderHandler
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

    public function accept(Orders $orders)
    {
        $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::ACCEPTED);
        $orders->setOrderStatus($orderStatus);
        $this->entityManager->flush();

        return $orders;
    }

    public function refuse(Orders $orders)
    {
        $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::REFUSED);
        $orders->setOrderStatus($orderStatus);

        $paymentStatusCancelled = $this->entityManager->getRepository('AppBundle:PaymentStatus')->findOneByCode(PaymentStatus::CANCELLED);
        $orders->getPayment()->setPaymentStatus($paymentStatusCancelled);

        $this->entityManager->flush();

        return $orders;
    }

    public function cancel(Orders $orders)
    {
        $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::CANCELLED);
        $orders->setOrderStatus($orderStatus);
        $this->entityManager->flush();

        return $orders;
    }


    public function complete(Orders $orders)
    {
        $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::COMPLETED);
        $orders->setOrderStatus($orderStatus);
        $this->entityManager->flush();

        return $orders;
    }

    public function post()
    {
        return $this->processForm(new Orders());
    }

    public function processForm(Orders $order)
    {
        $form = $this->formFactory->create(
            OrdersType::class,
            $order,
            [
                'method' => $this->request->getMethod(),
            ]
        );

        $form->submit($this->request->request->all(), 'PATCH' !== $this->request->getMethod());

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setCustomer($this->getUser());
            $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::PENDING);
            $order->setOrderStatus($orderStatus);

            $paymentStatusPending = $this->entityManager->getRepository('AppBundle:PaymentStatus')->findOneByCode(PaymentStatus::PENDING);
            $order->getPayment()->setPaymentStatus($paymentStatusPending);

            $this->entityManager->persist($order);
            $this->entityManager->flush();

            return $order;
        }

        return (string)$form->getErrors(true);
    }
}