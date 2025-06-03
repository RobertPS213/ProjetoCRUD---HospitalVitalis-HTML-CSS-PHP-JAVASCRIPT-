<?php
    require_once 'Conexao.php';

    class ClassUsuarioDAO
    {
        public function cadastrarMedico(ClassMedico $medico){
            try {
                $pdo = Conexao::getInstance();
                $sql = "INSERT INTO Medico (Matricula, Nome, Senha) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $medico->getMatricula());
                $stmt->bindValue(2, $medico->getNome());
                $stmt->bindValue(3, $medico->getSenha());
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo "Erro ao cadastrar médico: " . $e->getMessage();
            }
        }

        public function cadastrarRecepcionista(ClassRecepcionista $recepcionista){
            try {
                $pdo = Conexao::getInstance();
                $sql = "INSERT INTO Recepcionista (Codigo, Nome, Senha) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $recepcionista->getCodigo());
                $stmt->bindValue(2, $recepcionista->getNome());
                $stmt->bindValue(3, $recepcionista->getSenha());
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo "Erro ao cadastrar recepcionista: " . $e->getMessage();
            }
        }
        public function buscarMedicoPorMatricula($matricula){
            try {
                $pdo = Conexao::getInstance();
                $sql = "SELECT * FROM Medico WHERE Matricula = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $matricula);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erro ao buscar médico: " . $e->getMessage();
                return false;
            }
        }
        public function buscarRecepcionistaPorCodigo($codigo){
            try {
                $pdo = Conexao::getInstance();
                $sql = "SELECT * FROM Recepcionista WHERE Codigo = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $codigo);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erro ao buscar recepcionista: " . $e->getMessage();
                return false;
            }
        }
        public function verificarSenhaUsada($tabela, $senha) {
            try {
                $pdo = Conexao::getInstance();
                $sql = "SELECT COUNT(*) FROM $tabela WHERE Senha = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $senha);
                $stmt->execute();
                $resultado = $stmt->fetchColumn();
                return $resultado > 0;
            } catch (PDOException $e) {
                echo "Erro ao verificar senha: " . $e->getMessage();
                return false;
            }
        }
        public function alterarMedico(ClassMedico $medico)
{
    try {
        $pdo = Conexao::getInstance();
        $sql = "UPDATE medico SET nome=?, senha=? WHERE matricula=?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $medico->getNome());
        $stmt->bindValue(2, $medico->getSenha());
        $stmt->bindValue(3, $medico->getMatricula());
        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
}
    }
?>