<?php
session_start();
$tipoUsuario = $_SESSION['usuario_tipo'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Paciente</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/cadastrar-paciente.css">
    <script src="../../assets/script/mascaraCPF.js"></script>
    <script src="../../assets/script/mascaraRG.js"></script>
    <script src="../../assets/script/mascaraTelefone.js"></script>
    <script src="../../assets/script/mascaraCNS.js"></script>
</head>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">
            <form action="../routers/roteadorPaciente.php" method="post">
                <input type="hidden" name="acao" value="salvarPaciente">
                <h1>Dados Gerais</h1>
                <section class="dados-gerais-endereco">
                    
                    <div class="linha">         
                        <div class="label-input">
                            <label for="nome">Nome completo<span>*</span></label></label>
                            <input type="text" name="nome" id="" require>
                        </div>          
                        <div class="linha-pequenos">           
                            <div class="label-input">
                                <label for="dataNascimento">Data de nascimento</label>
                                <input type="date" name="dataNascimento" id="" required>
                            </div>                        
                            <div class="label-input">
                                <label for="sexo">Sexo</label>
                                <select name="sexo" id="" required>
                                    <option value="">Selecione</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="feminino">Feminino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="linha">
                        <div class="label-input">
                            <label for="estadoCivil">Estado civil</label>
                            <select name="estadoCivil" id="" required>
                                <option value="">Selecione</option>
                                <option value="solteiro">Solteiro(a)</option>
                                <option value="casado">Casado(a)</option>
                                <option value="separado">Separado(a) judicialmente</option>
                                <option value="divorciado">Divorciado(a)</option>
                                <option value="viuvo">Viúvo(a)</option>
                            </select>
                        </div>
                        <div class="linha-pequenos">
                            <div class="label-input">
                                <label for="cpf">CPF<span>*</span></label></label>
                                <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" required>
                            </div>
                            <div class="label-input">
                                <label for="rg">RG</label>
                                <input type="text" name="rg" id="rg" required>
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
                            <label for="nomeResponsavel">Nome do responsável</label>
                            <input type="text" name="nomeResponsavel" id="">
                        </div>

                        <div class="label-input">
                            <label for="cns">Cartão Nacional de Saúde (CNS)</label>
                            <input type="text" name="cns" id="cns" placeholder="000.000.000.000" required>
                        </div>
                    </div>

                    <div class="linha">
                        <div class="label-input">
                            <label for="convenio">Convênio</label>
                            <input type="text" name="convenio" id="" required>
                        </div>

                        <div class="label-input">
                            <label for="planoSaude">Número do Plano de Saúde</label>
                            <input type="text" name="planoSaude" id="" required>
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
                                <input type="text" id="cep" name="cep" placeholder="00000-000">
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
    
    <footer></footer>
    
    <script>
        // Evento para o botão "Voltar" (se existir)
        if (voltarPagina) {
            voltarPagina.addEventListener("click", () => {
                if (window.history.length > 1) {
                    window.history.back(); // volta à página anterior no histórico
                } else {
                    // Fallback: redireciona manualmente caso não haja histórico
                    if ($tipoUsuario === 'administrador') {
                        window.location.href = "home-administrador.php";
                    }
                    else {
                        window.location.href = "home-secretario.php";
                    }
                }
            });
        }
    </script>
</body>
</html>