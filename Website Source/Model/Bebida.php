<?php
    require_once "Item.php";
    class Bebida extends Item {
        private $supplier;

        public function __construct() {
            // parent::__construct($code, $name, $price);
            // $this->supplier = $supplier;
        }

        public function getSupplier()
        {
            return $this->supplier;
        }

        public function setSupplier($supplier)
        {
            $this->supplier = $supplier;
        }
    }

?>