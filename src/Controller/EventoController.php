<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventoRepository;
use Symfony\Component\HttpFoundation\Request;

final class EventoController extends AbstractBaseController
{
    #[Route('/eventos', name: 'app_eventos')]
    public function eventos(EventoRepository $repository): Response
    {
        $eventos = $repository->findEventosAlfabeticamente();

        return $this->render('evento/eventos.html.twig', [
            'eventos'=>$eventos
        ]);
    }


    #[Route('/evento/{slug}', name: 'evento_detalle')]
    public function evento(
        Request $request,
        EventoRepository $repository
    ): Response
    {
        $slug = $request->attributes->get('slug');

        $evento = $repository->findOneBy([
            'slug'=>$slug
        ]);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado'
            );
        }

        $this->addInfoMessage(
            sprintf(
                "Has leído sobre el evento '%s' a las %s.",
                $evento->getTitulo(),
                date('H:i:s')
            )
        );

        return $this->render('evento/evento.html.twig', [
            'evento'=>$evento
       ]);
    }
}
