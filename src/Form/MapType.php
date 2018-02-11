<?php

namespace App\Form;

use App\Entity\Map;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('miasto', ChoiceType::class, [
//                'choices' => [
//                    Map::class
//                ],
//            ]
            ->add('miasto', EntityType::class,
                [
                    'class' => Map::class,
                    'choice_label' => 'city_name',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
