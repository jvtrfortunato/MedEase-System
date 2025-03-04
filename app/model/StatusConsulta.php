<?php

namespace App\Models;

enum StatusConsulta {
    case Pendente;
    case Aberta;
    case Concluida;
    case Cancelada;
}