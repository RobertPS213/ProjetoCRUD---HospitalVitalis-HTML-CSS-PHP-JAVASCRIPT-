<?php
session_start();
require_once '../../Modelo/ClassMedico.php';
require_once '../../Modelo/DAO/ClassUsuarioDAO.php';

// Se não estiver logado, manda pra página de login
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
    <title>Perfil Médico</title>
    <link rel="stylesheet" href="../style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        .perfil-container {
            max-width: 600px;
            margin: 130px auto 50px;
            background: #f8f9fa;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(192,57,43,0.3);
            font-family: 'Trebuchet MS', sans-serif;
        }
        .perfil-titulo {
            text-align: center;
            color: #c0392b;
            font-weight: 700;
            margin-bottom: 30px;
            font-size: 2.4rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        label {
            font-weight: 600;
            color: #222;
        }
        input[type="text"], input[type="password"] {
            border: 2px solid #c0392b;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 1.1rem;
            color: #333;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #922b21;
            outline: none;
            box-shadow: 0 0 8px rgba(201,43,36,0.5);
        }
        .btn-alterar {
            background: #c0392b;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 25px;
            transition: background-color 0.3s ease;
        }
        .btn-alterar:hover {
            background: #922b21;
        }
        .matricula-label {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 10px;
            font-style: italic;
        }
        #msg-sucesso {
            position: fixed;
            top: 75px;
            left: 50%;
            transform: translateX(-50%);
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 25px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            font-weight: 600;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
            max-width: 90%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content">
            <div class="fixer">
                <div class="titulo-container">
                    <h1 class="titulo-principal">
                        <a href="AreaDoMedico.php" class="link-titulo">Hospital Vitalis</a>
                    </h1>
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

        <div class="perfil-container">
            <h2 class="perfil-titulo">Editar Perfil</h2>

            <?php if (isset($_GET['MSG'])): ?>
                <div id="msg-sucesso"><?= htmlspecialchars($_GET['MSG']) ?></div>
                <script>
                    setTimeout(() => {
                        const el = document.getElementById('msg-sucesso');
                        if(el) {
                            el.style.opacity = '0';
                            setTimeout(() => el.remove(), 500);
                        }
                    }, 2000);
                </script>
            <?php endif; ?>

            <form method="post" action="../../Controle/ControleUsuarios.php?ACAO=alterarMedico" novalidate>
                <div class="mb-4">
                    <label class="matricula-label">Matrícula (não editável)</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($medico->getMatricula()) ?>" disabled />
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
