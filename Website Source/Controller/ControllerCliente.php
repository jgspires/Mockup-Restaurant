<?php
require_once "../Model/Cliente.php";
require_once "../Model/Bonus.php";

session_start();

$mode = $_GET["mode"];
$cliente = new Cliente();

if($mode=="search") {
    $cpf = $_POST["cpf"];

    $cliente->setCpf($cpf);
    if($cliente->search()) {
        $_SESSION["user_code"] = $cliente->getCode();
        $_SESSION["user_name"] = $cliente->getName();
        $_SESSION["user_cpf"] = $cliente->getCpf();
        $_SESSION["user_email"] = $cliente->getEmail();
        $_SESSION["user_bill"] = $cliente->getBill();
        $_SESSION["user_bonus"] = $cliente->getBonus();
        $_SESSION['user_table'] = $_POST["login_table"];
        $_SESSION['user_has_to_pay'] = 0;
        $_SESSION["user_type"] = 'client';

        header('Location: ..\View\cardapio.php');
    }
    else {
        header('Location: ..\View\index.php?login=fail');
    }
}

else if($mode == "insert") {
    $cpf = $_POST["cpf"];
    $cliente->setCpf($cpf);

    if(!$cliente->search()) { // Se o CPF já não estiver cadastrado, prosseguir com o cadastro.
        $name = $_POST["name"];
        $email = $_POST["email"];
        $cliente->setName($name);
        $cliente->setEmail($email);
        if($cliente->insert()) {
            header('Location: ..\View\index.php?register=success');
        }
        else {
            header('Location: ..\View\index.php?register=fail');
        }
        
    }
    else {
        header('Location: ..\View\index.php?register=exists');
    }
}
else if($mode == "search_all") {
    if($cliente->search_all()) {
        $arr = $cliente->getList();
        $tmp = Array(); 
        foreach($arr as $obj){
                 $linha = Array (
                     "codCliente" => $obj->getCode(),
                     "nome" => $obj->getName(),
                     "cpf" => $obj->getCpf(),
                     "email" => $obj->getEmail(),
                     "bonus_value" => $obj->getBonus()->getValue(),
                     "bonus_lastReceived" => $obj->getBonus()->getLastReceived()
                 ); 
             array_push($tmp, $linha);
        }
        echo json_encode($tmp);
    }
}
else if($mode == "search_table") {
    $query = $_GET['query'];
    $cliente->setName($query);
    if($cliente->search_table()) {
        $arr = $cliente->getList();
        $tmp = Array(); 
        foreach($arr as $obj){
                 $linha = Array (
                     "codCliente" => $obj->getCode(),
                     "nome" => $obj->getName(),
                     "cpf" => $obj->getCpf(),
                     "email" => $obj->getEmail(),
                     "bonus_value" => $obj->getBonus()->getValue(),
                     "bonus_lastReceived" => $obj->getBonus()->getLastReceived()
                 ); 
             array_push($tmp, $linha);
        }
        echo json_encode($tmp);
    }
}
else if($mode == "delete") {
    $cliente->setCode($_GET['id']);
    if($cliente->delete()) {
        header('Location:..\View\gerencia.php?delete_costumer=success');
    }
    //else
        //header('Location:..\View\gerencia.php?delete_costumer=failed');
}

?>