<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Evento;


class DefaultController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){}

    #[Route(
        '/sitio/{pagina}',
         name: 'app_estatica',
         defaults:['pagina'=>'patrocinadores'],
         requirements: [
            'pagina'=>'patrocinadoes|privacidad|condiciones|licencia'
         ]
    )]

    public function estatica(string $pagina): Response
    {
        return $this->render('estatica/'.$pagina.'.html.twig');
    }

    #[Route('/', name: 'portada')]
    public function portada(): Response
    {
        $em = $this->entityManager;

        $eventos = $em->getRepository(Evento::class)->findAll();

        shuffle($eventos);

        $eventos = array_slice($eventos, 0, 8);

        return $this->render('default/portada.html.twig', [
            'eventosCol1' => array_slice($eventos, 0, 4),
            'eventosCol2' => array_slice($eventos, 4, 4),
        ]);
    }
}