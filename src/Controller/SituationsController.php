<?php

namespace App\Controller;

use App\Entity\Situations;
use App\Form\SituationsType;
use App\Repository\SituationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/situations")
 */
class SituationsController extends AbstractController
{
    /**
     * @Route("/", name="situations_index", methods={"GET"})
     */
    public function index(SituationsRepository $situationsRepository): Response
    {
        return $this->render('situations/index.html.twig', [
            'situations' => $situationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="situations_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $situation = new Situations();
        $form = $this->createForm(SituationsType::class, $situation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($situation);
            $entityManager->flush();

            return $this->redirectToRoute('situations_index');
        }

        return $this->render('situations/new.html.twig', [
            'situation' => $situation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="situations_show", methods={"GET"})
     */
    public function show(Situations $situation): Response
    {
        return $this->render('situations/show.html.twig', [
            'situation' => $situation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="situations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Situations $situation): Response
    {
        $form = $this->createForm(SituationsType::class, $situation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('situations_index');
        }

        return $this->render('situations/edit.html.twig', [
            'situation' => $situation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="situations_delete", methods={"POST"})
     */
    public function delete(Request $request, Situations $situation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$situation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($situation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('situations_index');
    }
}
