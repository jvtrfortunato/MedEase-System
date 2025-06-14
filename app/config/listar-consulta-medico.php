<?php

//Conectar com o banco de dados
include 'Database.php';
$conexao = new Database;
$conn = $conexao->conectar();

session_start();
$id_medico_logado = $_SESSION['medico_id'];

// Verifica se o ID foi informado
if (!$id_medico_logado) {
    echo json_encode(["erro" => "ID do médico não informado."]);
    exit;
}

//QUERY para recuperar as consultas
$query_consultas = "SELECT 
                        c.id,
                        c.title,
                        c.color,
                        p.nome AS nome_paciente,
                        u.nome AS nome_medico,
                        c.start,
                        c.end,
                        c.status
                    FROM 
                        consultas c
                    INNER JOIN 
                        medicos m ON c.id_medico = m.id_medico
                    INNER JOIN 
                        usuarios u ON m.id_usuario = u.id_usuario
                    INNER JOIN 
                        pacientes p ON c.id_paciente = p.id_paciente
                    WHERE
                        c.id_medico = :id_medico_logado";

// Prepara a QUERY
$resultado_consultas = $conn->prepare($query_consultas);

$resultado_consultas->bindParam(':id_medico_logado', $id_medico_logado, PDO::PARAM_INT);

// Executa a QUERY
$resultado_consultas->execute();

// Criar o array que recebe os eventos
$consultas = [];

// Percorrer a lista de registros retornado do banco de dados
while($row_consultas = $resultado_consultas->fetch(PDO::FETCH_ASSOC)){

    //Extrair o array
    extract($row_consultas);

    $consultas[] = [
        'id' => $id,
        'title' => $title,
        'color' => $color,
        'nome_paciente' => $nome_paciente,
        'nome_medico' => $nome_medico,
        'start' => $start,
        'end' => $end,
        'status' => $status
    ];
}

echo json_encode($consultas);
