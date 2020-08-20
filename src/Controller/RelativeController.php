<?php

namespace App\Controller;

use App\Entity\Relative;
use App\Repository\RelativeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RelativeController extends AbstractController
{
    /**
     * @Route("/relatives", name="relative_list")
     */
    public function list(Request $request, RelativeRepository $repository)
    {
        /** @var RelativeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Relative::class);
        $relatives = $repository->findAllOrderedByFirstName();
        
        return $this->render(
            'relative/list.html.twig',
            [
                "relatives" => $relatives
            ]
        );
    }
}