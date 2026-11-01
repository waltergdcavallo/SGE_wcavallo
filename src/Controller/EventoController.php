<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\EventoDisponibilidadService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventoRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

final class EventoController extends AbstractBaseController
{
    #[Route('/eventos', name: 'app_eventos')]
    public function eventos(
        EventoRepository $eventoRepository, 
        EventoDisponibilidadService $disponibilidadService,
        PaginatorInterface $paginator,
        Request $request
        ): Response
    {
        $query = $eventoRepository->findEventosAlfabeticamente();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('evento/eventos.html.twig', [
            'pagination' => $pagination,
            'disponibilidadService'=>$disponibilidadService
        ]);
    }


    #[Route('/evento/{slug}', name: 'evento_detalle')]
    public function evento(
        Request $request,
        EventoRepository $eventoRepository
    ): Response
    {
        $slug = $request->attributes->get('slug');

        $evento = $eventoRepository->findOneBy([
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
