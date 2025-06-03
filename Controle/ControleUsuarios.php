<?php
    require_once '../Modelo/ClassMedico.php';
    require_once '../Modelo/ClassRecepcionista.php';
    require_once '../Modelo/DAO/ClassUsuarioDAO.php';

    session_start(); // Início da sessão para usar $_SESSION

    $acao = $_GET['ACAO'];
    $usuarioDAO = new ClassUsuarioDAO();

    switch ($acao) {
        case "cadastrarRecepcionista":
            $codigo = $_POST['codigo'];
            $nome = $_POST['nome'];
            $senha = $_POST['senha'];

            $recepcionistaExistente = $usuarioDAO->buscarRecepcionistaPorCodigo($codigo);

            if ($recepcionistaExistente || $usuarioDAO->verificarSenhaUsada('Recepcionista', $senha)) {
                header("Location:../Visao/Cadastro/RecepcionistaCadastro.php?erroCadastro=1");
                exit;
            }

            $recepcionista = new ClassRecepcionista();
            $recepcionista->setCodigo($codigo);
            $recepcionista->setNome($nome);
            $recepcionista->setSenha($senha);

            $usuarioDAO->cadastrarRecepcionista($recepcionista);
            header("Location:../Visao/Login/RecepcionistaLogin.php?sucesso=1");
            break;

        case "loginMedico":
            $matricula = $_POST['matricula'];
            $senha = $_POST['senha'];
            $medico = $usuarioDAO->buscarMedicoPorMatricula($matricula);

            if ($medico && $medico['Senha'] === $senha) {
                // Armazena dados na sessão para usar no perfil
                $_SESSION['matricula_medico'] = $medico['Matricula'];
                $_SESSION['nome'] = $medico['Nome'];
                $_SESSION['senha'] = $medico['Senha'];

                header("Location:../Visao/AreaDoMedico.php");
            } else {
                header("Location:../Visao/Login/MedicoLogin.php?erro=1");
            }
            break;

        case "loginRecepcionista":
            $codigo = $_POST['codigo'];
            $senha = $_POST['senha'];
            $recepcionista = $usuarioDAO->buscarRecepcionistaPorCodigo($codigo);

            if ($recepcionista && $recepcionista['Senha'] === $senha) {
                // Armazena dados na sessão para usar no perfil
                $_SESSION['codigo'] = $recepcionista['Codigo'];
                $_SESSION['nome'] = $recepcionista['Nome'];
                $_SESSION['senha'] = $recepcionista['Senha'];

                header("Location:../Visao/AreaDaRecepcionista.php");
            } else {
                header("Location:../Visao/Login/RecepcionistaLogin.php?erro=1");
            }
            break;

        case "cadastrarMedico":
            $matricula = $_POST['matricula'];
            $nome = $_POST['nome'];
            $senha = $_POST['senha'];

            $medicoExistente = $usuarioDAO->buscarMedicoPorMatricula($matricula);

            if ($medicoExistente || $usuarioDAO->verificarSenhaUsada('Medico', $senha)) {
                header("Location:../Visao/Cadastro/MedicoCadastro.php?erroCadastro=1");
                exit;
            }

            $medico = new ClassMedico();
            $medico->setMatricula($matricula);
            $medico->setNome($nome);
            $medico->setSenha($senha);

            $usuarioDAO->cadastrarMedico($medico);
            header("Location:../Visao/Login/MedicoLogin.php?sucesso=1");
            break;
        case 'alterarMedico':
    $medicoDAO = new ClassUSuarioDAO();
    $medico = new ClassMedico();

    $medico->setMatricula($_POST['matricula']);
    $medico->setNome($_POST['nome']);
    $medico->setSenha($_POST['senha']);
    
    $resultado = $medicoDAO->alterarMedico($medico);
    if($resultado){
        header("Location: ../Visao/Perfis/PerfilMedico.php?MSG=Alteração realizada com sucesso");
    } else {
        header("Location: ../Visao/Perfis/PerfilMedico.php?MSG=Erro ao alterar dados");
    }
    break;
}
?>
