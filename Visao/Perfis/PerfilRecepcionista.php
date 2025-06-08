<?php
    session_start();
    require_once '../../Modelo/ClassRecepcionista.php';
    require_once '../../Modelo/DAO/ClassUsuarioDAO.php';
    if (!isset($_SESSION['codigo_recepcionista'])) {
        header('Location: ../Login/RecepcionistaLogin.php');
        exit;
    }
    $codigo = $_SESSION['codigo_recepcionista'];
    $dao = new ClassUsuarioDAO();
    $dados = $dao->buscarRecepcionistaPorCodigo($codigo);
    if (!$dados) {
        echo "Recepcionista não encontrada!";
        exit;
    }
    $recep = new ClassRecepcionista();
    $recep->setCodigo($dados['Codigo']);
    $recep->setNome($dados['Nome']);
    $recep->setSenha($dados['Senha']);
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
        <title>Perfil da Recepcionista</title>
    </head>
    <body>
        <div class="content">
            <div class="fixer">
                <div class="titulo-container">
                    <h1 class="titulo-principal">
                        <a href="../AreaDaRecepcionista.php" class="link-titulo">Hospital Vitalis</a>
                    </h1>
                    <a href="../Login/RecepcionistaLogin.php?logout=1" class="btn-sair">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </div>
                <hr class="border border-secondary border-2 opacity-50" style="margin-top: 0;" />
                <ul class="menu-acesso">
                    <li class="dropdown">
                        Opções
                        <ul class="submenu">
                            <li><a href="PerfilRecepcionista.php" class="medico">Perfil</a></li>
                            <li><a href="../AreaDaRecepcionista.php" class="recepcionista">Pacientes</a></li>
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
                <form method="post" action="../../Controle/ControleUsuarios.php?ACAO=alterarRecepcionista" novalidate>
                    <div class="mb-4">
                        <label class="codigo-label">Código <span>(não editável)</span></label>
                        <input type="text" class="codigo-valor" value="<?= htmlspecialchars($recep->getCodigo()) ?>" disabled />
                        <input type="hidden" name="codigo" value="<?= htmlspecialchars($recep->getCodigo()) ?>" />
                    </div>
                    <div class="mb-4">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($recep->getNome()) ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" class="form-control" value="<?= htmlspecialchars($recep->getSenha()) ?>" required />
                    </div>
                    <button type="submit" class="btn-alterar">Salvar Alterações</button>
                </form>
            </div>
        </div>
        <?php
            require_once "../Footer.php"; 
        ?>
    </body>
</html>
