<?php
class ClassPaciente {
    private $id;
    private $nome;
    private $email;
    private $cpf;
    private $telefone;
    private $dataDeNascimento;
    private $sexo;
    private $endereco;
    private $cidade;
    private $estado;
    private $cep;
    private $motivoDaConsulta;

    // Getters e setters para todos
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = $nome; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getCpf() { return $this->cpf; }
    public function setCpf($cpf) { $this->cpf = $cpf; }

    public function getTelefone() { return $this->telefone; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }

    public function getDataDeNascimento() { return $this->dataDeNascimento; }
    public function setDataDeNascimento($dataDeNascimento) { $this->dataDeNascimento = $dataDeNascimento; }

    public function getSexo() { return $this->sexo; }
    public function setSexo($sexo) { $this->sexo = $sexo; }

    public function getEndereco() { return $this->endereco; }
    public function setEndereco($endereco) { $this->endereco = $endereco; }

    public function getCidade() { return $this->cidade; }
    public function setCidade($cidade) { $this->cidade = $cidade; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }

    public function getCep() { return $this->cep; }
    public function setCep($cep) { $this->cep = $cep; }

    public function getMotivoDaConsulta() { return $this->motivoDaConsulta; }
    public function setMotivoDaConsulta($motivoDaConsulta) { $this->motivoDaConsulta = $motivoDaConsulta; }
}
?>
