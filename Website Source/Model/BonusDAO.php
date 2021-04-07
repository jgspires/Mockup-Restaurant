<?php
    require_once "ConnectionFactory.php";
    class BonusDAO {

        public function search_client($bonus, $codCliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("select * from Bonus where codCliente=:codCliente");
                $sql->bindParam("codCliente", $codCliente);

                $sql->execute();
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $rowCount = 0;

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $rowCount++;
                    $bonus->setValue($line['valor']);
                    $bonus->setLastReceived($line['ultimoGanho']);
                }
                if(!$rowCount) // Se não houver linhas, retorna falso.
                    return false;
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function insert_client($bonus, $codCliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("insert into bonus VALUES (:codCliente, :value, :lastReceived)");
                $value = $bonus->getValue();
                $lastReceived = $bonus->getLastReceived();
                $sql->bindParam("codCliente", $codCliente);
                $sql->bindParam("value", $value);
                $sql->bindParam("lastReceived", $lastReceived);

                $sql->execute();

                return $sql->rowCount();
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function pay_bill($bonus, $codCliente, $bill) {
            try {
                $resultBonus = $bonus->calcResultBonus($bill->billTotal(), $bill->calcFinalTotal($bonus));
                echo "ResultBonus =" . $resultBonus;
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("update bonus set valor=:resultBonus, ultimoGanho=:date where codCliente=:codCliente");
                $today = date("Y-m-d");
                $sql->bindParam("codCliente", $codCliente);
                $sql->bindParam("resultBonus", $resultBonus);
                $sql->bindParam("date", $today);

                $sql->execute();

                $bonus->setValue($resultBonus);
                $bonus->setLastReceived($today);

                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function delete_client($bonus, $codCliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("delete from bonus where codCliente=:codCliente");
                $sql->bindParam("codCliente", $codCliente);

                $sql->execute();

                return true;
                
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }
    }
?>