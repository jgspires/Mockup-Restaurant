<?php
    require_once "../Model/Bonus.php";
    require_once "../Model/Item.php";
    require_once "../Model/Pedido.php";
    require_once "../Model/Conta.php";
    session_start();
    class viewShared {
        static $type;
        static $user_name;
        static $user_bonus;
        
        public static function init_topbar() {
            self::$type = $_SESSION['user_type'];
            if(self::$type != null) {
                self::$user_name = $_SESSION['user_name'];
                self::format_name(self::$user_name);
                switch(self::$type) {
                    case "client":
                        self::$user_bonus = $_SESSION['user_bonus']->getValue();
                        self::format_money(self::$user_bonus);
                    break;
                    case "admin":
                        self::append_role(self::$user_name, 'Admin');
                    break;

                    case "cook":
                        self::append_role(self::$user_name, 'Cozinha');
                    break;
                }
            }
            else {
                header('Location: ..\View\index.php?login=unauth');
            }
        }

        public static function format_name(&$name) {
            $space_pos = strpos($name, ' ');
            if($space_pos) {
                $name = substr($name, 0, $space_pos);
            }
            $name = $name . "!";
        }

        public static function format_money(&$money) {
            $centavos = ($money * 100) % 100;
            $reais = $money - ($centavos/100);
            $reais = round($reais);

            if($centavos == 0) {
            $money = $reais . ',' . $centavos . '0';
            }
            else if($centavos >= 10) {
            $money = $reais . ',' . $centavos;
            }
            else {
                $money = $reais . ',0' . $centavos;
            }
        }

        public static function append_role(&$name, $role) {
            $name = $name . '<span style="color: rgb(223, 197, 51);"> (' . $role . ') </span>';
        }
    }

?>