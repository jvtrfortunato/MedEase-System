<?php

//Conectar com o banco de dados
include 'Database.php';
$conexao = new Database;
$conn = $conexao->conectar();

//Receber o id enviado pelo JavaScript
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

//Acessa o IF quando existe o id do evento
if(!empty($id)) {

    // Criar a QUERY apagar evento no banco de dados
    $query_apagar_consulta = "DELETE FROM consultas WHERE id=:id";

    // Prepara a QUERY
    $apagar_consulta = $conn->prepare($query_apagar_consulta);

    // Substituir o link pelo valor
    $apagar_consulta->bindParam(':id', $id);

    // Verificar se conseguiu apagar corretamente
    if($apagar_consulta->execute()) {
        $retorna = ['status' => true, 'msg' => 'Consulta apagada com sucesso!'];
    } else {
        $retorna = ['status' => false, 'msg' => 'Erro: Evento não apagado!'];
    }

} else { // Acessa o else quando o id está vazio
    $retorna = ['status' => false, 'msg' => 'Erro: Necessário enviar o ID da consulta!'];
}

// Converter o array em objeto e retornar para o JavaScript
echo json_encode($retorna);
