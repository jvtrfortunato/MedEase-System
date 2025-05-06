<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedEase Login</title>
    <link rel="stylesheet" href="../../assets/css/login.css">
    <script src="../../assets/script/login.js"></script>
</head>
<body>
    <header></header>
    <main>
        <section class="div_pai">
            <section class="conteudo_geral">
                <section class="geral_esquerda">
                    <section class="logo">
                        <h1>MedEase</h1>
                        <p>Você pode fazer login para acessar sua conta existente.</p>
                    </section>
                </section>
                <section class="geral_direita">
                    <section class="formulario">
                        <h1>Entrar</h1>

                        <!-- Verificação de erro na autenticação -->
                        <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
                            <div class="erro_login">
                                <p>Usuário ou senha inválidos. Tente novamente.</p>
                            </div>
                        <?php endif; ?>

                        <form action="../controller/loginController.php" method="POST">
                             <div class="login_ate_esqueciSenha">
                                <div class="input">
                                    <img class="icone_input" src="../../assets/img/perfil.png" alt="Ícone de perfil">
                                    <label for="cpf"></label>
                                    <input type="text" id="cpf" name="cpf" placeholder="CPF" autocomplete="off" required><br><br>
                                </div>
                                 <div class="input">   
                                    <img class="icone_input" src="../../assets/img/cadeado.png" alt="Ícone de cadeado">
                                    <label for="senha"></label>
                                    <input type="password" id="senha" name="senha" placeholder="Senha" autocomplete="current-password" required><br><br>
                                </div> 
                                <div class="checkbox_ate_esqueciSenha">
                                    <div class="checkbox_ate_lembreDeMim">
                                        <label for="lembrar">
                                            <input class="checkbox" type="checkbox" id="lembrar" name="lembrar">
                                        </label><br><br>
                                        <p>Lembre de mim</p>
                                    </div>
                                    <div class="esqueceu_senha">
                                        <a href="/esqueci-senha">Esqueceu sua senha?</a><br><br>
                                    </div>
                                </div>
                                <button class="botao_entrar" type="submit">Entrar</button>
                            </div>                
                        </form>
                    </section>
                </section>
            </section>
        </section>
    </main>
    <footer></footer>
</body>
</html>


