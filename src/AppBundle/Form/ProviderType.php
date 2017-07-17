<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\ProviderTypeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProviderType extends AbstractType
{
    /**
     * @var ProviderTypeTransformer
     */
    private $providerTypeTransformer;

    /**
     * ProviderType constructor.
     */
    public function __construct(ProviderTypeTransformer $providerTypeTransformer)
    {
        $this->providerTypeTransformer = $providerTypeTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class)
            ->add('phone', TextType::class)
            ->add('name', TextType::class)
            ->add('isFreelance', CheckboxType::class)
            ->add('isAvalaible', CheckboxType::class)
            ->add('range', IntegerType::class)
            ->add('providerType', TextType::class, [
                'invalid_message' => 'ProviderType Code is not valid',
            ]);

        $builder->get('providerType')
            ->addModelTransformer($this->providerTypeTransformer);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Provider',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_provider';
    }
}
