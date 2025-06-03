<?php
    abstract class Conexao{
        public static function getInstance(){
            try{
                $dsn = "mysql:host=localhost;dbname=crud_php_pdo";
                $user = "root";
                $pass = "";
                $pdo = new PDO($dsn, $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch(PDOException $exc){
                echo $exc->getMessage();
            }
        }
    }
?>