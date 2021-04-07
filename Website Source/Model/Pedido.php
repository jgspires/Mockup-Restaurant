<?php
    require_once "PedidoDAO.php";
    class Pedido {
        private $num;
        private $item;
        private $qty;
        private $orderTotal;
        private $state = 0; // 0 - Não confirmado; 1 - Em preparo; 2 - Entregue; 3 - em preparo e pago.
        private $table;
        private $list = array();

        public function __construct() {
        }

        public function getNum()
        {
            return $this->num;
        }

        public function setNum($num)
        {
            $this->num = $num;
        }

        public function getItem()
        {
            return $this->item;
        }

        public function setItem($item)
        {
            $this->item = $item;
        }

        public function getQty()
        {
            return $this->qty;
        }

        public function setQty($qty)
        {
            $this->qty = $qty;
        }

        public function getOrderTotal()
        {
            return $this->orderTotal;
        }

        public function setOrderTotal($orderTotal)
        {
            $this->orderTotal = $orderTotal;
        }

        public function calcOrderTotal() {
            $total = $this->qty * $this->item->getPrice();
            $this->orderTotal = $total;
            return $total;
        }

        public function getState()
        {
            return $this->state;
        }

        public function setState($state)
        {
            $this->state = $state;
        }

        public function getTable()
        {
            return $this->table;
        }

        public function setTable($table)
        {
            $this->table = $table;
        }

        public function getList()
        {
            return $this->list;
        }

        public function setList($list)
        {
            $this->list = $list;
        }

        public function search_open() {
            $dao = new PedidoDAO();
            return $dao->search_open($this);
        }

        public function insert($codCliente) {
            $dao = new PedidoDAO();
            return $dao->insert($this, $codCliente);
        }

        public function delete() {
            $dao = new PedidoDAO();
            return $dao->delete($this);
        }

        public function finish() {
            $dao = new PedidoDAO();
            return $dao->finish($this);
        }

        public function confirm($codCliente) {
            $dao = new PedidoDAO();
            return $dao->confirm($this, $codCliente);
        }
    }

?>