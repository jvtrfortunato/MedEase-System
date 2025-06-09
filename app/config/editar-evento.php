<?php

//Conectar com o banco de dados
include 'conexao.php';
$conexao = new Conexao;
$conn = $conexao->conectar();

//Receber dados enviados pelo JavaScript
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Recuperar os dados do usuário no banco de dados
$query_user = "SELECT id, name, email FROM users WHERE id = :id LIMIT 1";

// Prepara a QUERY
$result_user = $conn->prepare($query_user);

//Substituir o link pelo valor
$result_user->bindParam(':id', $dados['edit_user_id']);

//Executar a QUERY
$result_user->execute();

//Ler os dados do usuário
$row_user = $result_user->fetch(PDO::FETCH_ASSOC);

//Criar a QUERY editar evento no banco de dados
$query_edit_event = "UPDATE events SET title=:title, color=:color, start=:start, end=:end, obs=:obs, user_id=:user_id WHERE id=:id";

//Prepara a QUERY
$edit_event = $conn->prepare($query_edit_event);

//Substituir o link pelo valor
$edit_event->bindParam(':title', $dados['edit_title']);
$edit_event->bindParam(':color', $dados['edit_color']);
$edit_event->bindParam(':start', $dados['edit_start']);
$edit_event->bindParam(':end', $dados['edit_end']);
$edit_event->bindParam(':obs', $dados['edit_obs']);
$edit_event->bindParam(':user_id', $dados['edit_user_id']);
$edit_event->bindParam(':id', $dados['edit_id']);


//Verificar se conseguiu editar corretamente
if($edit_event->execute()) {
    $retorna = ['status' => true, 
                'msg' => 'Evento editado com sucesso!', 
                'id' => $dados['edit_id'],
                'title' => $dados['edit_title'], 
                'color' => $dados['edit_color'],
                'start' => $dados['edit_start'],
                'end' => $dados['edit_end'],
                'obs' => $dados['edit_obs'],
                'user_id' => $row_user['id'],
                'name' => $row_user['name'],
                'email' => $row_user['email']
            ];
} else {
    $retorna = ['status' => false, 'msg' => 'Erro: Evento não editado!'];
}

//Converter o array e retornar um objeto
echo json_encode($retorna); 