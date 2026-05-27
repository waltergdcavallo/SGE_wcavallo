<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventoController extends AbstractController
{
    #[Route('/evento', name: 'app_evento')]
    public function index(): Response
    {
        return $this->render('evento/index.html.twig', [
            'controller_name' => 'EventoController',
        ]);
    }

    #[Route('/eventos', name: 'app_eventos')]
    public function eventos(EventoRepository $repository): Response
    {
        $eventos = $repository->findEventosAlfabeticamente();

        return $this->render('evento/evento/eventos.html.twig', [
            'eventos'=>$eventos
            ]);
    }

    #[Route('/eventos/{slug}', name: 'evento_detalle')]                     //falta esto
    public function evento(
        string $slug,
        EventoRepository $repository
    ): Response
    {
        $eventos = $repository->findEventosAlfabeticamente();

        return $this->render('evento/evento/eventos.html.twig', [
            'eventos'=>$eventos
            ]);
    }


}
