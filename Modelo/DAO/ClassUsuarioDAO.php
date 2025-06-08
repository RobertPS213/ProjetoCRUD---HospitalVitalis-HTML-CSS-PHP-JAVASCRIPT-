<?php
    require_once 'Conexao.php';
    require_once __DIR__ . '/../ClassPaciente.php';

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
        public function alterarMedico(ClassMedico $medico) {
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
        public function atualizarRecepcionista(ClassRecepcionista $r) {
            try {
                $pdo = Conexao::getInstance();
                $sql = "UPDATE Recepcionista SET Nome = :nome, Senha = :senha WHERE Codigo = :codigo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':nome', $r->getNome());
                $stmt->bindValue(':senha', $r->getSenha());
                $stmt->bindValue(':codigo', $r->getCodigo());
                return $stmt->execute();
            } catch (PDOException $e) {
                echo "Erro ao atualizar recepcionista: " . $e->getMessage();
                return false;
        }
    }

    public function verificarDuplicatas($cpf, $telefone, $email, $cep) {
        try {
            $pdo = Conexao::getInstance();
            
            // Verificar CPF duplicado
            $sql = "SELECT COUNT(*) as count FROM Paciente WHERE CPF = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $cpf);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['count'] > 0) {
                return "CPF já cadastrado";
            }
            
            // Verificar telefone duplicado
            $sql = "SELECT COUNT(*) as count FROM Paciente WHERE Telefone = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $telefone);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['count'] > 0) {
                return "Telefone já cadastrado";
            }
            
            // Verificar email duplicado
            $sql = "SELECT COUNT(*) as count FROM Paciente WHERE Email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result['count'] > 0) {
                return "Email já cadastrado";
            }
            
            // Verificar CEP duplicado
            if (!empty($cep)) {
                $sql = "SELECT COUNT(*) as count FROM Paciente WHERE CEP = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $cep);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result['count'] > 0) {
                    return "CEP já cadastrado";
                }
            }
            
            return null; // Nenhuma duplicata encontrada
        } catch (PDOException $e) {
            error_log("Erro ao verificar duplicatas: " . $e->getMessage());
            return "Erro ao verificar duplicatas";
        }
    }

    public function cadastrarPaciente(ClassPaciente $paciente) {
        try {
            // Remover caracteres especiais dos campos
            $cpf = preg_replace('/[^0-9]/', '', $paciente->getCpf());
            $telefone = preg_replace('/[^0-9]/', '', $paciente->getTelefone());
            $cep = preg_replace('/[^0-9]/', '', $paciente->getCep());

            // Verificar duplicatas
            $erro = $this->verificarDuplicatas(
                $cpf,
                $telefone,
                $paciente->getEmail(),
                $cep
            );
            
            if ($erro) {
                throw new Exception($erro);
            }

            $pdo = Conexao::getInstance();
            $sql = "INSERT INTO Paciente (Nome, Email, CPF, Telefone, DataDeNascimento, Sexo, Endereço, Cidade, Estado, CEP, MotivoDaConsulta) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $paciente->getNome());
            $stmt->bindValue(2, $paciente->getEmail());
            $stmt->bindValue(3, $cpf); // CPF sem caracteres especiais
            $stmt->bindValue(4, $telefone); // Telefone sem caracteres especiais
            $stmt->bindValue(5, $paciente->getDataDeNascimento());
            $stmt->bindValue(6, $paciente->getSexo());
            $stmt->bindValue(7, $paciente->getEndereco());
            $stmt->bindValue(8, $paciente->getCidade());
            $stmt->bindValue(9, $paciente->getEstado());
            $stmt->bindValue(10, $cep); // CEP sem caracteres especiais
            $stmt->bindValue(11, $paciente->getMotivoDaConsulta());
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            $mensagem = $e->getMessage();
            error_log("Erro ao cadastrar paciente: " . $mensagem);
            throw new Exception($mensagem);
        }
    }

    public function buscarTodosPacientes() {
        try {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM Paciente ORDER BY ID ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $pacientes = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $paciente = new ClassPaciente();
                $paciente->setId($row['ID']);
                $paciente->setNome($row['Nome']);
                $paciente->setEmail($row['Email']);
                $paciente->setCpf($row['CPF']);
                $paciente->setTelefone($row['Telefone']);
                $paciente->setDataDeNascimento($row['DataDeNascimento']);
                $paciente->setSexo($row['Sexo']);
                $paciente->setEndereco($row['Endereço']);
                $paciente->setCidade($row['Cidade']);
                $paciente->setEstado($row['Estado']);
                $paciente->setCep($row['CEP']);
                $paciente->setMotivoDaConsulta($row['MotivoDaConsulta']);
                $pacientes[] = $paciente;
            }
            return $pacientes;
        } catch (PDOException $e) {
            error_log("Erro ao buscar pacientes: " . $e->getMessage());
            return array();
        }
    }

    public function excluirPaciente($id) {
        try {
            $pdo = Conexao::getInstance();
            
            // Verificar se a tabela Paciente existe
            $sql = "SHOW TABLES LIKE 'Paciente'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if (!$stmt->fetch()) {
                error_log("Erro: Tabela Paciente não existe no banco de dados");
                return false;
            }
            
            // Verificar estrutura da tabela
            $sql = "DESCRIBE Paciente";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Colunas da tabela Paciente: " . print_r($columns, true));
            
            // Verificar relacionamentos
            $sql = "SELECT TABLE_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME 
                    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                    WHERE REFERENCED_TABLE_NAME = 'Paciente'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $relationships = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Relacionamentos da tabela Paciente: " . print_r($relationships, true));
            
            // Verificar se o paciente existe
            $sql = "SELECT COUNT(*) FROM Paciente WHERE ID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            
            if ($count == 0) {
                error_log("Erro: Paciente com ID " . $id . " não encontrado");
                return false;
            }
            
            // Verificar se há registros relacionados em todas as tabelas
            $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE COLUMN_NAME = 'PacienteID'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $relatedTables = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Tabelas relacionadas com PacienteID: " . print_r($relatedTables, true));
            
            foreach ($relatedTables as $table) {
                $tableName = $table['TABLE_NAME'];
                $sql = "SELECT COUNT(*) FROM " . $tableName . " WHERE PacienteID = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, $id);
                $stmt->execute();
                if ($stmt->fetchColumn() > 0) {
                    error_log("Erro: Paciente com ID " . $id . " tem registros relacionados na tabela " . $tableName);
                    return false;
                }
            }
            
            // Agora tentar excluir
            $sql = "DELETE FROM Paciente WHERE ID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $id);
            
            if ($stmt->execute()) {
                return true;
            } else {
                throw new PDOException("Erro ao executar a exclusão");
            }
        } catch (PDOException $e) {
            error_log("Erro ao excluir paciente ID " . $id . ": " . $e->getMessage());
            return false;
        }
    }
}
?>