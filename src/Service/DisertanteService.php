<?php

namespace App\Service;

use App\Entity\Disertante;

class DisertanteNombreCompletoService
{
    public function obtenerNombreCompleto(Disertante $disertante): string
    {
        return $disertante->getNombreCompleto();
    }
}