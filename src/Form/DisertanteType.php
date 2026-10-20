<?php

namespace App\Form;

use App\Entity\Disertante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisertanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('biografia')
            ->add('telefono')
            ->add('calles')
            ->add('url')
            ->add('email')
            ->add('twitter')
            ->add('linkedin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disertante::class,
        ]);
    }
}
