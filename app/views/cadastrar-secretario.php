<?php
require_once '../controller/SecretarioController.php';
session_start();
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Secretário</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/cadastrar-secretario.css">
    <script src="../../assets/script/mascaraCPF.js"></script>
    <script src="../../assets/script/mascaraTelefone.js"></script>
    <script src="../../assets/script/mascaraCEP.js"></script>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>

     <?php if (!empty($mensagem)): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px; border-radius: 5px;">
        <?= htmlspecialchars($mensagem) ?>
    </div>
    <?php endif; ?>


    <main>
        <section class="conteudo-principal">
            <form action="../routers/roteadorSecretario.php" method="post">
                <input type="hidden" name="acao" value="salvarSecretario">
                <h1>Dados Gerais</h1>
                <section class="dados-gerais-endereco">
                    
                    <div class="linha">         
                        <div class="label-input">
                            <label for="nome">Nome completo<span>*</span></label></label>
                            <input type="text" name="nome" id="" required>
                        </div>          
                        <div class="linha-pequenos">           
                            <div class="label-input">
                                <label for="dataNascimento">Data de Nascimento</label>
                                <input type="date" name="dataNascimento" id="" required>
                            </div>                        
                            
                        </div>
                    </div>
                    
                    <div class="linha">
                        <div class="label-input">
                                <label for="sexo">Sexo</label>
                                <select name="sexo" id="" required>
                                    <option value="">Selecione</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                </select>
                            </div>
                        <div class="linha-pequenos">
                            <div class="label-input">
                                <label for="cpf">CPF<span>*</span></label></label>
                                <input type="text" name="cpf" id="cpf" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="000.000.000-00" required>
                            </div>
                        </div>
                    </div>

                    <div class="linha">
                        <div class="label-input">
                            <label for="telefone">Telefone</label>
                            <input type="tel" name="telefone" id="telefone" placeholder="(00)00000-0000" required>
                        </div>

                        <div class="label-input">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="" required>
                        </div>
                    </div>

                    <div class="linha">
                        <div class="label-input">
                            <label for="senha">Senha<span>*</span></label>
                            <input type="password" name="senha" id="" required>
                        </div>

                        <div class="label-input">
                            <label for="senha-repetir">Repita a senha<span>*</span></label>
                            <input type="password" name="senha-repetir" id="" required>
                        </div>
                    </div>

                </section>

                <h1 class="endereco">Endereço</h1>
                <section class="dados-gerais-endereco">

                    <div class="linha">
                        <div class="label-input">
                            <label for="rua">Rua</label>
                            <input type="text" id="" name="rua" required>
                        </div>
                        <div class="linha-pequenos">
                            <div class="label-input">
                                <label for="numero">Número</label>
                                <input type="number" id="" name="numero" required>
                            </div>
                            <div class="label-input">
                                <label for="bairro">Bairro</label>
                                <input type="text" id="" name="bairro" required>
                            </div>
                        </div>
                    </div>

                    <div class="linha">
                        <div class="label-input">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="" name="cidade" required>
                        </div>
                        <div class="linha-pequenos">
                            <div class="label-input">
                                <label for="estado">Estado (UF)</label>
                                <select id="" name="estado" required>
                                    <option value="">Selecione</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                            <div class="label-input">
                                <label for="cep">CEP</label>
                                <input type="text" id="cep" name="cep" placeholder="00000-000" required>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="botoes">
                    <button class="voltar" type="button" onclick="history.back()">Voltar</button>
                    <button class="salvar" type="submit">Salvar</button>
                </section>
            </form>
        </section>
    </main>
</body>
</html>