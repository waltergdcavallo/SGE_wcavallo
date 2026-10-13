<?php

namespace App\Form;

use App\Entity\Disertante;
use App\Entity\Evento;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', null,[
                'label'=>'Nombre del evento',
                'attr'=>[
                    'placeholder'=>'Ingrese el nombre del evento',
                ],
            ])

            ->add('descripcion', null,[
                'label'=>'Descripción',
                'attr'=>[
                    'placeholder'=>'Ingrese una descripción',
                ],
            ])

            ->add('fecha', null, [
                'label'=>'Fecha del evento',
            ])

            ->add('hora', null, [
                'label'=>'Hora del evento',
            ])

            ->add('duracion', null, [
                'label'=>'Duración',
                'attr'=>[
                    'placeholder'=>'Ingrese la duración',
                ],
            ])
            
            ->add('idioma', null, [
                'label'=>'Idioma del evento',
                'attr'=>[
                    'placeholder'=>'Ingrese el idioma',
                ],
            ])

            ->add('estado', null, [
                'label'=>'Estado del evento',
                'attr'=>[
                    'placeholder'=>'Ingrese el estado del evento',
                ],
            ])

            ->add('disertante', EntityType::class, [
                'class' => Disertante::class,
                'choice_label' => 'nombre',
            ])

            ->add('usuarios', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])

            ->add('capacidad', null, [
                'label'=>'Capacidad del evento',
                'attr'=>[
                    'placeholder'=>'Ingrese la capacidad del evento',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
