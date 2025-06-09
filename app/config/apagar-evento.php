<?php

//Conectar com o banco de dados
include 'conexao.php';
$conexao = new Conexao;
$conn = $conexao->conectar();

//Receber o id enviado pelo JavaScript
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

//Acessa o if quando existe o id do evento
if(!empty($id)){

    //Criar a QUERY apagar evento no banco de dados
    $query_apagar_event = "DELETE FROM events WHERE id=:id";

    //Prepara a QUERY
    $apagar_event = $conn->prepare($query_apagar_event);

    // Substituir o link pelo valor
    $apagar_event->bindParam(':id', $id);

    // Verificar se consegui apagar corretamente
    if($apagar_event->execute()){
        $retorna = ['status' => true, 'msg' => 'Evento apagado com sucesso!'];
    }else{
        $retorna = ['status' => false, 'msg' => 'Erro: Evento não apagado!'];
    }
    
}else{ //Acessa o ELSE quando o id está vazio
    $retorna = ['status' => false, 'msg' => 'Erro: Necessário enviar o ID do evento!'];
}

//Converte o array em objeto e retornar para o Javascript
echo json_encode($retorna);
