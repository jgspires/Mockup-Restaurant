<?php

    class Bonus {
        private $value;
        private $lastReceived;

        public function __construct() {
            $this->value = 0;
            $this->lastReceived = date("Y-m-d");
        }

        public function getValue()
        {
            return $this->value;
        }

        public function setValue($value)
        {
            $this->value = $value;
        }

        public function getLastReceived()
        {
            return $this->lastReceived;
        }

        public function setLastReceived($lastReceived)
        {
            $this->lastReceived = $lastReceived;
        }

        public function canUseBonus() {
            $today = date("Y-m-d");
            return ($today > $this->lastReceived);
        }

        public function calcAwardedBonus($finalTotal) {
            $awardedBonus = $finalTotal * 0.1;
            $awardedBonus = round($awardedBonus, 2);
            return $awardedBonus;
        }
      
        public function calcRemainingBonus($billTotal) {
            $remBonus = $this->value;
            if($this->canUseBonus()) {
                $remBonus -= $billTotal;
                if($remBonus < 0)
                    $remBonus = 0;
            }
            return $remBonus;
        }
      
        public function calcUsedBonus($billTotal) {
        $usedbonus = $this->value;
        if($this->canUseBonus()) {
            if($usedbonus >= $billTotal)
                return $billTotal;
            else
                return $usedbonus;
        }
        else
            return 0;
        }

        public function calcResultBonus($billTotal, $finalTotal) {
            echo "Remaining bonus = " . $this->calcRemainingBonus($billTotal) . "<br>";
            echo "Awarded bonus = " . $this->calcAwardedBonus($finalTotal) . "<br>";
            if($this->canUseBonus()) {
                return $this->calcRemainingBonus($billTotal) + $this->calcAwardedBonus($finalTotal);
            }
            else {
                return $this->value + $this->calcAwardedBonus($finalTotal);
            }

        }

        public function search_client($codCliente) {
            $dao = new BonusDAO();
            return $dao->search_client($this, $codCliente);
        }

        public function insert_client($codCliente) {
            $dao = new BonusDAO();
            return $dao->insert_client($this, $codCliente);
        }

        public function pay_bill($codCliente, $bill) {
            $dao = new BonusDAO();
            return $dao->pay_bill($this, $codCliente, $bill);
        }

        public function delete_client($codCliente) {
            $dao = new BonusDAO();
            return $dao->delete_client($this, $codCliente);
        }
    }

?>