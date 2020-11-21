<?php

namespace App\Form;

use App\Entity\Home;
use App\Entity\Relative;
use App\Repository\RelativeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class HomeType extends AbstractType
{
    private $security;

    // inject Security to be able to get "user"
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
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
                "label" => "Membres du foyer :",
                "class" => Relative::class,
                "query_builder" => function (RelativeRepository $repository) {
                    // list of relatives that were created by current user only
                    return $repository->queryAllByUser($this->security->getUser()->getId());
                },
                "choice_label" => function (Relative $relative) {
                    // getFullName() declared in RelativeController
                    return $relative->getFullName();
                },
                "multiple" => true,
                "expanded" => true,
            ]
        );

        $builder->add(
            "isUserHome",
            CheckboxType::class,
            [
            'label' => "Il s'agit de mon foyer",
            'required' => false,
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
