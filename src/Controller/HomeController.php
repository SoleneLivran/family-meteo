<?php

namespace App\Controller;

use App\Entity\Home;
use App\Form\HomeType;
use App\Repository\HomeRepository;
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
     * @Route("/homes", name="home_list")
     */
    public function list(Request $request, HomeRepository $repository)
    {
        /** @var HomeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Home::class);
        $homes = $repository->findAllByUser($this->getUser()->getId());
        
        return $this->render(
            'home/list.html.twig',
            [
                "homes" => $homes
            ]
        );
    }

    /**
     * @Route("/homes/{id}", name="home_view", requirements={"id"="\d+"})
     */
    public function view(Home $home)
    {
        return $this->render(
            'home/view.html.twig',
            [
                "home" => $home
            ]
        );
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
            $coordinates = $this->addressCoordinatesFinder->getLatitudeAndLongitude($home->getCityName(), $home->getPostCode(), $home->getCountry());

            $latitude = $coordinates[0]['lat'];
            $home->setLatitude($latitude);

            $longitude = $coordinates[0]['lon'];
            $home->setLongitude($longitude);

            $home->setCreatedBy($this->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($home);
            $manager->flush();

            $this->addFlash("success", "Le foyer a bien été ajouté");

            if ($request->query->has('redirectTo')) {
                return $this->redirect($request->query->get('redirectTo'));
            }

            return $this->redirectToRoute("relative_add");
        }

        return $this->render(
            'home/add.html.twig',
            [
                "homeForm" => $homeForm->createView()
            ]
        );
    }

    /**
     * @Route("home/{id}/update", name="home_update", requirements={"id"="\d+"})
     */
    public function update(Home $home, Request $request)
    {
        $homeForm = $this->createForm(HomeType::class, $home);
        $homeForm->handleRequest($request);
        if($homeForm->isSubmitted() && $homeForm->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash("success", "Le foyer a bien été modifié");

            if ($request->query->has('redirectTo')) {
                return $this->redirect($request->query->get('redirectTo'));
            }
            
            return $this->redirectToRoute("home_list");
        }

        return $this->render(
            'home/update.html.twig',
            [
                "homeForm" => $homeForm->createView(),
                "home" => $home,
            ]
        );
    }

    /**
     * @Route("home/{id}/delete", name="home_delete", requirements={"id"="\d+"})
     */
    public function delete(Home $home)
    {
        $manager = $this->getDoctrine()->getManager(); 
        $manager->remove($home);
        $manager->flush();
        
        $this->addFlash("success", "Supprimé de la liste");
        return $this->redirectToRoute('home_list');
    }

}