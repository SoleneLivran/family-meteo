<?php

namespace App\Form;

use App\Entity\Home;
use App\Entity\Relative;
use App\Repository\HomeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class RelativeType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

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
            "homes",
            EntityType::class,
            [
                "by_reference" => false, // to be able to write on the non-owner side of the relationship
                "label" => "Foyer :",
                "class" => Home::class,
                "query_builder" => function (HomeRepository $repository) {
                    return $repository->queryAllByUser($this->security->getUser()->getId());
                },
                "choice_label" => "name",
                "multiple" => true,
                "expanded" => true,
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
