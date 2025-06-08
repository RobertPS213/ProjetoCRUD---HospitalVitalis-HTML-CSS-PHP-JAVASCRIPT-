<?php
    require_once "Conexao.php";
    try{
        $pdo = Conexao::getInstance();
        if($pdo){
            echo "Conexão estabelecida com sucesso!";
        } else{
            echo "Conexão falhou";
        }
    } catch(PDOException $exc){
        echo $exc-getMessage();
    }
?>