<?php

namespace App\Controller;

use App\Entity\Home;
use App\Form\HomeType;
use App\Service\AddressCoordinatesFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class HomeController extends AbstractController
{
    use TargetPathTrait;

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
            $coordinates = $this->addressCoordinatesFinder->getLatitudeAndLongitude($home->getCityName(), $home->getPostCode());

            $latitude = $coordinates[0]['lat'];
            $home->setLatitude($latitude);

            $longitude = $coordinates[0]['lon'];
            $home->setLongitude($longitude);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($home);
            $manager->flush();

            $this->addFlash("success", "Le foyer a bien été ajouté");
            return $this->redirectToRoute("relative_add");

            // TODO redirect to previous page
            // $url = $this->getTargetPath($request->getSession(), 'main');
            // if (!$url) {
            //     return $this->redirectToRoute("relative_list");
            // }
            // return new RedirectResponse($url);

            // ? document.referrer() 
            // ------------------------------
            // ? window.history.back()

            // ------------------------------

            // $request->getSession()->set('referer', $request->headers->get('referer'));
            // if ($request->getSession()->get('referer')) {
            //     return $this->redirect($request->getSession()->get('referer'));
            // }

            // return $this->redirectToRoute("relative_list");

            // ------------------------------

            // $referer = $this->getRequest()->headers->get('referer');
            // return $this->redirect($referer);
        }

        return $this->render(
            'home/add.html.twig',
            [
                "homeForm" => $homeForm->createView()
            ]
        );
    }
}