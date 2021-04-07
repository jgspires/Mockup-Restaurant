<?php
require_once "../Model/Funcionario.php";

session_start();

$mode = $_GET["mode"];
$funcionario = new Funcionario();

if($mode=="search") {
    $cpf = $_POST["cpf"];
    $pwd = $_POST["func_pwd"];

    $funcionario->setCpf($cpf);
    $funcionario->setPassword($pwd);
    if($funcionario->search()) {
        $_SESSION["user_name"] = $funcionario->getName();
        $_SESSION["user_cpf"] = $funcionario->getCpf();
        if($funcionario->getIs_admin()) {
            $_SESSION['user_type'] = 'admin';
            header('Location: ..\View\cardapio.php');
        }
        else {
            $_SESSION['user_type'] = 'cook';
            header('Location: ..\View\cozinha.php');
        }
        
    }
    else {
        header('Location: ..\View\index.php?login=fail_func');
    }
}
else if($mode == "insert") {
    $name = $_POST["func_name"];
    $cpf = $_POST["func_cpf"];
    $pwd = $_POST["func_pwd"];
    if($_POST['type'] == "admin")
        $funcionario->setIs_admin(1);
    else $funcionario->setIs_admin(0);
    $funcionario->setName($name);
    $funcionario->setCpf($cpf);
    $funcionario->setPassword($pwd);
    if($funcionario->insert()) {
        header('Location:..\View\gerencia.php?add_func=success');
    }
    else
        header('Location:..\View\gerencia.php?add_func=failed');
}

?>