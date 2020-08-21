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
        $birthdays = [];

        foreach ($relatives as $relative) {
            $birthday = $relative->getBirthdate();
            $birthdays[$relative->getId()] = $birthday;
        }
        
        return $this->render(
            'event/list.html.twig',
            [
                "birthdays" => $birthdays,
            ]
        );
    }
}