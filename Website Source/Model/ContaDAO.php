<?php
    require_once "ConnectionFactory.php";
    require_once "Conta.php";
    require_once "Bonus.php";
    require_once "BonusDAO.php";
    class ContaDAO {

        public function search_client($bill, $codCliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("select * from Pedidos where codCliente=:codCliente");
                $sql->bindParam("codCliente", $codCliente);

                $sql->execute();
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $bill->setOrders(array());
                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $order = new Pedido();
                    $order->setNum($line['codPedido']);
                    $order->setQty($line['qtd']);
                    $order->setState($line['estado']);
                    $order->setOrderTotal($line['totalPedido']);
                    $order->setTable($line['mesa']);

                    $item = new Item();
                    $item->setCode($line['item']);
                    if(!$item->search_code_order($order))
                        return false;

                    $bill->addOrder($order);
                }
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function pay($bill, $codCliente, $bonus) {
            try {
                if(!$this->search_client($bill, $codCliente))
                    return false;
                $conn = ConnectionFactory::getConnection();
                if(!$bonus->pay_bill($codCliente, $bill))
                    return false;
                $sql = $conn->prepare("update Pedidos set estado=3 where codCliente=:codCliente AND estado=1");
                $sql->bindParam("codCliente", $codCliente);
                $sql->execute();
                $sql = $conn->prepare("delete from Pedidos where codCliente=:codCliente AND estado=2");
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