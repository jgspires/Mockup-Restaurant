<?php
    require_once "Pedido.php";
    require_once "ContaDAO.php";
    class Conta {
        private $orders = array();

        public function __construct() {
        }

        public function billTotal() {
            $total = 0;
            foreach ($this->orders as $order) {
                if($order->getState() != 0 && $order->getState() != 3) {
                    $total += $order->getOrderTotal();
                }
            }
            return $total;
        }

        function calcFinalTotal($bonus) {
            $bTotal = $this->billTotal();
            $finalTotal = $this->billTotal();
            if($bonus->canUseBonus()) {
                $bonusValue = $bonus->getValue();
                if($bonusValue >= $bTotal) {
                $finalTotal = 0;
                }
                else {
                $finalTotal = $bTotal - $bonusValue;
                }
            }
            return $finalTotal;
        }

        public function countConfirmedOrders() {
            $total = 0;
            foreach ($this->orders as $order) {
                if($order->getState() != 0 && $order->getState() != 3) {
                    $total++;
                }
            }
            return $total;
        }

        public function unconfirmedTotal() {
            $total = 0;
            foreach ($this->orders as $order) {
                if($order->getState() == 0) {
                    $total += $order->getOrderTotal();
                }
            }
            return $total;
        }

        public function countUnconfirmedOrders() {
            $total = 0;
            foreach ($this->orders as $order) {
                if($order->getState() == 0) {
                    $total++;
                }
            }
            return $total;
        }

        public function getOrders()
        {
            return $this->orders;
        }

        public function setOrders($orders)
        {
            $this->orders = $orders;
        }

        public function addOrder($order) {
            array_push($this->orders, $order);
        }

        public function removeOrderWithId($order_id) {
            foreach ($this->orders as $i => $order) {
                if($order->getNum() == $order_id) {
                    unset($this->orders[$i]);
                    array_values($this->orders);
                    break;
                }
            }
        }

        public function search_client($codCliente) {
            $dao = new ContaDAO();
            return $dao->search_client($this, $codCliente);
        }

        public function pay($codCliente, $bonus) {
            $dao = new ContaDAO();
            return $dao->pay($this, $codCliente, $bonus);
        }
    }

?>