<?php
    require_once "Conexao.php";
    try{
        $pdo = Conexao::getInstance();
        if($pdo){
            echo "Conexão Estabelecida com sucesso";
        } else{
            echo " -> Conexão como banco de dados falhou";
        }
    } catch(PDOExcepion $exc){
        echo $exc->getMessage();
    }
?>