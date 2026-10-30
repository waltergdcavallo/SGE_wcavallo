<?php

namespace App\DataFixtures;

use App\Common\Util;
use App\Entity\Disertante;
use App\Entity\Evento;
use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $nombres = [
            'Martina', 'Adolfo', 'Agustin', 'Felipe', 'Alberto',
            'Andrés', 'Ariel', 'Benjamin', 'Matias', 'Diego',
            'Carlos', 'Pablo', 'Cristian', 'Luis', 'David',
            'Belén', 'Eduardo', 'Antonela', 'Fernando',
            'Francisco', 'Gonzalo', 'Constanza', 'Guillermo',
            'Sofia', 'Pia', 'Ignacio', 'Evangelina', 'Julieta',
            'Laura', 'Iván', 'Julian', 'Emilia', 'Jorge',
            'Jose', 'Juan', 'Gaspar', 'Marta', 'Miguel',
            'Rodrigo', 'Mateo', 'Oscar', 'Pedro', 'Josefina',
            'Rafael', 'Renata', 'Rubén', 'Salvador',
            'Santiago', 'Sergio', 'Susana', 'Verónica',
            'Vicente', 'Víctor', 'Victoria', 'Paula',
            'Alejandro', 'Javier', 'Tomás', 'Romina',
            'Lorena', 'Gabriel', 'Juan Pablo', 'Omar', 'Julia'
        ];

        $apellidos = [
            'González', 'Rodríguez', 'Gómez', 'Fernández',
            'Martínez', 'Pérez', 'García', 'Sánchez',
            'Romero', 'Sosa', 'Álvarez', 'Torres',
            'Ruiz', 'Ramírez', 'Flores', 'Acosta',
            'Benítez', 'Medina', 'Suárez', 'Herrera',
            'Aguirre', 'Gutiérrez', 'Giménez', 'Molina',
            'Silva', 'Castro', 'Rojas', 'Ortíz',
            'Núñez', 'Luna', 'Juárez', 'Cabrera',
            'Ríos', 'Ferreyra', 'Godoy', 'Morales',
            'Domínguez', 'Moreno', 'Peralta', 'Vega',
            'Carrizo', 'Quiroga', 'Castillo', 'Ledesma',
            'Muñoz', 'Ojeda', 'Ponce', 'Vera',
            'Vázquez', 'Villalba', 'Cardozo', 'Navarro',
            'Ramos', 'Arias', 'Coronel', 'Córdoba',
            'Figueroa', 'Correa', 'Cáceres', 'Vargas',
            'Maldonado', 'Mansilla', 'Farías', 'Rivero',
            'Paz', 'Miranda', 'Roldán', 'Méndez',
            'Lucero', 'Cruz', 'Hernández', 'Agüero',
            'Páez', 'Blanco', 'Mendoza', 'Barrios',
            'Escobar', 'Ávila', 'Soria', 'Leiva',
            'Acuña', 'Martin', 'Maidana', 'Moyano',
            'Campos', 'Olivera', 'Duarte', 'Soto',
            'Franco', 'Bravo', 'Valdéz', 'Toledo',
            'Montenegro', 'Leguizamón', 'Chávez',
            'Arce', 'López', 'Díaz'
        ];

        $calles = [
            '9 de Julio', '4 de Enero', 'San Jerónimo',
            '1 de Mayo', 'Córdoba', 'Corrientes',
            'Moreno', 'San Martin', 'Entre Rios',
            'San Lorenzo', 'Urquiza', 'La Rioja',
            'Salta', 'Mendoza', 'Cruz Roja',
            'Suipacha', 'Mariano Comas', 'Iturraspe',
            'Maipú', 'Zenteno', 'Junin',
            'Santiago del Estero', 'Rivadavia',
            'Las Heras', 'Francia', 'Alvear',
            'Mitre', 'Lavalle', 'Primera Junta',
            'Juan de Garay', 'Candioti', 'Necochea',
            'Gral. Paz', 'Pedro Ferre',
            'Saavedra', 'Catamarca', 'Tucumán'
        ];

        $emails = [
            'gmail.com',
            'hotmail.com',
            'yahoo.com',
            'outlook.com'
        ];

        /*
         * ============================================================
         * DISERTANTES
         * ============================================================
         */

        $disertantes = [
            [
                'ref' => 'javierLopez',
                'nombre' => 'Javier',
                'apellidos' => 'López',
                'email' => 'javier.lopez@gmail.com'
            ],
            [
                'ref' => 'ignacioBlanco',
                'nombre' => 'Ignacio',
                'apellidos' => 'Blanco',
                'email' => 'ignacio.blanco@gmail.com'
            ],
            [
                'ref' => 'marcosRojas',
                'nombre' => 'Marcos',
                'apellidos' => 'Rojas',
                'email' => 'marcos.rojas@gmail.com'
            ],
            [
                'ref' => 'antonelaToledo',
                'nombre' => 'Antonela',
                'apellidos' => 'Toledo',
                'email' => 'antonela.toledo@gmail.com'
            ],
        ];

        foreach ($disertantes as $datos) {

            $disertante = new Disertante();

            $disertante->setNombre($datos['nombre']);
            $disertante->setApellido($datos['apellidos']);
            $disertante->setEmail($datos['email']);

            $disertante->setBiografia(
                'Especialista en desarrollo de aplicaciones web con Symfony 7.4.'
            );

            $disertante->setTelefono(
                '0342-' . rand(4000000, 4999999)
            );

            $disertante->setDireccion(
                $calles[array_rand($calles)] . ' ' . rand(100, 4000)
            );

            $disertante->setUrl('https://www.symfony.com');

            $disertante->setLinkedin('https://linkedin.com');

            $disertante->setTwitter('https://x.com');

            $manager->persist($disertante);

            $this->addReference(
                $datos['ref'],
                $disertante
            );
        }

        $manager->flush();

        /*
         * ============================================================
         * USUARIOS
         * ============================================================
         */

        foreach (range(1, 200) as $i) {

            $usuario = new Usuario();

            $usuario->setNombre(
                $nombres[array_rand($nombres)]
            );

            $usuario->setApellido(
                $apellidos[array_rand($apellidos)]
            );

            $usuario->setDni(
                (string) rand(20000000, 45000000)
            );

            $usuario->setDireccion(
                $calles[array_rand($calles)] . ' ' . rand(100, 4000)
            );

            $usuario->setTelefono(
                '0342-' . rand(4000000, 4999999)
            );

            $usuario->setEmail(
                'usuario' . $i . '@' . $emails[array_rand($emails)]
            );

            $usuario->setRoles(
                ['ROLE_USER']
            );

            $passwordPlano= 'usuario' . $i;

            $passwordHash = $this->passwordHasher->hashPassword(
                $usuario,
                $passwordPlano
            );

            $usuario->setPassword($passwordHash);

            $manager->persist($usuario);

        }

        $admin = new Usuario();

            $admin->setNombre(
                'Walter'
            );

            $admin->setApellido(
                'Cavallo'
            );

            $admin->setDni(
                (string) rand(20000000, 45000000)
            );

            $admin->setDireccion(
                $calles[array_rand($calles)] . ' ' . rand(100, 4000)
            );

            $admin->setTelefono(
                '0342-' . rand(4000000, 4999999)
            );

            $admin->setEmail(
                'admin@gmail.com'
            );

            $admin->setRoles(
                ['ROLE_ADMIN']
            );

            $passwordPlano= 'password';

            $passwordHash = $this->passwordHasher->hashPassword(
                $admin,
                $passwordPlano
            );

            $admin->setPassword($passwordHash);

            $manager->persist($admin);



            $user = new Usuario();

            $user->setNombre(
                'Walter'
            );

            $user->setApellido(
                'Cavallo'
            );

            $user->setDni(
                (string) rand(20000000, 45000000)
            );

            $user->setDireccion(
                $calles[array_rand($calles)] . ' ' . rand(100, 4000)
            );

            $user->setTelefono(
                '0342-' . rand(4000000, 4999999)
            );

            $user->setEmail(
                'user@gmail.com'
            );

            $user->setRoles(
                ['ROLE_USER']
            );

            $passwordPlano= 'password';

            $passwordHash = $this->passwordHasher->hashPassword(
                $user,
                $passwordPlano
            );

            $user->setPassword($passwordHash);

            $manager->persist($user);

        $manager->flush();

        /*
         * ============================================================
         * EVENTOS
         * ============================================================
         */

        $eventos = [
            [
                'titulo' => 'Introducción a Symfony 7.4',
                'hora' => '09:00:00',
                'disertante' => 'javierLopez',
                'capacidad' => '0'
            ],
            [
                'titulo' => 'Ruteo y Controladores',
                'hora' => '10:30:00',
                'disertante' => 'ignacioBlanco',
                'capacidad' => '5'
            ],
            [
                'titulo' => 'Doctrine ORM y Base de Datos',
                'hora' => '12:00:00',
                'disertante' => 'marcosRojas',
                'capacidad' => '100'
            ],
            [
                'titulo' => 'Twig y Formularios',
                'hora' => '15:00:00',
                'disertante' => 'antonelaToledo',
                'capacidad' => '10'
            ],
            [
                'titulo' => 'Seguridad en Symfony 7.4',
                'hora' => '16:30:00',
                'disertante' => 'javierLopez',
                'capacidad' => '20'
            ],
        ];

        foreach ($eventos as $datosEvento) {

            $evento = new Evento();

            $evento->setTitulo(
                $datosEvento['titulo']
            );

            $evento->setDescripcion(
                'Evento académico orientado al desarrollo de aplicaciones web modernas utilizando Symfony 7.4.'
            );

            $evento->setFecha(
                new \DateTime('2026-06-10')
            );

            $evento->setHora(
                new \DateTime($datosEvento['hora'])
            );

            $evento->setDuracion(60);

            $evento->setIdioma('es');

            $estado=["Activo","Cancelado","Finalizado"];
            $evento->setEstado($estado[array_rand($estado)]);

            $evento->setDisertante(
                $this->getReference(
                    $datosEvento['disertante'],
                    Disertante::class
                )
            );
            $capacidad=$datosEvento['capacidad'];
            $evento->setCapacidad($capacidad);

            $this->addUsuarios(
                $manager,
                $evento
            );

            $manager->persist($evento);
        }

        $manager->flush();
    }

    /**
     * Agrega asistentes aleatorios al evento.
     */
    private function addUsuarios(
        ObjectManager $manager,
        Evento $evento,
        ?int $cantidad = null
    ): void {

        $usuarios = $manager
            ->getRepository(Usuario::class)
            ->findAll();

        $cantidad ??= rand(20, 50);

        $ids = [];

        for ($i = 0; $i < $cantidad; $i++) {

            $usuario = $usuarios[array_rand($usuarios)];

            while (in_array($usuario->getId(), $ids)) {
                $usuario = $usuarios[array_rand($usuarios)];
            }

            $ids[] = $usuario->getId();

            $evento->addUsuario($usuario);
        }
    }
}
