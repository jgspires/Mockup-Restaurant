<?php
    class ConnectionFactory {
        public static function getConnection() {
            $servername = "localhost:3306";
            $username = "root";
            $password = '';
            $dbname = "bd_restaurante";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "conectado com sucesso!";
                return $conn;
            }
            catch(PDOException $e) {
                echo "Erro na conexão com o banco! Checar ConnectionFactory.php" . $e->getMessage();
                return null;
            }
        }
    }
?>