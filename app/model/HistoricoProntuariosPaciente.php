<?php

require_once 'Prontuario.php';
require_once 'Paciente.php';

class HistoricoProntuariosPaciente {
    public function __construct(
        private Paciente $paciente,
        private array $prontuarios = [] // array de objetos Prontuario
    ) {}

    public function getPaciente(): Paciente {
        return $this->paciente;
    }

    public function getProntuarios(): array {
        return $this->prontuarios;
    }

    public function addProntuario(Prontuario $prontuario): void {
        $this->prontuarios[] = $prontuario;
    }

    public function removeProntuario(int $idProntuario): void {
        $this->prontuarios = array_filter(
            $this->prontuarios,
            fn($p) => $p->getIdProntuario() !== $idProntuario
        );
    }

    public function getProntuarioById(int $idProntuario): ?Prontuario {
        foreach ($this->prontuarios as $prontuario) {
            if ($prontuario->getIdProntuario() === $idProntuario) {
                return $prontuario;
            }
        }
        return null;
    }
}
