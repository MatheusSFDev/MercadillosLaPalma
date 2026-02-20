<?php

namespace App\Enums;

enum Status: string
{
    case Pendiente = 'Pendiente';
    case Aceptado = 'Aceptado';
    case Rechazado = 'Rechazado';
    case Compleado = 'Compleado';
}
