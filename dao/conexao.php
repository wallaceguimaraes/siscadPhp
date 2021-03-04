<?php
//Verificação de Segurança precisa ser feita aqui
class conexao {
     //Estes dados devem ser coletados de outro lugar... claro...
    /*
     private static $host = "localhost";
     private static $user = "root";
     private static $password = "";
     private static $database = "banco__siscad";
     private static $charset = "utf8";
     private static $conexao;
*/

     private static $host = "localhost";
     private static $user = "id14289126_wallace";
     private static $password = "Jesuseomeusenhor7*";
     private static $database = "id14289126_siscad";
     private static $charset = "utf8";
     private static $conexao;

    //Esta função retorna uma conexão ativa, ou cria uma conexão nova e retorna a mesma.
     public static function getConnection() {
        if (conexao::$conexao == null) {
            try {
                //connect as appropriate as above
                conexao::$conexao = new PDO("mysql:host=".conexao::$host . ";dbname=" . conexao::$database . ";charset=" . conexao::$charset, conexao::$user, conexao::$password);
                return conexao::$conexao;
            } catch (PDOException $ex) {
                echo "UM ERRO OCORREU NA CONEXÃO COM O BANCO DE DADOS!"; //TODO
            }
        }else{
            return conexao::$conexao;
        }
    }

}