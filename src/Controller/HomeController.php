<?php

namespace App\Controller;

use App\Entity\Home;
use App\Form\HomeType;
use App\Service\AddressCoordinatesFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $addressCoordinatesFinder;

    public function __construct(AddressCoordinatesFinder $addressCoordinatesFinder)
    {
        $this->addressCoordinatesFinder = $addressCoordinatesFinder;
    }

    /**
     * @Route("/home/add", name="home_add")
     * 
     */
    public function add(Request $request)
    {
        $home = new Home();

        $homeForm = $this->createForm(HomeType::class, $home);
        $homeForm->handleRequest($request);
        if($homeForm->isSubmitted() && $homeForm->isValid()) {

            $coordinates = $this->addressCoordinatesFinder->getLatitudeAndLongitude($home->getPostCode());

            $latitude = $coordinates['data'][0]['latitude'];
            $home->setLatitude($latitude);

            $longitude = $coordinates['data'][0]['longitude'];
            $home->setLongitude($longitude);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($home);
            $manager->flush();

            $this->addFlash("success", "Le foyer a bien été ajouté");
            return $this->redirectToRoute("relative_list");
        }

        return $this->render(
            'home/add.html.twig',
            [
                "homeForm" => $homeForm->createView()
            ]
        );
    }
}