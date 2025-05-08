<?php

require_once '../config/Database.php';

class PacienteController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function salvarConsulta() {
        //IMPLEMENTAR LÓGICA AQUI
    }
}
