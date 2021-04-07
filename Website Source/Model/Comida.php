<?php
    require_once "Item.php";
    class Comida extends Item {
        private $desc;
        private $ingredients;

        public function __construct() {
            
        }

        public function getDesc()
        {
            return $this->desc;
        }

        public function setDesc($desc)
        {
            $this->desc = $desc;
        }

        public function getIngredients()
        {
            return $this->ingredients;
        }

        public function setIngredients($ingredients)
        {
            $this->ingredients = $ingredients;
        }
    }

?>