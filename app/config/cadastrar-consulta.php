<?php

//Conectar com o banco de dados
include 'Database.php';
$conexao = new Database;
$conn = $conexao->conectar();

//Receber dados enviados pelo JavaScript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Criar a QUERY cadastrar consulta no banco de dados
$query_cad_consulta = "INSERT INTO consultas (title, start, end, id_medico, id_paciente, status) 
                       VALUES (:title, :start, :end, :id_medico, :id_paciente, :status)";

//Prepara a QUERY
$cad_consulta = $conn->prepare($query_cad_consulta);

//Substituir o link pelo valor
$cad_consulta->bindParam(':title', $dados['cad_title']);
$cad_consulta->bindParam(':start', $dados['cad_start']);
$cad_consulta->bindParam(':end', $dados['cad_end']);
//$cad_consulta->bindParam(':id_administrador', $dados['id_administrador']);
//$cad_consulta->bindParam(':id_secretario', $dados['id_secretario']);
$cad_consulta->bindParam(':id_medico', $dados['cad_nome_medico'], PDO::PARAM_INT);
$cad_consulta->bindParam(':id_paciente', $dados['cad_nome_paciente'], PDO::PARAM_INT);
$cad_consulta->bindParam(':status', $dados['cad_status']);


if($cad_consulta->execute()) {

    $id_consulta = $conn->lastInsertId();
    
    // Buscar nome do paciente
    $query_paciente = "SELECT nome FROM pacientes WHERE id_paciente = :id_paciente";
    $stmt_paciente = $conn->prepare($query_paciente);
    $stmt_paciente->bindParam(':id_paciente', $dados['cad_nome_paciente']);
    $stmt_paciente->execute();
    $paciente = $stmt_paciente->fetch(PDO::FETCH_ASSOC);
    
    // Buscar nome do médico
    $query_medico = "
        SELECT u.nome 
        FROM medicos m
        JOIN usuarios u ON u.id_usuario = m.id_usuario
        WHERE m.id_medico = :id_medico
    ";

    $stmt_medico = $conn->prepare($query_medico);
    $stmt_medico->bindParam(':id_medico', $dados['cad_nome_medico']);
    $stmt_medico->execute();
    $medico = $stmt_medico->fetch(PDO::FETCH_ASSOC);

    
    $retorna = ['status' => true, 
                'msg' => 'Consulta cadastrada com sucesso!',
                'id' => $id_consulta, 
                'title' => $dados['cad_title'],
                'nome_paciente' => $paciente['nome'] ?? 'Paciente não encontrado',
                'nome_medico' => $medico['nome'] ?? 'Médico não encontrado',
                'start' => $dados['cad_start'],
                'end' => $dados['cad_end'],
                'status_consulta' => $dados['cad_status']
            ];
    
} else {
    $retorna = ['status' => false, 'msg' => 'Erro: Consulta não cadastrada!'];
}

echo json_encode($retorna);
