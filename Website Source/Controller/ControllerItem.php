<?php
if(session_status() != 2) // 2 = sessões estão ativas E uma existe. Se não estiver ativa, inicia a sessão.
    session_start();

require_once "../Model/Item.php";
require_once "../Model/Comida.php";
require_once "../Model/Bebida.php";

$mode = $_GET["mode"];

if($mode == "search_all") {
    $item = new Item();
    if($item->search_all()) {
        $arr = $item->getList();
        $tmp = Array(); 
        foreach($arr as $obj){
             $linha;
             if($obj instanceof Comida){
                $linha = Array(
                     "codItem" => $obj->getCode(),
                     "nome" => $obj->getName(),
                     "preco" => $obj->getPrice(),
                     "desc" => $obj->getDesc(),
                     "ingred" => $obj->getIngredients()
                 );
             }
             else if ($obj instanceof Bebida){
                 $linha = Array (
                     "codItem" => $obj->getCode(),
                     "nome" => $obj->getName(),
                     "preco" => $obj->getPrice(),
                     "supplier" => $obj->getSupplier()
                 );
             }   
             array_push($tmp, $linha);
        }
        echo json_encode($tmp);
    }
}
else if($mode == "insert") {
    $tipoItem = $_POST['type'];

    $nome = $_POST['name'];
    $price = $_POST['price'];
    $item =  null;
    if($tipoItem == 'food') {
        $desc = $_POST['desc'];
        $ingredientes = $_POST['ingred'];
        $item = new Comida();
        $item->setDesc($desc);
        $item->setIngredients($ingredientes);
    }
    else if($tipoItem == 'bvg') {
        $supplier = $_POST['supplier'];
        $item = new Bebida();
        $item->setSupplier($supplier);
    }
    $item->setName($nome);
    $item->setPrice($price);
    if($item->insert()) {
        header('Location:..\View\gerencia.php?insert=success');
    }
    else 
        header('Location:..\View\gerencia.php?insert=failed');
    
}

else if($mode == "search_once"){
    //Parametros booleanos devem ser tratados de forma especial, pois todos os parametros GET são String.
    $query = $_GET['query'];
    $isFood = filter_var($_GET['food'],FILTER_VALIDATE_BOOLEAN);
    $isBvg = filter_var($_GET['bvg'],FILTER_VALIDATE_BOOLEAN);

    
    if ($isFood && !$isBvg){
        $item = new Comida();
    }    
    else if($isBvg && !$isFood){
        $item = new Bebida();
    }
    else if ($isFood && $isBvg ){
        $item = new Item();
    }
    else if(!$isFood && !$isBvg){
        echo 0;
        return;
    }

    $item->setName($query);

    if($item->search_once()) {
       $arr = $item->getList();
       $tmp = Array();

       //Eu tive que fazer isso pois o front precisa entender o que vem do back. Para isso eu transformo em json, que é universal.
       //Mas o json não entende objetos com modificador de visibilidade, então é isso.

       foreach($arr as $obj){
            $linha;
            if($obj instanceof Comida){
                $linha = Array(
                    "codItem" => $obj->getCode(),
                    "nome" => $obj->getName(),
                    "preco" => $obj->getPrice(),
                    "desc" => $obj->getDesc(),
                    "ingred" => $obj->getIngredients()
                );
            }
            else if ($obj instanceof Bebida){
                $linha = Array (
                    "codItem" => $obj->getCode(),
                    "nome" => $obj->getName(),
                    "preco" => $obj->getPrice(),
                    "supplier" => $obj->getSupplier()
                );
            }   
            array_push($tmp, $linha);
       }
       echo json_encode($tmp);
    }
}
else if($mode == "update") {
    $type = $_POST['alter_type'];
    if($type == 'food') {
        $item = new Comida();
        $item->setDesc($_POST['alter_desc']);
        $item->setIngredients($_POST['alter_ingred']);
    }
    else if($type == 'beverage') {
        $item = new Bebida();
        $item->setSupplier($_POST['alter_supplier']);
    }
    $item->setCode($_POST['alter_code']);
    $item->setName($_POST['alter_name']);
    $item->setPrice($_POST['alter_price']);
    if($item->update()) {
        header('Location:..\View\gerencia.php?alter=success');
    }
    else
        header('Location:..\View\gerencia.php?alter=failed');
}

else if($mode == "delete") {
    $item = new Item();
    $item->setCode($_GET['id']);
    if($item->delete()) {
        header('Location:..\View\gerencia.php?delete=success');
    }
    else
        echo "Error when trying to connect to database.";
}

?>

