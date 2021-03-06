<?php

namespace App\Controller;

use App\Entity\Home;
use App\Entity\Relative;
use App\Form\RelativeType;
use App\Repository\RelativeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RelativeController extends AbstractController
{
    /**
     * @Route("/relatives/{id}", name="relative_view", requirements={"id"="\d+"})
     *
     * @param Relative $relative
     *
     * @return Response
     */
    public function view(Relative $relative)
    {
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
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function add(Request $request)
    {
        $relative = new Relative();

        $relativeForm = $this->createForm(RelativeType::class, $relative);
        $relativeForm->handleRequest($request);
        if($relativeForm->isSubmitted() && $relativeForm->isValid()) {

            // set current user as creator for this relative
            $relative->setCreatedBy($this->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($relative);
            $manager->flush();

            //success message
            $this->addFlash("success", "Le proche a bien été ajouté");
            // TODO : error message

            // after adding relative, redirect to a page if specified
            if ($request->query->has('redirectTo')) {
                return $this->redirect($request->query->get('redirectTo'));
            }

            // else, after adding home, redirect to the "home list" page
            // TODO : re-work this logic for UX
            return $this->redirectToRoute("home_list");
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
     *
     * @param Relative $relative
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function update(Relative $relative, Request $request)
    {
        $relativeForm = $this->createForm(RelativeType::class, $relative);
        $relativeForm->handleRequest($request);
        if($relativeForm->isSubmitted() && $relativeForm->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            // success message
            $this->addFlash("success", "Le proche a bien été modifié");
            // TODO : error message

            // after adding relative, redirect to a page if specified
            if ($request->query->has('redirectTo')) {
                return $this->redirect($request->query->get('redirectTo'));
            }

            // else, after adding home, redirect to the "home list" page
            // TODO : re-work this logic for UX
            return $this->redirectToRoute("home_list");
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
     *
     * @param Relative $relative
     *
     * @return RedirectResponse
     */
    public function delete(Relative $relative)
    {
        $manager = $this->getDoctrine()->getManager(); 
        $manager->remove($relative);
        $manager->flush();

        // success message
        $this->addFlash("success", "Supprimé de la liste");
        // TODO error message

        return $this->redirectToRoute('home_list');
    }
}