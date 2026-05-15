<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        
        $evento=new Evento();

        $evento->setTitulo('Symfony Conf');

        $manager->persist($evento);

        $manager->flush();
    }
}
