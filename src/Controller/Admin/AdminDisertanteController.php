<?php

namespace App\Controller;

use App\Entity\Disertante;
use App\Form\DisertanteType;
use App\Repository\DisertanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/disertante')]
class AdminDisertanteController extends AbstractController
{
    #[Route(
        name: 'app_admin_disertante_index',
         methods: ['GET', 'POST']
    )]
    public function index(
        DisertanteRepository $disertanteRepository
    ): Response
    {
        return $this->render(
            'admin_disertante/index.html.twig', 
            [
                'disertantes' => $disertanteRepository->findDisertantesAlfabeticamente(),
            ]
        );
    }

    #[Route('/new', name: 'app_admin_disertante_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $disertante = new Disertante();
        $form = $this->createForm(DisertanteType::class, $disertante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($disertante);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_disertante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_disertante/new.html.twig', [
            'disertante' => $disertante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_disertante_show', methods: ['GET'])]
    public function show(Disertante $disertante): Response
    {
        return $this->render('admin_disertante/show.html.twig', [
            'disertante' => $disertante,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_disertante_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Disertante $disertante, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DisertanteType::class, $disertante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_disertante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_disertante/edit.html.twig', [
            'disertante' => $disertante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_disertante_delete', methods: ['POST'])]
    public function delete(Request $request, Disertante $disertante, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disertante->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($disertante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_disertante_index', [], Response::HTTP_SEE_OTHER);
    }
}
