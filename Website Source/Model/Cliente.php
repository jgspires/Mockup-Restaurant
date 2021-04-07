<?php
    require_once "Bonus.php";
    require_once "Conta.php";
    require_once "ClienteDAO.php";

    class Cliente {
        private $code;
        private $name;
        private $cpf;
        private $email;
        private $bonus;
        private $bill;
        private $list = array();

        public function __construct() {
            $this->bonus = new Bonus();
            $this->bill = new Conta();
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

        public function getCpf()
        {
            return $this->cpf;
        }

        public function setCpf($cpf)
        {
            $this->cpf = $cpf;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function getBonus()
        {
            return $this->bonus;
        }

        public function setBonus($bonus)
        {
            $this->bonus = $bonus;
        }

        public function getBill()
        {
            return $this->bill;
        }

        public function setBill($bill)
        {
            $this->bill = $bill;
        }

        public function getList()
        {
            return $this->list;
        }

        public function setList($list)
        {
            $this->list = $list;
        }

        public function search() {
            $dao = new ClienteDAO();
            return $dao->search($this);
        }

        public function insert() {
            $dao = new ClienteDAO();
            return $dao->insert($this);
        }

        public function search_all() {
            $dao = new ClienteDAO();
            return $dao->search_all($this);
        }

        public function search_table() {
            $dao = new ClienteDAO();
            return $dao->search_table($this);
        }
        public function delete() {
            $dao = new ClienteDAO();
            return $dao->delete($this);
        }
    }

?>