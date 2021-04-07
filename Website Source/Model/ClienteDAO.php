<?php
    require_once "ConnectionFactory.php";
    require_once "BonusDAO.php";
    require_once "Bonus.php";

    class ClienteDAO {
    
        public function search($cliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("select * from Clientes where cpf=:cpf");
                $cpf = $cliente->getCpf();
                $sql->bindParam("cpf", $cpf);

                $sql->execute();
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $rowCount = 0;

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $rowCount++;
                    $cliente->setCode($line['codCliente']);
                    $cliente->setName($line['nome']);
                    $cliente->setCpf($line['cpf']);
                    $cliente->setEmail($line['email']);
                }
                if(!$rowCount) // Se não houver linhas, retorna falso.
                    return false;
                    
                $codCliente = $cliente->getCode();
                
                $bonus = new Bonus();
                if($bonus->search_client($codCliente))
                    $cliente->setBonus($bonus);
                else
                    return false;

                $bill = new Conta();
                if($bill->search_client($codCliente))
                    $cliente->setBill($bill);
                else
                    return false;

                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function insert($cliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("insert into clientes(nome, cpf, email) VALUES (:name, :cpf, :email)");
                $name = $cliente->getName();
                $cpf = $cliente->getCpf();
                $email = $cliente->getEmail();
                $sql->bindParam("name", $name);
                $sql->bindParam("cpf", $cpf);
                $sql->bindParam("email", $email);

                $sql->execute();
                $last = $conn->lastInsertId();

                $bonus = new Bonus();
                if(!$bonus->insert_client($last)) {
                    $sql = $conn->prepare("delete from clientes where codCliente=:last");
                    $sql->bindParam("last", $last);
                    $sql->execute();
                    return 0;
                }

                $sql = $conn->prepare("update clientes SET bonus=:last where codCliente=:last");
                $sql->bindParam("last", $last);

                $sql->execute();

                return $sql->rowCount();
                
            }
            catch(PDOException $e) {
                return 0;
            }
            $conn = null;
        }

        public function search_all($cliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("select * from Clientes");

                $sql->execute();
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $arr = array();

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $newCliente = new Cliente();
                    $newCliente->setCode($line['codCliente']);
                    $newCliente->setName($line['nome']);
                    $newCliente->setCpf($line['cpf']);
                    $newCliente->setEmail($line['email']);

                    $codNewCliente = $newCliente->getCode();

                    $bonus = new Bonus();
                    if($bonus->search_client($codNewCliente))
                        $newCliente->setBonus($bonus);
                    else
                        return false;

                    array_push($arr, $newCliente);
                }

                $cliente->setList($arr);
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function search_table($cliente) {
            try{              
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("select * from clientes where nome LIKE :nome");
    
                $nome = "%".$cliente->getName()."%";  
                $sql->bindParam("nome",$nome);
                    
                $sql->execute();
                
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $arr = array();

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $newCliente = new Cliente();
                    $newCliente->setCode($line['codCliente']);
                    $newCliente->setName($line['nome']);
                    $newCliente->setCpf($line['cpf']);
                    $newCliente->setEmail($line['email']);

                    $codNewCliente = $newCliente->getCode();

                    $bonus = new Bonus();
                    if($bonus->search_client($codNewCliente))
                        $newCliente->setBonus($bonus);
                    else
                        return false;

                    array_push($arr, $newCliente);
                }

                $cliente->setList($arr);
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;    

        }

        public function delete($cliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("delete from clientes where codCliente=:codCliente");
                $codCliente = $cliente->getCode();
                $sql->bindParam("codCliente", $codCliente);

                $sql->execute();

                $bonus = new Bonus();
                if(!$bonus->delete_client($codCliente))
                    return false;

                return true;
                
            }
            catch(PDOException $e) {
                echo $e->getMessage();
                return false;
            }
            $conn = null;
        }

    }
?>