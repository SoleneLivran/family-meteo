<?php

namespace App\Controller;

use App\Entity\Home;
use App\Entity\Relative;
use App\Form\RelativeType;
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
        $relatives = $repository->findAllByUser($this->getUser()->getId());
        
        return $this->render(
            'relative/list.html.twig',
            [
                "relatives" => $relatives
            ]
        );
    }

    /**
     * @Route("/relatives/{id}", name="relative_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {
        /** @var RelativeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Relative::class);
        $relative = $repository->find($id);
        
        return $this->render(
            'relative/view.html.twig',
            [
                "relative" => $relative
            ]
        );
    }

    /**
     * @Route("/relatives/add", name="relative_add")
     * 
     */
    public function add(Request $request)
    {
        $relative = new Relative();

        $relativeForm = $this->createForm(RelativeType::class, $relative);
        $relativeForm->handleRequest($request);
        if($relativeForm->isSubmitted() && $relativeForm->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($relative);
            $manager->flush();

            $this->addFlash("success", "Le proche a bien été ajouté");
            return $this->redirectToRoute("relative_list");
        }

        return $this->render(
            'relative/add.html.twig',
            [
                "relativeForm" => $relativeForm->createView()
            ]
        );
    }

    /**
     * @Route("relatives/{id}/update", name="relative_update", requirements={"id"="\d+"})
     */
    public function update(Relative $relative, $id, Request $request)
    {
        /** @var RelativeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Relative::class);
        $relative = $repository->find($id);

        $relativeForm = $this->createForm(RelativeType::class, $relative);
        $relativeForm->handleRequest($request);
        if($relativeForm->isSubmitted() && $relativeForm->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash("success", "Le proche a bien été modifié");
            return $this->redirectToRoute("relative_list");
        }

        return $this->render(
            'relative/update.html.twig',
            [
                "relativeForm" => $relativeForm->createView(),
                "relative" => $relative,
            ]
        );
    }

    /**
     * @Route("relatives/{id}/delete", name="relative_delete", requirements={"id"="\d+"})
     */
    public function delete(Relative $relative, $id)
    {
        /** @var RelativeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Relative::class);
        $relative = $repository->find($id);
        
        $manager = $this->getDoctrine()->getManager(); 
        $manager->remove($relative);
        $manager->flush();
        
        $this->addFlash("success", "Supprimé de la liste");
        return $this->redirectToRoute('relative_list');
    }
}