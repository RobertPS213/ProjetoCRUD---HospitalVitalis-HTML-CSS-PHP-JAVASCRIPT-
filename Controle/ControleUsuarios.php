<?php
    require_once '../Modelo/ClassMedico.php';
    require_once '../Modelo/ClassPaciente.php';
    require_once '../Modelo/ClassRecepcionista.php';
    require_once '../Modelo/DAO/ClassUsuarioDAO.php';

    session_start(); // Início da sessão para usar $_SESSION

    // Receber a ação tanto de GET quanto de POST
    $acao = isset($_POST['ACAO']) ? $_POST['ACAO'] : (isset($_GET['ACAO']) ? $_GET['ACAO'] : '');
    $usuarioDAO = new ClassUsuarioDAO();

    if (empty($acao)) {
        header("Location: ../Visao/AreaDoMedico.php?erroExclusao=1");
        exit;
    }

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
            exit;
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
                exit;
            } else {
                header("Location:../Visao/Login/MedicoLogin.php?erro=1");
                exit;
            }
            break;

        case "loginRecepcionista":
            $codigo = $_POST['codigo'];
            $senha = $_POST['senha'];
            $recepcionista = $usuarioDAO->buscarRecepcionistaPorCodigo($codigo);

            if ($recepcionista && $recepcionista['Senha'] === $senha) {
                // Armazena dados na sessão
                $_SESSION['recepcionista'] = [
                    'codigo' => $recepcionista['Codigo'],
                    'nome' => $recepcionista['Nome'],
                    'senha' => $recepcionista['Senha']
                ];

                // Redireciona para a área da recepcionista
                header("Location:../Visao/AreaDaRecepcionista.php");
                exit;
            } else {
                header("Location:../Visao/Login/RecepcionistaLogin.php?erro=1");
                exit;
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
            exit;
            break;
        case 'alterarMedico':
            $medicoDAO = new ClassUsuarioDAO();
            $medico = new ClassMedico();

            $medico->setMatricula($_POST['matricula']);
            $medico->setNome($_POST['nome']);
            $medico->setSenha($_POST['senha']);
            
            $resultado = $medicoDAO->alterarMedico($medico);
            if($resultado){
                header("Location: ../Visao/Perfis/PerfilMedico.php?MSG=Alteração realizada com sucesso");
                exit;
            } else {
                header("Location: ../Visao/Perfis/PerfilMedico.php?MSG=Erro ao alterar dados");
                exit;
            }
            break;
        case 'alterarRecepcionista':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $codigo = $_POST['codigo'];
                $nome = $_POST['nome'];
                $senha = $_POST['senha'];

                $recep = new ClassRecepcionista();
                $recep->setCodigo($codigo);
                $recep->setNome($nome);
                $recep->setSenha($senha);

                $dao = new ClassUsuarioDAO();
                
                // Buscar os dados atuais para comparar
                $dadosAtuais = $dao->buscarRecepcionistaPorCodigo($codigo);
                
                // Verificar se houve alterações
                $temAlteracoes = false;
                if ($nome !== $dadosAtuais['Nome']) {
                    $temAlteracoes = true;
                }
                // Verifica se a senha foi alterada (diferente da senha atual e não vazia)
                if ($senha !== $dadosAtuais['Senha'] && !empty($senha)) {
                    $temAlteracoes = true;
                }

                if ($temAlteracoes) {
                    $resultado = $dao->atualizarRecepcionista($recep);
                    if ($resultado) {
                        header('Location: ../Visao/Perfis/PerfilRecepcionista.php?MSG=Alteração realizada com sucesso!');
                    } else {
                        header('Location: ../Visao/Perfis/PerfilRecepcionista.php?MSG=Erro ao alterar dados');
                    }
                } else {
                    header('Location: ../Visao/Perfis/PerfilRecepcionista.php?MSG=Erro ao alterar dados');
                }
                exit;
            }
            break;
        case "excluirPaciente":
            $id = $_POST['id'];
            error_log("Tentando excluir paciente com ID: " . $id);
            
            if ($usuarioDAO->excluirPaciente($id)) {
                error_log("Paciente excluído com sucesso. ID: " . $id);
                echo 'success';
            } else {
                error_log("Erro ao excluir paciente. ID: " . $id);
                echo 'error';
            }
            exit;
            break;
}
?>
