<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\PaymentTypeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    /**
     * @var PaymentTypeTransformer
     */
    private $paymentTypeTransformer;

    /**
     * PaymentType constructor.
     * @param PaymentTypeTransformer $paymentTypeTransformer
     */
    public function __construct(PaymentTypeTransformer $paymentTypeTransformer)
    {
        $this->paymentTypeTransformer = $paymentTypeTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paymentType', TextType::class, [
                'invalid_message' => 'PaymentType Code is not valid'
            ]);

        $builder->get('paymentType')
            ->addModelTransformer($this->paymentTypeTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Payment',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_payment';
    }
}
