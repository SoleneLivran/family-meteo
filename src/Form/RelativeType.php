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

class RelativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'firstname',
            TextType::class,
            [
                "label" => "Prénom",
            ]
        );

        $builder->add(
            'lastname',
            TextType::class,
            [
                "label" => "Nom",
            ]
        );

        $builder->add(
            'birthdate',
            DateType::class,
            [
                "label" => "Date de naissance",
                "required" => false,
                "widget" => "single_text"
            ]
        );

        $builder->add(
            "home",
            EntityType::class,
            [
                "label" => "Foyer",
                "class" => Home::class,
                "choice_label" => "name",
                "required" => false,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Relative::class,
        ]);
    }
}
