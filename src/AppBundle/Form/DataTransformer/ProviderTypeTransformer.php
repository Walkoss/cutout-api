<?php

namespace AppBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProviderTypeTransformer implements DataTransformerInterface
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

        $providerType = $this->em
            ->getRepository('AppBundle:ProviderType')
            ->findOneByCode($value);

        if (null === $providerType) {
            throw new TransformationFailedException(sprintf(
                'ProviderType "%s" does not exist!',
                $value
            ));
        }

        return $providerType;
    }
}