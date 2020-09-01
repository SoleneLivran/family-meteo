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

    public function __construct(MeteoFinder $meteoFinder)
    {
        $this->meteoFinder = $meteoFinder;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        // Get all homes
        /** @var HomeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Home::class);
        $homes = $repository->findAllByUser($this->getUser()->getId());

        $userHomes = array_filter($homes, function(Home $home) {
            return $home->isUserHome();
        });
        $relativesHomes = array_filter($homes, function(Home $home) {
            return !$home->isUserHome();
        });

        $meteos = [];

        foreach ($homes as $home) {
            $meteo = $this->meteoFinder->getMeteoForHome($home);
            $meteos[$home->getId()] = $meteo;
        }
        
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
