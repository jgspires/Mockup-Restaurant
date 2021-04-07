<?php
    require_once "ItemDAO.php";
    class Item {
        protected $code;
        protected $name;
        protected $price;
        protected $list = array();

        public function __construct() {
        }

        public function getCode()
        {
            return $this->code;
        }

        public function setCode($code)
        {
            $this->code = $code;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function getPrice()
        {
            return $this->price;
        }

        public function setPrice($price)
        {
            $this->price = $price;
        }

        public function getList()
        {
            return $this->list;
        }

        public function setList($list)
        {
            $this->list = $list;
        }

        public function search_all() {
            $dao = new ItemDAO();
            return $dao->search_all($this);
        }

        public function search_code_order($order) {
            $dao = new ItemDAO();
            return $dao->search_code_order($this, $order);
        }
        public function search_once(){
            $dao = new ItemDao();
            return $dao->search_once($this);
        }
        public function insert() {
            $dao = new ItemDao();
            return $dao->insert($this);
        }
        public function update() {
            $dao = new ItemDao();
            return $dao->update($this);
        }
        public function delete() {
            $dao = new ItemDao();
            return $dao->delete($this);
        }
    }

?>