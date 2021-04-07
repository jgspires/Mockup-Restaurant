<?php
    function format_bonus($bonus) {
        $centavos = ($bonus * 100) % 100;
        $reais = $bonus - ($centavos/100);

        if($centavos == 0) {
        $bonus = $reais . ',' . $centavos . '0';
        }
        else if($centavos >= 10) {
        $bonus = $reais . ',' . $centavos;
        }
        else {
            $bonus = $reais . ',0' . $centavos;
        }
        return $bonus;
    }
?>
