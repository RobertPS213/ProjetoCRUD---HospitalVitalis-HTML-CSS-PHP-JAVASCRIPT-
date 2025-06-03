<?php
    class ClassRecepcionista
    {
        private $id;
        private $codigo;
        private $nome;
        private $senha;
        public function getId(){
            return $this->id;
        }
        public function getCodigo(){
            return $this->codigo;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getSenha(){
            return $this->senha;
        }
        public function setId($id){
            $this->id = $id;
        }
        public function setCodigo($codigo){
            $this->codigo = $codigo;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }
        public function setSenha($senha){
            $this->senha = $senha;
        }
    }
?>