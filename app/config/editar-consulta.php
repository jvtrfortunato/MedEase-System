<?php

//Conectar com o banco de dados
include 'Database.php';
$conexao = new Database;
$conn = $conexao->conectar();

//Receber dados enviados pelo JavaScript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Criar a QUERY editar consulta no banco de dados
$query_edit_consulta = "UPDATE consultas SET title=:title, start=:start, end=:end, id_medico=:id_medico, id_paciente=:id_paciente, status=:status WHERE id=:id";

//Prepara a QUERY
$edit_consulta = $conn->prepare($query_edit_consulta);

//Substituir o link pelo valor
$edit_consulta->bindParam(':title', $dados['edit_title']);
$edit_consulta->bindParam(':start', $dados['edit_start']);
$edit_consulta->bindParam(':end', $dados['edit_end']);
//$edit_consulta->bindParam(':id_administrador', $dados['id_administrador']);
//$edit_consulta->bindParam(':id_secretario', $dados['id_secretario']);
$edit_consulta->bindParam(':id_medico', $dados['edit_nome_medico'], PDO::PARAM_INT);
$edit_consulta->bindParam(':id_paciente', $dados['edit_nome_paciente'], PDO::PARAM_INT);
$edit_consulta->bindParam(':status', $dados['edit_status']);
$edit_consulta->bindParam(':id', $dados['edit_id']);

if($edit_consulta->execute()) {
    
    // Buscar nome do paciente
    $query_paciente = "SELECT nome FROM pacientes WHERE id_paciente = :id_paciente";
    $stmt_paciente = $conn->prepare($query_paciente);
    $stmt_paciente->bindParam(':id_paciente', $dados['edit_nome_paciente']);
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
    $stmt_medico->bindParam(':id_medico', $dados['edit_nome_medico']);
    $stmt_medico->execute();
    $medico = $stmt_medico->fetch(PDO::FETCH_ASSOC);

    
    $retorna = ['status' => true, 
                'msg' => 'Consulta editada com sucesso!', 
                'id' => $dados['edit_id'],
                'title' => $dados['edit_title'],
                'nome_paciente' => $paciente['nome'] ?? 'Paciente não encontrado',
                'nome_medico' => $medico['nome'] ?? 'Médico não encontrado',
                'start' => $dados['edit_start'],
                'end' => $dados['edit_end'],
                'status_consulta' => $dados['edit_status']
            ];
} else {
    $retorna = ['status' => false, 'msg' => 'Erro: Consulta não editada!'];
}

echo json_encode($retorna);
