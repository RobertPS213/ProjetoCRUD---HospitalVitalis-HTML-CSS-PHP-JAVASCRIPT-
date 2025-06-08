<?php
    require_once '../Modelo/DAO/ClassUsuarioDAO.php';
    $usuarioDAO = new ClassUsuarioDAO();
    $pacientes = $usuarioDAO->buscarTodosPacientes();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="Medico.css" />
        <title>Área do Médico</title>
    </head>
    <body>
        <div class="content">
            <div class="fixer">
                <div class="titulo-container">
                    <h1 class="titulo-principal">
                        <a href="AreaDoMedico.php" class="link-titulo">Hospital Vitalis</a>
                    </h1>
                    <a href="Login/MedicoLogin.php?logout=1" class="btn-sair">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </div>
                <hr class="border border-secondary border-2 opacity-50" style="margin-top: 0;" />
                <ul class="menu-acesso">
                    <li class="dropdown">
                        Opções
                        <ul class="submenu">
                            <li><a href="Perfis/PerfilMedico.php" class="medico">Perfil</a></li>
                            <li><a href="AreaDoMedico.php" class="recepcionista">Consultas</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="container consultas-container">
                <?php if (isset($_GET['sucessoExclusao']) && $_GET['sucessoExclusao'] == 1): ?>
                    <div class="alert alert-success text-center" id="mensagem-sucesso">
                        Paciente excluído com sucesso!
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
                        setTimeout(function() {
                            const sucesso = document.getElementById('mensagem-sucesso');
                            if (sucesso) {
                                sucesso.style.opacity = '0';
                                setTimeout(() => sucesso.remove(), 500);
                            }
                        }, 2000);
                    </script>
                <?php endif; ?>
                <?php if (isset($_GET['erroExclusao']) && $_GET['erroExclusao'] == 1): ?>
                    <div class="alert alert-danger text-center" id="mensagem-erro">
                        Erro ao excluir paciente. Tente novamente.
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
                        setTimeout(function() {
                            const erro = document.getElementById('mensagem-erro');
                            if (erro) {
                                erro.style.opacity = '0';
                                setTimeout(() => erro.remove(), 500);
                            }
                        }, 2000);
                    </script>
                <?php endif; ?>
                <h2 class="consultas-titulo">Consultas</h2>
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-bordered rounded-table text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>Data de Nascimento</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Cidade</th>
                                <th>Estado</th>
                                <th>CEP</th>
                                <th>Motivo da Consulta</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes as $paciente): ?>
                                <tr id="paciente-<?= $paciente->getId() ?>">
                                    <td><?= htmlspecialchars($paciente->getId()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getNome()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getEmail()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getCpf()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getTelefone()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getDataDeNascimento()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getSexo()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getEndereco()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getCidade()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getEstado()) ?></td>
                                    <td><?= htmlspecialchars($paciente->getCep()) ?></td>
                                    <td class="td-motivo"><?= htmlspecialchars($paciente->getMotivoDaConsulta()) ?></td>
                                    <td>
                                        <button type="button" class="btn delete-btn" data-id="<?= $paciente->getId() ?>">
                                            <i class="fas fa-trash"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id="mensagem-sistema" class="alert" style="display: none; position: fixed; top: 75px; left: 50%; transform: translateX(-50%); z-index: 9999; width: auto; max-width: 90%; padding: 10px 20px; border-radius: 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); font-weight: bold;"></div>
            </div>
        </div>
        <?php
            include "FooterArea.php";
        ?>
        <script>
            console.log('Script carregado');
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM carregado');
                const deleteButtons = document.querySelectorAll('.delete-btn');
                console.log('Botões encontrados:', deleteButtons.length);
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        console.log('Botão clicado');
                        const pacienteId = this.dataset.id;
                        const pacienteRow = document.getElementById('paciente-' + pacienteId);
                        if (!pacienteRow) {
                            console.error('Não foi possível encontrar a linha do paciente com ID:', pacienteId);
                            return;
                        }
                        const mensagem = document.getElementById('mensagem-sistema');
                        if (!mensagem) {
                            console.error('Elemento de mensagem não encontrado');
                            return;
                        }
                        console.log('ID do paciente:', pacienteId);
                        if (confirm('Tem certeza que deseja excluir este paciente?')) {
                            console.log('Confirmação aceita');
                            mensagem.className = 'alert alert-info';
                            mensagem.textContent = 'Excluindo paciente...';
                            mensagem.style.display = 'block';
                            mensagem.style.opacity = '1';
                            console.log('Mensagem de carregamento mostrada');
                            fetch('../Controle/ControleUsuarios.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'ACAO=excluirPaciente&id=' + pacienteId
                            })
                            .then(response => {
                                console.log('Resposta do servidor:', response);
                                return response.text();
                            })
                            .then(data => {
                                console.log('Dados recebidos:', data);
                                if (data === 'success') {
                                    console.log('Exclusão bem sucedida');
                                    // Remove the row from table
                                    pacienteRow.remove();
                                    // Show success message
                                    mensagem.className = 'alert alert-success';
                                    mensagem.textContent = 'Paciente excluído com sucesso!';
                                } else {
                                    console.error('Erro na exclusão:', data);
                                    // Show error message
                                    mensagem.className = 'alert alert-danger';
                                    mensagem.textContent = 'Erro ao excluir paciente. Tente novamente.';
                                }
                                setTimeout(() => {
                                    console.log('Iniciando fade out');
                                    mensagem.style.opacity = '0';
                                }, 2000);
                                setTimeout(() => {
                                    console.log('Resetando mensagem');
                                    mensagem.style.display = 'none';
                                    mensagem.style.opacity = '1';
                                }, 2500);
                            })
                            .catch(error => {
                                console.error('Erro:', error);
                                mensagem.className = 'alert alert-danger';
                                mensagem.textContent = 'Erro ao excluir paciente. Verifique o console do navegador para mais detalhes.';
                                setTimeout(() => {
                                    mensagem.style.opacity = '0';
                                }, 2000);
                                setTimeout(() => {
                                    mensagem.style.display = 'none';
                                    mensagem.style.opacity = '1';
                                }, 2500);
                            });
                        }
                    });
                });
            });
        </script>
    </body>
</html>