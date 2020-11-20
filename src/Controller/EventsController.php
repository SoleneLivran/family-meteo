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
        // Get all the relatives (people) associated with connected user in the DB (=created by this user), by user's ID.
        // Stored in "$relatives"
        /** @var RelativeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Relative::class);
        $relatives = $repository->findAllByUser($this->getUser()->getId());

        // Filter the array : remove relatives with no birthdate
        $relatives = array_filter($relatives, function(Relative $relative) {
            return $relative->getBirthdate() !== null;
        });

        // Sort relatives by their next birthday :
        usort($relatives, function (Relative $a, Relative $b) {
            // compare two incoming birthdays
            $aBirthday = $a->getNextBirthday();
            $bBirthday = $b->getNextBirthday();

            // don't change order if the two birthdays are the same day
            if ($aBirthday == $bBirthday) {
                return 0;
            }

            // the relative with the earliest birthday moves up in the array, the other moves down
            return ($aBirthday < $bBirthday) ? -1 : 1;
        });

        // send to view the relatives, sorted by next birthday
        return $this->render(
            'event/list.html.twig',
            [
                "relatives" => $relatives,
            ]
        );
    }
}