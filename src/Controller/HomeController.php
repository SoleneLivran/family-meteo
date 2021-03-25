<?php

namespace App\Controller;

use App\Entity\Home;
use App\Form\HomeType;
use App\Repository\HomeRepository;
use App\Service\AddressCoordinatesFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class HomeController extends AbstractController
{
    use TargetPathTrait;

    private $addressCoordinatesFinder;

    // inject AddressCoordinatesFinder service
    public function __construct(AddressCoordinatesFinder $addressCoordinatesFinder)
    {
        $this->addressCoordinatesFinder = $addressCoordinatesFinder;
    }

    /**
     * @Route("/homes", name="home_list")
     */
    public function list()
    {
        // Get all the homes associated with connected user in the DB (=created by this user), by user's ID.
        // Stored in "$relatives"
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
     *
     * @param Home $home
     *
     * @return Response
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
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function add(Request $request)
    {
        $home = new Home();

        $homeForm = $this->createForm(HomeType::class, $home);
        $homeForm->handleRequest($request);
        if($homeForm->isSubmitted() && $homeForm->isValid()) {
            // TODO : use a doctrine watcher/event on pre-persist
            // find and set latitude and longitude for the created home from typed address, using the AdressCoordinateFinder service
            $coordinates = $this->addressCoordinatesFinder->getLatitudeAndLongitude($home->getCityName(), $home->getPostCode(), $home->getCountry());

            $latitude = $coordinates[0]['lat'];
            $home->setLatitude($latitude);

            $longitude = $coordinates[0]['lon'];
            $home->setLongitude($longitude);
            // TODO : end

            // set current user as creator for this home
            $home->setCreatedBy($this->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($home);
            $manager->flush();

            // success message
            $this->addFlash("success", "Le foyer a bien été ajouté");

            // TODO error message

            // after adding home, redirect to a page if specified
            if ($request->query->has('redirectTo')) {
                return $this->redirect($request->query->get('redirectTo'));
            }

            // else, after adding home, redirect to the "add relative" page
            // TODO : re-work this logic for UX
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
     *
     * @param Home $home
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function update(Home $home, Request $request)
    {
        $homeForm = $this->createForm(HomeType::class, $home);
        $homeForm->handleRequest($request);
        if($homeForm->isSubmitted() && $homeForm->isValid()) {
            // TODO : use a doctrine watcher/event on preupdate des champs "cityName", "postCode", "country"
            // find and set latitude and longitude for the updated home from typed address, using the AdressCoordinateFinder service
            $coordinates = $this->addressCoordinatesFinder->getLatitudeAndLongitude($home->getCityName(), $home->getPostCode(), $home->getCountry());

            $latitude = $coordinates[0]['lat'];
            $home->setLatitude($latitude);

            $longitude = $coordinates[0]['lon'];
            $home->setLongitude($longitude);
            // TODO : end

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            // success message
            $this->addFlash("success", "Le foyer a bien été modifié");

            // TODO : error message

            // after adding home, redirect to a page if specified
            if ($request->query->has('redirectTo')) {
                return $this->redirect($request->query->get('redirectTo'));
            }

            // else, after adding home, redirect to the "home list" page
            // TODO : re-work this logic for UX
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
     *
     * @param Home $home
     *
     * @return RedirectResponse
     */
    public function delete(Home $home)
    {
        $manager = $this->getDoctrine()->getManager(); 
        $manager->remove($home);
        $manager->flush();
        
        $this->addFlash("success", "Supprimé de la liste");
        // TODO : error message

        return $this->redirectToRoute('home_list');
    }

}