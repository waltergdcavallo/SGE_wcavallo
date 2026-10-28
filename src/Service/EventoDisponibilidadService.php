<?php

namespace App\Service;

use App\Entity\Evento;

class EventoDisponibilidadService
{
    public function tieneCupos(Evento $evento): bool
    {
        return $evento->getCapacidad() > 0;
    }

    public function obtenerMensaje(Evento $evento): string
    {
        if ($this->tieneCupos($evento)) {
            return 'Cupos disponibles';
        }

        return 'Sin cupos';
    }
}