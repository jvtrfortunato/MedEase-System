<?php

//Conectar com o banco de dados
include 'Database.php';
$conexao = new Database;
$conn = $conexao->conectar();

//Receber dados enviados pelo JavaScript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Criar a QUERY cadastrar consulta no banco de dados
$query_cad_consulta = "INSERT INTO consultas (title, start, end, id_medico, id_paciente) 
                       VALUES (:title, :start, :end, :id_medico, :id_paciente)";

//Prepara a QUERY
$cad_consulta = $conn->prepare($query_cad_consulta);

//Substituir o link pelo valor
$cad_consulta->bindParam(':title', $dados['cad_title']);
$cad_consulta->bindParam(':start', $dados['cad_start']);
$cad_consulta->bindParam(':end', $dados['cad_end']);
//$cad_consulta->bindParam(':id_administrador', $dados['id_administrador']);
//$cad_consulta->bindParam(':id_secretario', $dados['id_secretario']);
$cad_consulta->bindParam(':id_medico', $dados['cad_nome_medico']);
$cad_consulta->bindParam(':id_paciente', $dados['cad_nome_paciente']);

if($cad_consulta->execute()) {
    $retorna = ['status' => true, 
                'msg' => 'Consulta cadastrada com sucesso!', 
                'id' => $conn->lastInsertId(),
                'title' => $dados['cad_title'],
                'id_paciente' => $dados['cad_nome_paciente'],
                'id_medico' => $dados['cad_nome_medico'],
                'start' => $dados['cad_start'],
                'end' => $dados['cad_end']
            ];
} else {
    $retorna = ['status' => false, 'msg' => 'Erro: Consulta não cadastrada!'];
}

echo json_encode($retorna);
