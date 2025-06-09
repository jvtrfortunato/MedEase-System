<?php

//Conectar com o banco de dados
include 'Database.php';
$conexao = new Database;
$conn = $conexao->conectar();

//QUERY para recuperar os médicos
$query_medicos = "SELECT m.id_medico AS id_medico, u.nome AS nome FROM medicos m INNER JOIN usuarios u ON m.id_usuario = u.id_usuario ORDER BY u.nome ASC";

//$query_medicos = "SELECT m.id_medico AS id_medico u.nome AS nome FROM medicos m INNER JOIN usuarios u ON m.id_usuario = u.id_usuario WHERE m.id_medico = 100 ORDER BY u.nome ASC";

// Prepara a QUERY
$result_medicos = $conn->prepare($query_medicos);

//Executar a QUERY
$result_medicos->execute();

//Acessar o IF quando encontrar médico no banco de dados
if(($result_medicos) and ($result_medicos->rowCount() != 0)){

    //Ler os registros recuperados do banco de dados
    $dadosMedicos = $result_medicos->fetchAll(PDO::FETCH_ASSOC);

    //Criar o array com o status e os dados
    $retornaMedicos = ['status' => true,
                'dadosMedicos' => $dadosMedicos
    ];

}else{

    //Criar o array com o status e os dados
    $retornaMedicos = ['status' => false,
                'msg' => "Nenhum médico encontrado"
    ];
}

//QUERY para recuperar os pacientes
$query_pacientes = "SELECT id_paciente, nome FROM pacientes ORDER BY nome ASC";
//$query_pacientes = "SELECT id_paciente, nome FROM pacientes WHERE id_paciente = 100 ORDER BY nome ASC";

// Prepara a QUERY
$result_pacientes = $conn->prepare($query_pacientes);

//Executar a QUERY
$result_pacientes->execute();

//Acessar o IF quando encontrar médico no banco de dados
if(($result_pacientes) and ($result_pacientes->rowCount() != 0)){

    //Ler os registros recuperados do banco de dados
    $dadosPacientes = $result_pacientes->fetchAll(PDO::FETCH_ASSOC);

    //Criar o array com o status e os dados
    $retornaPacientes = ['status' => true,
                'dadosPacientes' => $dadosPacientes
    ];

}else{

    //Criar o array com o status e os dados
    $retornaPacientes = ['status' => false,
                'msg' => "Nenhum paciente encontrado"
    ];
}

$retorno = [
    'medicos' => $retornaMedicos,
    'pacientes' => $retornaPacientes
];

// Converter o array em objeto e retornar para o Javascript
echo json_encode($retorno);
