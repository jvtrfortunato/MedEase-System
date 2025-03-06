<?php

namespace App\Models;

enum StatusConsulta {
    case Pendente;
    case PacienteAguardando;
    case EmAndamento;
    case Concluida;
    case Cancelada;
}