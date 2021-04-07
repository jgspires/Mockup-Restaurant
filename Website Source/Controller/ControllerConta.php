<?php
require_once "../Model/Conta.php";
require_once "../Model/Bonus.php";

session_start();

$mode = $_GET["mode"];
$bill = new Conta();

if($mode=="pay") {
    if($_SESSION['user_type'] == 'client') {
        $bonus = $_SESSION["user_bonus"];
        $codCliente = $_SESSION["user_code"];
        if($bill->pay($codCliente, $bonus)) {
            $_SESSION['user_bill']->search_client($codCliente);
            $_SESSION["user_bonus"] = $bonus;
            header('Location: ..\View\cardapio.php?pay=success');
            
        }
        else echo "Error when trying to connect to database.";
    }
    else {
        header('Location: ..\View\cardapio.php');
    }     
}
?>