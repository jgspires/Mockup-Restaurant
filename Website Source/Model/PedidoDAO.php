<?php
    require_once "ConnectionFactory.php";
    require_once "Pedido.php";
    require_once "Item.php";
    class PedidoDAO {
        public function search_open($order) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("SELECT * FROM pedidos WHERE estado=1 OR estado=3"); // estado = 1 significa "em preparo". estado = 3 é "em preparo e pago".
                $sql->execute();
                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $arr = array();
                $rowCount = 0;

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $rowCount++;
                    $newOrder = new Pedido();
                    $newOrder->setNum($line['codPedido']);
                    $newOrder->setQty($line['qtd']);
                    $newOrder->setOrderTotal($line['totalPedido']);
                    $newOrder->setTable($line['mesa']);
                    $newOrder->setState($line['estado']);

                    $item = new Item();
                    $item->setCode($line['item']);
                    if(!$item->search_code_order($newOrder))
                        return false;
                    
                    
                    array_push($arr, $newOrder);
                }
                $order->setList($arr);
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function insert($order, $codCliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("insert into pedidos(item, qtd, estado, totalPedido, codCliente, mesa)
                VALUES (:codItem, :qty, 0, :orderTotal, :codCliente, :table)");
                $codItem = $order->getItem()->getCode();
                $qty = $order->getQty();
                $orderTotal = $order->calcOrderTotal();
                $table = $order->getTable();
                
                $sql->bindParam("codItem", $codItem);
                $sql->bindParam("qty", $qty);
                $sql->bindParam("orderTotal", $orderTotal);
                $sql->bindParam("codCliente", $codCliente);
                $sql->bindParam("table", $table);

                $sql->execute();
                $order->setNum($conn->lastInsertId());

                return $sql->rowCount();
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function delete($order) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("delete from pedidos where codPedido=:num");
                $num = $order->getNum();
                $sql->bindParam("num", $num);

                $sql->execute();

                return $sql->rowCount();
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function finish($order) {
            try {
                if(!$this->search($order))
                    return false;

                $state = $order->getState();
                $conn = ConnectionFactory::getConnection();
                if($state == 1) {
                    $sql = $conn->prepare("update pedidos set estado=2 where codPedido=:num"); // estado = 2 significa "entregue".
                    $num = $order->getNum();
                    $sql->bindParam("num", $num);

                    $sql->execute();
                }
                else if($state == 3) { // caso seja "em preparo e pago", deleta do bd.
                    if(!$this->delete($order))
                        return false;
                }

                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function search($order) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("SELECT * FROM pedidos WHERE codPedido=:num");
                $num = $order->getNum();
                $sql->bindParam("num", $num);
                $sql->execute();

                $result = $sql->setFetchMode(PDO::FETCH_ASSOC);

                while ($line = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $order->setNum($line['codPedido']);
                    $order->setQty($line['qtd']);
                    $order->setOrderTotal($line['totalPedido']);
                    $order->setTable($line['mesa']);
                    $order->setState($line['estado']);

                    $item = new Item();
                    $item->setCode($line['item']);
                    if(!$item->search_code_order($order))
                        return false;
                }
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }

        public function confirm($order, $codCliente) {
            try {
                $conn = ConnectionFactory::getConnection();
                $sql = $conn->prepare("update pedidos set estado=1 where codCliente=:codCliente AND estado=0"); // estado = 1 significa "em preparo".
                $sql->bindParam("codCliente", $codCliente);

                $sql->execute();

                return $sql->rowCount();
            }
            catch(PDOException $e) {
                return false;
            }
            $conn = null;
        }
    }
?>