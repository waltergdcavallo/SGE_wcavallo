<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;

#[Route('/usuario')]
#[IsGranted('ROLE_USER')]
class UsuarioController extends AbstractController
{
    #[Route('', name: 'usuario_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('usuario/dashboard.html.twig');
    }

    #[Route(
        '/listar',
        name: 'usuario_evento_listar'
    )]
    public function listar(
        EventoRepository $eventoRepository
    ): Response
    {

        return $this->render(
            'usuario/evento/listar.html.twig',
            [
                'eventos' => $eventoRepository->findEventosAlfabeticamente(),
            ]
        );
    }

    #[Route('usuario/evento/{id}', name: 'usuario_evento_ver')]
    public function ver(
        Request $request,
        EventoRepository $repository
    ): Response
    {
        $id = $request->attributes->get('id');

        $evento = $repository->findOneBy([
            'id'=>$id
        ]);

        if (!$evento) {
            throw $this->createNotFoundException(
                'No existe el evento solicitado'
            );
        }

        return $this->render('usuario/evento/evento.html.twig', [
            'evento'=>$evento
       ]);
    }
}