<?php
	require_once "FuncionarioDAO.php";
    class Funcionario {
        private $cpf;
        private $name;
		private $password;
		private $is_admin;

        public function __construct() {
        }

		public function getCpf()
		{
			return $this->cpf;
		}

		public function setCpf($cpf)
		{
			$this->cpf = $cpf;
		}

		public function getName()
		{
			return $this->name;
		}

		public function setName($name)
		{
			$this->name = $name;
		}

		public function getPassword()
		{
			return $this->password;
		}

		public function setPassword($password)
		{
			$this->password = $password;
		}

		public function getIs_admin()
		{
			return $this->is_admin;
		}

		public function setIs_admin($is_admin)
		{
			$this->is_admin = $is_admin;
		}

		public function search() {
            $dao = new FuncionarioDAO();
            return $dao->search($this);
		}
		
		public function insert() {
            $dao = new FuncionarioDAO();
            return $dao->insert($this);
        }
    }

?>