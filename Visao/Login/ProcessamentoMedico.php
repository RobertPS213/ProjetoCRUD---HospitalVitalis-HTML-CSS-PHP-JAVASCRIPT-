<?php
session_start();
$matriculaCorreta = '1234';
$senhaCorreta = 'senha123';
$matricula = $_POST['matricula'];
$senha = $_POST['senha'];
if ($matricula === $matriculaCorreta && $senha === $senhaCorreta) {
    $_SESSION['medico'] = [
        'nome' => 'Dr. João',
        'matricula' => $matricula,
        'senha' => $senha
    ];
    header('Location: ../Perfis/PerfilMedico.php');
    exit;
} else {
    header('Location: MedicoLogin.php?erro=1');
    exit;
}