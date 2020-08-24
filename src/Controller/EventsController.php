<?php

namespace App\Controller;

use App\Entity\Relative;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/events", name="event_list")
     */
    public function eventsCalendar() {
        /** @var RelativeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Relative::class);
        $relatives = $repository->findAll();

        usort($relatives, function (Relative $a, Relative $b) {
            $aBirthday = $a->getNextBirthday();
            $bBirthday = $b->getNextBirthday();

            if ($aBirthday == $bBirthday) {
                return 0;
            }

            return ($aBirthday < $bBirthday) ? -1 : 1;
        });

        $relatives = array_filter($relatives, function(Relative $relative) {
            return $relative->getNextBirthday() !== null;
        });

        return $this->render(
            'event/list.html.twig',
            [
                "relatives" => $relatives,
            ]
        );
    }
}