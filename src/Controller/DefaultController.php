<?php

namespace App\Controller;

use App\Entity\Home;
use App\Model\QuoteModel;
use App\Service\MeteoFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $meteoFinder;

    // inject MeteoFinder service
    public function __construct(MeteoFinder $meteoFinder)
    {
        $this->meteoFinder = $meteoFinder;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        // Get all homes associated with connected user in the DB (=created by this user), by user's ID.
        // Stored in "$homes".
        /** @var HomeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Home::class);
        $homes = $repository->findAllByUser($this->getUser()->getId());

        // Among all homes associated to the user : find the one(s) with data "isUserHome == true" = where user lives
        $userHomes = array_filter($homes, function(Home $home) {
            return $home->isUserHome();
        });
        // Among all homes associated to the user : find the one(s) with data "isUserHome == false" = where user's relatives/family live
        $relativesHomes = array_filter($homes, function(Home $home) {
            return !$home->isUserHome();
        });

        // Use meteoFinder service to get the meteo for all homes
        $meteos = $this->meteoFinder->getMeteo($homes);

        // send to view : all meteos, user home(s), relatives home(s), and a quote from the quoteModel
        return $this->render(
            'default/index.html.twig',
            [
                "relativesHomes" => $relativesHomes,
                "userHomes" => $userHomes,
                "meteos" => $meteos,
                "quote" => QuoteModel::getQuote(),
            ]
        );
    }
}
