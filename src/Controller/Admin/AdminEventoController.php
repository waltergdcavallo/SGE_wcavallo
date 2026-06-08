<?php

namespace App\Controller\Admin;

use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

/* final class AdminEventoController extends AbstractController
{
    #[Route('/admin/admin/evento', name: 'app_admin_admin_evento')]
    public function index(): Response
    {
        return $this->render('admin/admin_evento/index.html.twig', [
            'controller_name' => 'Admin/AdminEventoController',
        ]);
    }
} */

#[Route('/admin/evento')]
class AdminEventoController extends AbstractController
{
    #[Route(
        '/listar',
        name: 'admin_evento_listar'
    )]
    public function listar(
        EventoRepository $eventoRepository
    ): Response
    {
        $eventos = $eventoRepository->findEventosAlfabeticamente();

        return $this->render(
            'admin/evento/listar.html.twig',
            [
                'eventos' => $eventos
            ]
        );
    }

    #[Route(
    '/inscriptos/{id}',
    name: 'admin_evento_inscriptos',
    requirements: ['id' => '\d+']
    )]
        public function inscriptos(
        int $id,
        EventoRepository $eventoRepository
    ): Response
    {
        $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'Evento no encontrado'
            );
        }

        return $this->render(
            'admin/evento/inscriptos.html.twig',
            [
                'evento' => $evento
            ]
        );
    }

    #[Route(
        '/borrar/{id}',
        name: 'admin_evento_borrar',
        requirements: ['id' => '\d+']
    )]
    public function borrar(
        int $id,
        EventoRepository $eventoRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado.'
            );
        }

        $entityManager->remove($evento);

        $entityManager->flush();

        return $this->render(
            'admin/evento/borrar.html.twig',
            [
                'evento' => $evento
            ]
        );
    }
}
