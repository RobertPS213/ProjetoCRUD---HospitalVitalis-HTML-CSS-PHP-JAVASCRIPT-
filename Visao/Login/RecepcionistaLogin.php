<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="../style.css" />
        <title>Login Recepcionista</title>
    </head>
    <body>
        <div class="content">
            <div class="fixer">
                <div class="titulo-container">
                    <h1 class="titulo-principal">
                        <a href="../../index.php" class="link-titulo">Hospital Vitalis</a>
                    </h1>
                </div>
                <hr class="border border-secondary border-2 opacity-50" style="margin-top: 0;" />
                <ul class="menu-acesso">
                    <li class="dropdown">
                        Área de Acesso
                        <ul class="submenu">
                            <li><a href="MedicoLogin.php" class="medico">Médico</a></li>
                            <li><a href="RecepcionistaLogin.php" class="recepcionista">Recepcionista</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <h1 class="comentario">Login da Recepcionista</h1>
            <?php
                // Incluímos o arquivo de conexão e DAO
                require_once '../../Modelo/DAO/ClassUsuarioDAO.php';
                $usuarioDAO = new ClassUsuarioDAO();

                // Verifica se já está logado
                if (isset($_SESSION['recepcionista'])) {
                    header('Location: ../AreaDaRecepcionista.php');
                    exit;
                }

                // Se houver sucesso no cadastro, mostra a mensagem
                if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
                    echo '<div class="alert alert-success text-center" id="mensagem-sucesso">Cadastro realizado com sucesso!</div>';
                }

                // Se houver erro de login, mostra a mensagem
                if (isset($_GET['erro']) && $_GET['erro'] == 1) {
                    echo '<div class="alert alert-danger text-center" id="mensagem-erro">Código ou senha incorretos!</div>';
                }
            ?>
            <style>
                #mensagem-sucesso, #mensagem-erro {
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
                    const mensagem = document.getElementById('mensagem-sucesso');
                    const erro = document.getElementById('mensagem-erro');
                    if (mensagem) {
                        mensagem.style.opacity = '0';
                        setTimeout(() => mensagem.remove(), 500);
                    }
                    if (erro) {
                        erro.style.opacity = '0';
                        setTimeout(() => erro.remove(), 500);
                    }
                }, 2000);
            </script>
            <div class="container mt-4 mb-5" style="max-width: 600px; background-color: #333333; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #000;">
                <form action="../../Controle/ControleUsuarios.php?ACAO=loginRecepcionista" method="POST">
                    <div class="mb-3">
                        <label for="codigo" class="form-label text-light">Código:</label>
                        <input type="text" class="form-control" name="codigo" id="codigo" maxlength="10" required />
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label text-light">Senha:</label>
                        <input type="password" class="form-control" name="senha" id="senha" required />
                    </div>
                    <button type="submit" class="btn btn-danger w-100" id="botao">Logar</button>
                </form>
                <div class="text-center mt-4">
                    <a href="../Cadastro/RecepcionistaCadastro.php" class="btn btn-outline-light px-4 py-2" style="border-radius: 30px; transition: all 0.3s;">
                        Cadastre-se
                    </a>
                </div>
            </div>
        </div>
        <?php
            require_once "../Footer.php";
        ?>
    </body>
</html>