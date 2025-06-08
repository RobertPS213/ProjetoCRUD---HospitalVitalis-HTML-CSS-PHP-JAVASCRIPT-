<?php
    session_start();
    require_once '../Modelo/DAO/ClassUsuarioDAO.php';
    require_once '../Modelo/ClassPaciente.php';
    $usuarioDAO = new ClassUsuarioDAO();
    $mensagem = '';
    if (!isset($_SESSION['recepcionista'])) {
        header('Location: ../Login/RecepcionistaLogin.php');
        exit;
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: ../Login/RecepcionistaLogin.php');
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
        $paciente = new ClassPaciente();
        $paciente->setNome($_POST['nome']);
        $paciente->setEmail($_POST['email']);
        $paciente->setCpf($_POST['cpf']);
        $paciente->setTelefone($_POST['telefone']);
        $paciente->setDataDeNascimento($_POST['data_nascimento']);
        $paciente->setSexo($_POST['sexo']);
        $paciente->setEndereco($_POST['endereco']);
        $paciente->setCidade($_POST['cidade']);
        $paciente->setEstado($_POST['estado']);
        $paciente->setCep($_POST['cep']);
        $paciente->setMotivoDaConsulta($_POST['motivo']);
        try {
            if ($usuarioDAO->cadastrarPaciente($paciente)) {
                header('Location: AreaDaRecepcionista.php?sucesso=1');
                exit;
            }
        } catch (Exception $e) {
            $mensagem = $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="Recepcionista.css" />
        <title>Área da Recepcionista</title>
    </head>
    <body>
        <div class="content">
            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1 && empty($mensagem)): ?>
                <div class="alert alert-success text-center" id="mensagem-sucesso">
                    Cadastro realizado com sucesso!
                </div>
                <style>
                    #mensagem-sucesso {
                        position: fixed;
                        top: 75px;
                        left: 50%;
                        transform: translateX(-50%);
                        z-index: 9999;
                        opacity: 1;
                        transition: opacity 0.5s ease;
                        width: auto;
                        max-width: 90%;
                        padding: 10px 20px;
                        border-radius: 5px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                        font-weight: bold;
                    }
                </style>
                <script>
                    setTimeout(function () {
                        const sucesso = document.getElementById('mensagem-sucesso');
                        if (sucesso) {
                            sucesso.style.opacity = '0';
                            setTimeout(() => sucesso.remove(), 500);
                        }
                    }, 2000);
                </script>
            <?php endif; ?>
            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-danger text-center" id="mensagem-erro">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
                <style>
                    #mensagem-erro {
                        position: fixed;
                        top: 75px;
                        left: 50%;
                        transform: translateX(-50%);
                        z-index: 9999;
                        opacity: 1;
                        transition: opacity 0.5s ease;
                        width: auto;
                        max-width: 90%;
                        padding: 10px 20px;
                        border-radius: 5px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                        font-weight: bold;
                    }
                </style>
                <script>
                    setTimeout(function () {
                        const erro = document.getElementById('mensagem-erro');
                        if (erro) {
                            erro.style.opacity = '0';
                            setTimeout(() => erro.remove(), 500);
                        }
                    }, 2000);
                </script>
            <?php endif; ?>
            <div class="fixer">
                <div class="titulo-container">
                    <h1 class="titulo-principal">
                        <a href="AreaDaRecepcionista.php" class="link-titulo">Hospital Vitalis</a>
                    </h1>
                    <a href="Login/RecepcionistaLogin.php?logout=1" class="btn-sair">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </div>
                <hr class="border border-secondary border-2 opacity-50" style="margin-top: 0;" />
                <ul class="menu-acesso">
                    <li class="dropdown">
                        Opções
                        <ul class="submenu">
                            <li><a href="Perfis/PerfilRecepcionista.php" class="medico">Perfil</a></li>
                            <li><a href="AreaDaRecepcionista.php" class="recepcionista">Agendar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="form-container" style="margin-top: 125px;">
                <form method="POST">
                    <div class="form-heading">
                        <i class="fas fa-user-plus"></i> Cadastrar Paciente
                    </div>
                    <div class="form-section">
                        <div class="mb-3">
                            <label for="nome" class="form-label text-light">Nome:</label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-light">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label text-light">CPF:</label>
                            <input type="text" class="form-control" name="cpf" id="cpf" maxlength="14" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label text-light">Telefone:</label>
                            <input type="tel" class="form-control" name="telefone" id="telefone" maxlength="15" required>
                        </div>
                    </div>
                    <div class="form-section">
                        <div class="mb-3">
                            <label for="data_nascimento" class="form-label text-light">Data de Nascimento:</label>
                            <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" required>
                        </div>
                        <div class="mb-3">
                            <label for="sexo" class="form-label text-light">Sexo:</label>
                            <select class="form-select" name="sexo" id="sexo" required>
                                <option value="">Selecione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label text-light">Endereço:</label>
                            <input type="text" class="form-control" name="endereco" id="endereco" required>
                        </div>
                        <div class="mb-3">
                            <label for="cidade" class="form-label text-light">Cidade:</label>
                            <input type="text" class="form-control" name="cidade" id="cidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label text-light">Estado (UF):</label>
                            <input type="text" class="form-control" name="estado" id="estado" maxlength="2" required>
                        </div>
                        <div class="mb-3">
                            <label for="cep" class="form-label text-light">CEP:</label>
                            <input type="text" class="form-control" name="cep" id="cep" maxlength="9" required>
                        </div>
                    </div>
                    <div class="form-section">
                        <div class="mb-4">
                            <label for="motivo" class="form-label text-light">Motivo da Consulta:</label>
                            <textarea class="form-control" name="motivo" id="motivo" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="cadastrar" class="btn btn-danger w-100">Cadastrar Paciente</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
            include "FooterArea.php";
        ?>
        <script>
            document.getElementById('cep').addEventListener('input', function(e) {
                let cep = this.value.replace(/\D/g, '');
                if (cep.length <= 5) {
                    this.value = cep;
                } else {
                    this.value = `${cep.substring(0, 5)}-${cep.substring(5, 8)}`;
                }
            });
            document.getElementById('telefone').addEventListener('input', function(e) {
                let telefone = this.value.replace(/\D/g, '');
                if (telefone.length <= 2) {
                    this.value = telefone;
                } else if (telefone.length <= 3) {
                    this.value = `(${telefone.substring(0, 2)}) ${telefone.substring(2)}`;
                } else if (telefone.length <= 8) {
                    this.value = `(${telefone.substring(0, 2)}) ${telefone.substring(2, 7)}-${telefone.substring(7)}`;
                } else {
                    this.value = `(${telefone.substring(0, 2)}) ${telefone.substring(2, 7)}-${telefone.substring(7, 11)}`;
                }
            });
            document.getElementById('cpf').addEventListener('input', function(e) {
                let cpf = this.value.replace(/\D/g, '');
                if (cpf.length <= 3) {
                    this.value = cpf;
                } else if (cpf.length <= 6) {
                    this.value = `${cpf.substring(0, 3)}.${cpf.substring(3)}`;
                } else if (cpf.length <= 9) {
                    this.value = `${cpf.substring(0, 3)}.${cpf.substring(3, 6)}.${cpf.substring(6)}`;
                } else {
                    this.value = `${cpf.substring(0, 3)}.${cpf.substring(3, 6)}.${cpf.substring(6, 9)}-${cpf.substring(9, 11)}`;
                }
            });
        </script>
    </body>
</html>