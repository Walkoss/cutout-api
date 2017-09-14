<?php

namespace AppBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PaymentTypeTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function transform($value)
    {
        if ($value === null) {
            return '';
        }

        return $value->getCode();
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }

        $paymentType = $this->em
            ->getRepository('AppBundle:PaymentType')
            ->findOneByCode($value);

        if (null === $paymentType) {
            throw new TransformationFailedException(sprintf(
                'PaymentType "%s" does not exist!',
                $value
            ));
        }

        return $paymentType;
    }
}