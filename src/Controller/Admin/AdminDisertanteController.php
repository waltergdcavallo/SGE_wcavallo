<?php

namespace App\Controller;

use App\Entity\Disertante;
use App\Form\DisertanteType;
use App\Repository\DisertanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/disertantes')]
class AdminDisertanteController extends AbstractController
{
    #[Route(
        '/listar',
        name: 'admin_disertante_listar'
    )]
    public function listar(
        DisertanteRepository $disertanteRepository
    ): Response
    {
        return $this->render(
            'admin/disertante/listar.html.twig', 
            [
                'disertantes' => $disertanteRepository->findDisertantesAlfabeticamente(),
            ]
        );
    }

    #[Route(
        '/nuevo', 
        name: 'admin_disertante_nuevo', 
        methods: ['GET', 'POST']
    )]
    public function nuevo(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response{
        $disertante = new Disertante();

        $form = $this->createForm(
            DisertanteType::class, 
            $disertante
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($disertante);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Disertante creado correctamente.'
            );

            return $this->redirectToRoute(
                'admin_disertante_listar'
            );
        }

        return $this->render(
            'admin_disertante/nuevo.html.twig', 
            [
                'form' => $form,
            ]
        );
    }

    #[Route(
        '/{id}', 
        name: 'admin_disertante_ver', 
        methods: ['GET']
    )]
    public function ver(
        Disertante $disertante
    ): Response
    {
        return $this->render('admin_disertante/ver.html.twig', [
            'disertante' => $disertante,
        ]);
    }

    #[Route(
        '/{id}/edit', 
        name: 'admin_disertante_editar', 
        methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Disertante $disertante, 
        EntityManagerInterface $entityManager
    ): Response
    {
        $form = $this->createForm(
            DisertanteType::class, 
            $disertante
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_disertante_listar');
        }

        return $this->render('admin_disertante/editar.html.twig', [
            'disertante' => $disertante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', 
        name: 'admin_disertante_borrar', 
        methods: ['POST']
    )]
    public function delete(
        Request $request, 
        Disertante $disertante, 
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($this->isCsrfTokenValid(
            'delete'.$disertante->getId(), 
            $request->getPayload()->getString('_token')
        )) {
            $entityManager->remove($disertante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_disertante_listar');
    }
}
