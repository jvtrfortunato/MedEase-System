<?php

require_once '../model/Usuario.php';

class LoginController
{
    public function login()
    {
        // Inicia a sessão logo no início
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitização dos dados recebidos
            $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

            $usuario = new Usuario();

            // Tenta autenticar o usuário
            if ($usuario->autenticar($cpf, $senha)) {
                // Se a autenticação for bem-sucedida, armazena o CPF na sessão
                $_SESSION['usuario'] = $cpf;
                $_SESSION['nome'] = $usuario->getNome();

                // Redireciona para a página do administrador
                header('Location: http://localhost/MedEase-System/app/views/home-administrador.php');
                exit;
            } else {
                // Se falhar, redireciona de volta para o login com erro
                header('Location: http://localhost/MedEase-System/app/views/login.php?erro=1');
                exit;
            }
        } else {
            // Se não for um POST, redireciona para a página de login
            header('Location: /app/views/login.php');
            exit;
        }
    }
}

$controller = new LoginController();
$controller->login();

?>
