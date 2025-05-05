<?php

namespace App\Models;

enum StatusConsulta {
    case Agendada;
    case Realizada;
    case Cancelada;
}