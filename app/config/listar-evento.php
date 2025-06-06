<?php

include 'conexao.php';

$conexao = new Conexao;
$conn = $conexao->conectar();

$query_events = "SELECT id, title, color, start, end FROM events";

$result_events = $conn->prepare($query_events);

$result_events->execute();

$eventos = [];

while($row_events = $result_events->fetch(PDO::FETCH_ASSOC)){
    
    
    extract($row_events);

    $eventos[] = [
        'id' => $id,
        'title' => $title,
        'color' => $color,
        'start' => $start,
        'end' => $end
    ];

}

echo json_encode($eventos);
