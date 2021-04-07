<?php

    class Cardapio {
        private $items = array();
        
        public function __construct() {

        }

        public function getProdutos()
        {
            return $this->produtos;
        }

        public function setProdutos($produtos)
        {
            $this->produtos = $produtos;
        }
    }

?>