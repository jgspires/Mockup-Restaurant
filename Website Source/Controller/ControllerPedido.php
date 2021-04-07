<?php
require_once "../Model/Pedido.php";
require_once "../Model/Item.php";
require_once "../Model/Conta.php";

if(session_status() != 2) // 2 = sessões estão ativas E uma existe. Se não estiver ativa, inicia a sessão.
    session_start();

/** Se "mode" estiver vazio, padroniza para search_open. Uma vez que esse código é executado sempre que cozinha.php é carregado.
  * Não é a melhor maneira de implementar, mas é a mais simples. */
if(!empty($_GET["mode"]))
    $mode = $_GET["mode"];

$order = new Pedido();

if(empty($_GET["mode"]) || $mode == "search_open") {
    if($order->search_open()) {
      $_SESSION['open_orders'] = $order->getList();
    }
}
else if($mode == "insert") {
    if($_SESSION['user_type'] == 'client') {
      $item = new Item(); // O item pertencente ao pedido que será adicionado.
      $bill = $_SESSION["user_bill"];
      $item->setCode($_POST["add_code"]);
      $codCliente = $_SESSION["user_code"];
      $table = $_SESSION['user_table'];

      if($item->search_code_order($order)) {
        $order->setTable($table);
        $order->setQty($_POST["add_qty"]);
        if($order->insert($codCliente, $table)) {
          $bill->addOrder($order);
          $_SESSION["user_bill"] = $bill;
          header('Location: ..\View\cardapio.php?add=success');
        }
      }
      else {
        echo "Error while trying to acquire item from database.";
      }
  }
  else
    header('Location: ..\View\cardapio.php');
}
else if($mode == "delete_kitchen") {
  $order->setNum($_GET["id"]);
  if($order->delete()) {
    delete_open_order_from_session($order->getNum());
    header('Location: ..\View\cozinha.php');
  }
  else
    echo "Error when trying to connect to database.";
}
else if($mode == "delete_menu") {
  $order->setNum($_GET["id"]);
  if($order->delete()) {
    $_SESSION["user_bill"]->removeOrderWithId($order->getNum());
    header('Location: ..\View\cardapio.php?remove=success');
  }
  else
    echo "Error when trying to connect to database.";
}
else if($mode == "finish") { // Entregar Pedido
  $order->setNum($_GET["id"]);
  if($order->finish()) {
    delete_open_order_from_session($order->getNum());
    header('Location: ..\View\cozinha.php');
  }
  else
    echo "Error when trying to connect to database.";
}
else if($mode == "confirm") {
  if($_SESSION['user_type'] == 'client') {
    $codCliente = $_SESSION["user_code"];
    if($order->confirm($codCliente)) {
      foreach($_SESSION['user_bill']->getOrders() as $i => $order) {
        if($order->getState() == 0) {
          $order->setState(1);
        }
      }
      header('Location: ..\View\cardapio.php?confirm=success');
    }
    else
      echo "Error when trying to connect to database.";
  }
  else {
    header('Location: ..\View\cardapio.php');
  }
}
function delete_open_order_from_session($num) {
  foreach($_SESSION['open_orders'] as $i => $order) {
    if($order->getNum() == $num) {
      unset($_SESSION['open_orders'][$i]);
      array_values($_SESSION['open_orders']);
    }
  }
}

?>