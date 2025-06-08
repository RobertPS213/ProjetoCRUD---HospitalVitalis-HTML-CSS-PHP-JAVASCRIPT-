<?php
    session_start();
    require_once '../../Modelo/ClassMedico.php';
    require_once '../../Modelo/DAO/ClassUsuarioDAO.php';
    if (!isset($_SESSION['matricula_medico'])) {
        header('Location: ../Login/MedicoLogin.php');
        exit;
    }
    $matricula = $_SESSION['matricula_medico'];
    $dao = new ClassUsuarioDAO();
    $dados = $dao->buscarMedicoPorMatricula($matricula);

    if (!$dados) {
        echo "Médico não encontrado!";
        exit;
    }
    $medico = new ClassMedico();
    $medico->setMatricula($dados['Matricula']);
    $medico->setNome($dados['Nome']);
    $medico->setSenha($dados['Senha']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../style.css" />
    <link rel="stylesheet" type="text/css" href="Perfil.css" />
    <title>Perfil do Médico</title>
</head>
<body>
    <div class="content">
        <div class="fixer">
            <div class="titulo-container">
                <h1 class="titulo-principal">
                    <a href="../AreaDoMedico.php" class="link-titulo">Hospital Vitalis</a>
                </h1>
                <a href="../Login/MedicoLogin.php?logout=1" class="btn-sair">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
            <hr class="border border-secondary border-2 opacity-50" style="margin-top: 0;" />
            <ul class="menu-acesso">
                <li class="dropdown">
                    Opções
                    <ul class="submenu">
                        <li><a href="PerfilMedico.php" class="medico">Perfil</a></li>
                        <li><a href="../AreaDoMedico.php" class="recepcionista">Consultas</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="perfil-container">
            <h2 class="perfil-titulo">Editar Perfil</h2>

            <?php if (isset($_GET['MSG'])): ?>
                <?php if (strpos($_GET['MSG'], 'sucesso') !== false): ?>
                    <div class="msg-sucesso"><?= htmlspecialchars($_GET['MSG']) ?></div>
                <?php else: ?>
                    <div class="msg-erro"><?= htmlspecialchars($_GET['MSG']) ?></div>
                <?php endif; ?>
                <script>
                    setTimeout(() => {
                        const el = document.querySelector('.msg-sucesso, .msg-erro');
                        if(el) {
                            el.style.opacity = '0';
                            setTimeout(() => el.remove(), 500);
                        }
                    }, 2000);
                </script>
            <?php endif; ?>
            <form method="post" action="../../Controle/ControleUsuarios.php?ACAO=alterarMedico" novalidate>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $temAlteracoes = false;
                    
                    if (isset($_POST['nome']) && $_POST['nome'] !== $medico->getNome()) {
                        $medico->setNome($_POST['nome']);
                        $temAlteracoes = true;
                    }
                    
                    if (isset($_POST['senha']) && !empty($_POST['senha'])) {
                        $medico->setSenha($_POST['senha']);
                        $temAlteracoes = true;
                    }
                    
                    if ($temAlteracoes) {
                        $dao->alterarMedico($medico);
                        header('Location: PerfilMedico.php?MSG=Dados atualizados com sucesso!');
                        exit;
                    } else {
                        header('Location: PerfilMedico.php?MSG=Nenhuma alteração feita');
                        exit;
                    }
                }
                ?>
                <div class="form-group">
                    <label class="matricula-label">Matrícula <span>(não editável)<span></label>
                    <input type="text" class="matricula-valor" value="<?= htmlspecialchars($medico->getMatricula()) ?>" disabled />
                    <input type="hidden" name="matricula" value="<?= htmlspecialchars($medico->getMatricula()) ?>" />
                </div>
                <div class="mb-4">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($medico->getNome()) ?>" required />
                </div>
                <div class="mb-4">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" value="<?= htmlspecialchars($medico->getSenha()) ?>" required />
                </div>
                <button type="submit" class="btn-alterar">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <?php require_once "../Footer.php"; ?>
</body>
</html>
