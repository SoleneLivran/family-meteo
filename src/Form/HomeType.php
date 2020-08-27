<?php

namespace App\Form;

use App\Entity\Home;
use App\Entity\Relative;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                "label" => "Nom du foyer",
            ]
        );

        $builder->add(
            'postCode',
            TextType::class,
            [
                "label" => "Code postal",
            ]
        );

        $builder->add(
            'cityName',
            TextType::class,
            [
                "label" => "Ville",
            ]
        );

        $builder->add(
            'country',
            TextType::class,
            [
                "label" => "Pays",
            ]
        );

        $builder->add(
            "relatives",
            EntityType::class,
            [
                "label" => "Selectionner les membres du foyer, ou",
                "class" => Relative::class,
                "choice_label" => function ($relative) {
                    return $relative->getFullName();
                },
                "multiple" => true,
                "expanded" => true,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Home::class,
        ]);
    }
}
