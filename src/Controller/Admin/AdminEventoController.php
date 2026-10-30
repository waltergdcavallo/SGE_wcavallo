<?php

namespace App\Controller\Admin;

use App\Entity\Evento;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/eventos')]
class AdminEventoController extends AbstractAdminBaseController
{
    #[Route(
        '/listar',
        name: 'admin_evento_listar'
    )]
    public function listar(
        EventoRepository $eventoRepository
    ): Response
    {

        return $this->render(
            'admin/evento/listar.html.twig',
            [
                'eventos' => $eventoRepository->findEventosAlfabeticamente(),
            ]
        );
    }

    #[Route(
        '/nuevo',
        name: 'admin_evento_nuevo',
        methods: ['GET', 'POST']
    )]
    public function nuevo(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response{
        $evento = new Evento();

        $form = $this->createForm(
            EventoType::class,
            $evento
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($evento);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Evento creado correctamente.'
            );
            

            return $this->redirectToRoute(
                'admin_evento_listar'
            );
        }

        return $this->render(
            'admin/evento/nuevo.html.twig',
            [
                'form' => $form,
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

    #[Route('admin/evento/{id}', name: 'admin_evento_ver')]
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

        return $this->render('admin/evento/evento.html.twig', [
            'evento'=>$evento
       ]);
    }

    #[Route(
        '/{id}/edit', 
        name: 'admin_evento_editar', 
        methods: ['GET', 'POST'])]
    public function editar(
        Request $request, 
        Evento $evento, 
        EntityManagerInterface $entityManager
    ): Response
    {
        $form = $this->createForm(
            EventoType::class, 
            $evento
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Evento editado correctamente.'
            );

            return $this->redirectToRoute('admin_evento_listar');
        }

        return $this->render('admin/evento/editar.html.twig', [
            'evento' => $evento,
            'form' => $form,
        ]);
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

        $this->addSuccessMessage(
            sprintf(
                "El evento '%s' se ha borrado correctamente.",
                $evento->getTitulo()
            )
        );

        return $this->redirectToRoute(
            'admin_evento_listar'
        );
    }
}
