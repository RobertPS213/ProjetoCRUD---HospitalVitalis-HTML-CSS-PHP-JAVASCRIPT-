<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Médico - Hospital Vitalis</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css" />
        <style>
            .form-container {
                max-width: 600px;
                margin: 0 auto;
                padding: 30px;
                background-color: #333333;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            }
        </style>
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
                            <li><a href="../Login/MedicoLogin.php" class="medico">Médico</a></li>
                            <li><a href="../Login/RecepcionistaLogin.php" class="recepcionista">Recepcionista</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <h1 class="comentario">Cadastro</h1>
            <?php if (isset($_GET['erroCadastro']) && $_GET['erroCadastro'] == 1): ?>
                <div class="alert alert-danger text-center" id="mensagem-erro-cadastro">
                    Cadastro ou senha já usados!
                </div>
                <style>
                    #mensagem-erro-cadastro {
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
                        const erro = document.getElementById('mensagem-erro-cadastro');
                        if (erro) {
                            erro.style.opacity = '0';
                            setTimeout(() => erro.remove(), 500);
                        }
                    }, 2000);
                </script>
            <?php endif; ?>
            <div class="form-container">
                <form action="../../Controle/ControleUsuarios.php?ACAO=cadastrarMedico" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label text-light">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="nome" required />
                    </div>
                    <div class="mb-3">
                        <label for="matricula" class="form-label text-light">Matrícula:</label>
                        <input type="text" class="form-control" name="matricula" id="matricula" maxlength="9" required />
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label text-light">Senha:</label>
                        <input type="password" class="form-control" name="senha" id="senha" required />
                    </div>
                    <button type="submit" class="btn btn-danger w-100" id="botao">Cadastrar Médico</button>
                </form>
            </div>
        </div>
        <?php
            require_once "../Footer.php";
        ?>
    </body>
</html>