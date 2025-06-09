<?php
session_start();
require_once '../Controle/ControleUsuarios.php';
require_once '../Modelo/DAO/Conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

try {
    $conexao = new Conexao();
    $pdo = $conexao->conectar();
    
    // Consulta com JOIN entre pacientes, médicos e recepcionistas
    $sql = "SELECT 
        p.id as id_paciente,
        p.nome as nome_paciente,
        p.data_nascimento,
        p.telefone,
        m.nome as nome_medico,
        r.nome as nome_recepcionista,
        p.data_cadastro
    FROM pacientes p
    INNER JOIN medicos m ON p.medico_responsavel = m.id
    INNER JOIN recepcionistas r ON p.recepcionista_cadastro = r.id
    ORDER BY p.data_cadastro DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    echo "Erro ao gerar relatório: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Pacientes - Hospital Vitalis</title>
    <link rel="stylesheet" href="../Perfis/Perfil.css">
    <style>
        .relatorio-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .titulo {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <?php include '../Header.php'; ?>
    
    <div class="relatorio-container">
        <h2 class="titulo">Relatório de Pacientes</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Paciente</th>
                    <th>Data Nascimento</th>
                    <th>Telefone</th>
                    <th>Médico Responsável</th>
                    <th>Recepcionista</th>
                    <th>Data Cadastro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientes as $paciente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($paciente['id_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['nome_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['data_nascimento']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['telefone']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['nome_medico']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['nome_recepcionista']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['data_cadastro']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php include '../Footer.php'; ?>
</body>
</html>
