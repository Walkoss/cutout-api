<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Orders;
use AppBundle\Entity\OrderStatus;
use AppBundle\Entity\PaymentStatus;
use AppBundle\Entity\PaymentType;
use AppBundle\FCM\FCMApi;
use AppBundle\Form\OrdersType;
use Doctrine\ORM\EntityManager;
use Stripe\Stripe;
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
     * @var FCMApi
     */
    private $fcpApi;

    /**
     * ProviderHandler constructor.
     * @param RequestStack $requestStack
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $entityManager
     * @param ContainerInterface $container
     * @param FCMApi $fcpApi
     * @internal param RequestStack $request
     * @internal param EntityRepository $entityRepository
     */
    public function __construct(RequestStack $requestStack, FormFactoryInterface $formFactory, EntityManager $entityManager, ContainerInterface $container, FCMApi $fcpApi)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->container = $container;
        $this->fcpApi = $fcpApi;
    }

    public function accept(Orders $orders)
    {
        $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::ACCEPTED);
        $orders->setOrderStatus($orderStatus);

        // Check if the customer choose CC payment type or CASH
        if ($orders->getPayment()->getPaymentType()->getCode() === PaymentType::CC) {
            // Charge the customer
            // Authenticate to stripe API
            Stripe::setApiKey($this->container->getParameter('stripe_sk_key'));
            $customer = $orders->getCustomer();
            $charge = \Stripe\Charge::create(array(
                "amount" => $orders->getCatalog()->getPrice() * 100,
                "currency" => "eur",
                "customer" => $customer->getStripeId(),
                "description" => "Charge for " . $customer->getEmail() . " to " . $orders->getProvider()->getEmail(),
                "capture" => false
            ));
            $orders->getPayment()->setChargeId($charge->id);

            $paymentStatusUncaptured = $this->entityManager->getRepository('AppBundle:PaymentStatus')->findOneByCode(PaymentStatus::UNCAPTURED);
            $orders->getPayment()->setPaymentStatus($paymentStatusUncaptured);
        } else {
            $paymentStatusUnpaid = $this->entityManager->getRepository('AppBundle:PaymentStatus')->findOneByCode(PaymentStatus::UNPAID);
            $orders->getPayment()->setPaymentStatus($paymentStatusUnpaid);
        }

        // Send a notification push to the provider/customer
        $this->sendNotificationPush($orders);

        $this->entityManager->flush();

        return $orders;
    }

    public function refuse(Orders $orders)
    {
        $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::REFUSED);
        $orders->setOrderStatus($orderStatus);

        $paymentStatusCancelled = $this->entityManager->getRepository('AppBundle:PaymentStatus')->findOneByCode(PaymentStatus::CANCELLED);
        $orders->getPayment()->setPaymentStatus($paymentStatusCancelled);

        // Send a notification push to the provider/customer
        $this->sendNotificationPush($orders);

        $this->entityManager->flush();

        return $orders;
    }

    public function cancel(Orders $orders)
    {
        if ($orders->getOrderStatus()->getCode() !== OrderStatus::ACCEPTED) {
            $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::CANCELLED);
            $orders->setOrderStatus($orderStatus);

            $paymentStatusCancelled = $this->entityManager->getRepository('AppBundle:PaymentStatus')->findOneByCode(PaymentStatus::CANCELLED);
            $orders->getPayment()->setPaymentStatus($paymentStatusCancelled);

            // Send a notification push to the provider/customer
            $this->sendNotificationPush($orders);

            $this->entityManager->flush();
        }

        return $orders;
    }

    public function complete(Orders $orders)
    {
        $orderStatus = $this->entityManager->getRepository('AppBundle:OrderStatus')->findOneByCode(OrderStatus::COMPLETED);
        $orders->setOrderStatus($orderStatus);

        // Check if the customer choose CC payment type or CASH
        if ($orders->getPayment()->getPaymentType()->getCode() === PaymentType::CC) {
            // Charge the customer
            // Authenticate to stripe API
            Stripe::setApiKey($this->container->getParameter('stripe_sk_key'));
            $ch = \Stripe\Charge::retrieve($orders->getPayment()->getChargeId());
            $ch->capture();

            $paymentStatusCaptured = $this->entityManager->getRepository('AppBundle:PaymentStatus')->findOneByCode(PaymentStatus::CAPTURED);
            $orders->getPayment()->setPaymentStatus($paymentStatusCaptured);
        } else {
            $paymentStatusPaid = $this->entityManager->getRepository('AppBundle:PaymentStatus')->findOneByCode(PaymentStatus::PAID);
            $orders->getPayment()->setPaymentStatus($paymentStatusPaid);
        }

        // Send a notification push to the provider/customer
        $this->sendNotificationPush($orders);

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

            // Send a notification push to the provider/customer
            $this->sendNotificationPush($order);

            $this->entityManager->persist($order);
            $this->entityManager->flush();

            return $order;
        }

        return (string)$form->getErrors(true);
    }

    private function sendNotificationPush(Orders $order)
    {
        $customerDeviceId = $order->getCustomer()->getDeviceId();
        $providerDeviceId = $order->getProvider()->getDeviceId();

        // TODO: OrderStatus::PENDING CANCELLED
        switch ($order->getOrderStatus()->getCode()) {
            case OrderStatus::ACCEPTED:
                $this->sendAcceptedNoticationPush($order, $customerDeviceId);
                break;
            case OrderStatus::REFUSED:
                $this->sendRefusedNoticationPush($order, $customerDeviceId);
                break;
        }
    }

    private function sendAcceptedNoticationPush(Orders $order, $deviceId)
    {
        if ($deviceId !== null) {
            $this->fcpApi->sendNotification($deviceId,
                [
                    "title" => "Demande acceptée",
                    "body" => $order->getProvider()->getName() . " a accepté votre demande de prestation",
                    "sound" => "default",
                    "icon" => "icon"
                ]
            );
        }
    }

    private function sendRefusedNoticationPush(Orders $order, $deviceId)
    {
        if ($deviceId !== null) {
            $this->fcpApi->sendNotification($deviceId,
                [
                    "title" => "Demande refusée",
                    "body" => $order->getProvider()->getName() . " a refusé votre demande de prestation",
                    "sound" => "default",
                    "icon" => "icon"
                ]
            );
        }
    }
}