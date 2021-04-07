<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cardápio</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script>
    function toggle() {
      if(document.getElementById("credit").checked) {
        document.getElementById("pay_installmentsDiv").classList.remove("hide");
          
      }
      else
        document.getElementById("pay_installmentsDiv").classList.add("hide");
    }
  </script>

<script type="text/javascript" src="Js/search.js" defer></script>
<script defer src="js/setTable.js"></script>
</head>

<body>
<!--☹️-->
  <?php
    require_once "viewShared.php";
    require_once "../Model/Pedido.php";
    
    viewShared::init_topbar();
    $type = viewShared::$type;
    $user_name = viewShared::$user_name;
    $user_bonus = viewShared::$user_bonus;
    $show_modal = false;
    $active_tab = 0;

    if($_SESSION['user_type'] == "client") {
      $unconfirmedTotal = $_SESSION['user_bill']->unconfirmedTotal();
      $billTotal = $_SESSION['user_bill']->billTotal();
      viewShared::format_money($unconfirmedTotal);
      viewShared::format_money($billTotal);
      $lastReceived = $_SESSION['user_bonus']->getLastReceived();
      if($_SESSION['user_bonus']->canUseBonus()) {
        $bonus = $_SESSION['user_bonus']->getValue();
      }
      else {
        $bonus = 0;
      }
      viewShared::format_money($bonus);
    }
    else {
      $unconfirmedTotal = 0;
      $billTotal = 0;
    }

    if(isset($_GET["add"])) {
      if($_GET["add"] == "success") {
        $show_modal = true;
        $title = "Item(s) adicionado(s) com sucesso!";
        $body = "Não esqueça de confirmar seu pedido quando tiver acabado de escolher seus pratos!";
        $btn = "Beleza!";
      }
    }
    else if(isset($_GET["remove"])) {
      if($_GET["remove"] == "success") {
        $show_modal = true;
        $title = "Item(s) removidos(s) com sucesso!";
        $body = "Não deixe de checar nossos outros pratos!";
        $btn = "Beleza!";
        $active_tab = 1;
      }
    }
    else if(isset($_GET["confirm"])) {
      if($_GET["confirm"] == "success") {
        $show_modal = true;
        $title = "Pedido(s) confirmado(s) com sucesso!";
        $body = "Seus pratos foram mandados para a cozinha e serão entregues em breve!";
        $btn = "Beleza!";
        $active_tab = 0;
      }
    }
    else if(isset($_GET["pay"])) {
      if($_GET["pay"] == "success") {
        $show_modal = true;
        $title = "Pagamento realizado com sucesso!";
        $body = "Obrigado por escolher o Le Bistro!";
        $btn = "Por nada!";
        $active_tab = 0;
      }
    }

    if($show_modal) {
      echo "<script type='text/javascript'>
      $(document).ready(function(){
      $('#resultModal').modal('show');
      });
      </script>";
    }

    function addRowUnconf($order) {
      $num = $order->getNum();
      $item_name = $order->getItem()->getName();
      $qty = $order->getQty();
      $price = $order->getItem()->getPrice();
      viewShared::format_money($price);
      $total = $order->getOrderTotal();
      viewShared::format_money($total);
      echo "
      <tr id='$num'>
      <th id='item_name-$num' scope='row'>$item_name</th>
      <td id='item_qty-$num'>$qty</td>
      <td id='item_price-$num'>R$$price</td>
      <td id='item_total-$num'>R$$total</td>
      <td>
        <span data-toggle='modal' data-target='#excludeModal'>
          <button type='button' class='kitchenbtn btn-cancel' id='delete-$num' onclick=setMenuDeleteLinkId(this.id) data-toggle='tooltip' data-placement='bottom' title='Remover do Pedido'><i class='glyphicon glyphicon-trash'></i></button>
        </span>
      </td>
    </tr>";
    }

    function addRowBill($order) {
      //$num = $order->getNum();
      $item_name = $order->getItem()->getName();
      $qty = $order->getQty();
      $price = $order->getItem()->getPrice();
      viewShared::format_money($price);
      $total = $order->getOrderTotal();
      viewShared::format_money($total);
      echo "
      <tr>
        <th scope='row'>$item_name</th>
        <td>$qty</td>
        <td>R$$price</td>
        <td>R$$total</td>
      </tr>
      ";
    }

    function addUnconfirmedOrdersToTable() {
      $rows_added = 0;
      foreach ($_SESSION['user_bill']->getOrders() as $order) {
        if($order->getState() == 0) {
          addRowUnconf($order);
          $rows_added++;
        }
      }
    }

    function addBillOrdersToTable() {
      $rows_added = 0;
      foreach ($_SESSION['user_bill']->getOrders() as $order) {
        if($order->getState() == 1 || $order->getState() == 2) {
          addRowBill($order);
          $rows_added++;
        }
      }
    }
  ?>

  <!--LOADER DE BUSCA-->
  <div id="load">
    <img src="ring-1.png" class="ring">
  </div>

  <div id="resultModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" style="text-align: center;"><?php echo $title?></h3>
        </div>
        <div class="modal-body" style="text-align: center;">
            <?php echo $body?>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo $btn?></button>
          </div>
        </div>

    </div>
  </div>

  <div id="excludeModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
              <h3 class="modal-title" style="text-align: center;">Confirmar Cancelamento?</h3>
          </div>
          <div class="modal-body">
            <h4 style="text-align: center;">Isso não pode ser desfeito.</h4>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            <a id="delete_link" href="loremIpsum"><button type="button" class="btn btn-cancel">Sim</button></a>
          </div>
          </div>
      </div>
    </div>

  <div id="searchModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title" id="searchModalTitle" style="text-align:center;"> <!--title--></h3>
        </div>
        <div class="modal-body" id="searchModalBody" style="text-align:center;">
             <!--corpo-->
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>

    </div>
  </div>


  <div id="infoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 id="info_modal_title" class="modal-title">Frango Grelhado ao Molho de Limão</h3>
        </div>
        <div class="modal-body">
            <ul class="list-group">
              <li  class="list-group-item"><b>Código: </b><span id="info_modal_code">1</span></li>
              <li class="list-group-item"><b id="info_modal_desc_name">Descrição:</b> <span id="info_modal_desc_text">Deliciosa combinação do seu frango grelhado preferido com um apetitoso molho de limão com temperos tropicais.</span></li>
                <li id="info_modal_ingred_li" class="list-group-item"><b id="info_modal_ingred_name">Ingredientes:</b> <span id="info_modal_ingred_text">Filé de frango, óleo de coco, creme de leite fresco, raspas de limão tahiti, suco de limão, manteiga, açúcar mascavo, sal, vagens.</span></li>
                <li class="list-group-item"><b>Preço: </b><span id="info_modal_price">R$27,50</span></li>
            </ul>
        </div>
        </div>

    </div>
  </div>

  <div id="bonusModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Como Funciona o Bônus?</h3>
        </div>
        <div class="modal-body">
            <p>10% do valor pago em qualquer compra no Le Bistro volta pra você como um bônus!</p>
            <p>Esse bônus é armazenado no seu cadastro e será abatido do valor do próximo consumo, contanto que esse próximo consumo não seja no mesmo dia do último.</p>
        </div>
        </div>

    </div>
  </div>

    <nav class="navbar navbar-inverse" style="border-radius: 0px;">
        <div class="container-fluid stdbgcolor">
          <div class="navbar-header">
            <a class="navbar-brand stdnavcolor" href="#">Le Bistro</a>
          </div>
          <ul class="nav navbar-nav">
            <li class="active"><a href="#" class="stdnavcolor">Home</a></li>
            <?php
              if($type == "admin")
                echo '<li><a href="gerencia.php" class="stdnavcolor">Gerência</a></li>';
              if($type != "client")
                echo '<li><a href="cozinha.php" class="stdnavcolor">Cozinha</a></li>';
            ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><p class="navbar-text stdnavcolor">Olá, <?php echo $user_name?></p>
            <?php
              if($type == 'client')
                echo "<li><p class='navbar-text stdnavcolor'>Bônus: <span style='color: rgb(223, 197, 51);'>R$ $user_bonus</span></p>";
            ?>
            <li data-toggle="modal" data-target="#logoutModal"><a href="#"><span class="glyphicon glyphicon-log-out stdnavcolor"></span> <span class="stdnavcolor">Logout</span></a></li>
          </ul>
        </div>
    </nav>

    <div id="logoutModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
          <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="text-align: center;">Sair?</h3>
            </div>
            <div class="modal-body">
              <h4 style="text-align: center;">Deseja realmente sair da sua conta?</h4>
            </div>
            <div class="modal-footer" style="text-align: center;">
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
              <a href="index.php?login=out" class="btn btn-cancel" style="color: white; text-decoration: none;">Sim</a>
            </div>
          </div>
        </div>
    </div>

    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
          <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="text-align: center;">Quantos Deseja Incluir no Pedido?</h3>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="qty_form" method="POST" action="../Controller/ControllerPedido.php?mode=insert">
                <div class="form-group">
                  <div class="col-sm-2 col-xs-2">
                    <input style="margin-left: 250px" type="number" class="form-control" required id="add_qty" name="add_qty" value="1" min="1" max="20" placeholder="Insira a quantidade" >
                    <input type="hidden" id="add_code" name="add_code" value="-1">
                  </div>
                </div>
                </div>
                    <div class="modal-footer" style="text-align: center;">
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-10">
                              <button type="button" class="btn" data-dismiss="modal">Voltar</button>
                              <button type="submit" class="btn btn-success" style="color:white">Adicionar</button>
                            </div>
                          </div>
                    </div>
                </form>
          </div>
        </div>
    </div>

    <div class="container">
      <ul class="nav nav-tabs">
        <li 
        <?php 
        if($active_tab == 0)
          echo "class='active'";
        ?>
        ><a data-toggle="tab" class="stdtxtcolor" href="#menu">Cardápio</a></li>
        <li
        <?php 
        if($active_tab == 1)
          echo "class='active'";
        ?>
        ><a data-toggle="tab" class="stdtxtcolor" href="#placeOrder">Confirmar Pedido</a></li>
        <li
        <?php 
        if($active_tab == 2)
          echo "class='active'";
        ?>
        ><a data-toggle="tab" class="stdtxtcolor" href="#pay">Conta</a></li>
      </ul>

      <div class="tab-content"> <!-- in active -->
        <div id="menu" class="tab-pane fade 
          <?php 
            if($active_tab == 0)
              echo "in active";
          ?>"
        >
            <h3 style="font-weight:bold">Cardápio</h3>
            <div class="form-group has-feedback">
              <label class="control-label col-sm-1" for="inputSuccess" style="padding-top: 7px;">
              Busca:</label>
              <div class="col-sm col-sm-11">
                <input type="text" class="form-control" id="inputSuccess">
                <span class="glyphicon glyphicon-search form-control-feedback" style="text-align: left;  margin-right: 5px;"></span>
              </div>
            </div>

            <div class="checkbox">
                <div class="col-sm-offset-1 col-sm-10" style="margin-top: 10px; margin-bottom: 10px">
                  <label><input checked type="checkbox" value="" id="chkbox_food">Comidas</label>
                  <label style="padding-left: 40px;"><input checked type="checkbox" value="" id="chkbox_beverage">Bebidas</label>
                </div>
              </div>
    
            <div class="container" style="padding-top: 50px;">
              <div class="row">
                <div class="col-12" style="margin-right: 31px;">
                  <table class="table table-bordered">
                    <thead style="background-color: #460202;color: white;">
                      <tr>
                        <th scope="col">Produto</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Ações</th>
                      </tr>
                    </thead>
                    <tbody id="searchTable">
                    <!-- inicio do corpo-->
                      
                    <!-- fim do corpo -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
        </div>
        <div id="placeOrder" class="tab-pane fade
          <?php 
            if($active_tab == 1)
              echo "in active";
          ?>">
          <h3 style="font-weight:bold">Confirmar Pedido</h3>
          <div class="container">
            <div class="row">
              <div class="col-12" style="margin-right: 31px;">
                <?php 
                if($_SESSION['user_type'] == "client" && $_SESSION["user_bill"]->countUnconfirmedOrders() > 0) {
                  ?>
                <table class="table table-bordered">
                  <thead style="background-color: #460202;color: white;">
                    <tr>
                      <th scope="col">Produto</th>
                      <th scope="col">Quantidade</th>
                      <th scope="col">Preço</th>
                      <th scope="col">Total</th>
                      <th scope="col">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Conteúdo da tabela de pedidos a confirmar -->
                    <?php
                        addUnconfirmedOrdersToTable();
                    ?>
                  </tbody>
                </table>
                <?php } ?>
              </div>
            </div>
          </div>
          <h3 style="margin-top:0px">
          <?php 
            if($_SESSION["user_type"] == "client" && $_SESSION["user_bill"]->countUnconfirmedOrders() > 0) {
              echo "Subtotal do pedido: R$" . $unconfirmedTotal;
            }
            else {
              echo "Você não tem pedidos a confirmar! ";
            }
          ?></h3>
          <span style="font-size: 17px">Os pedidos confirmados aqui serão adicionados à sua conta e serão levados à cozinha para preparo!</span>
          <div style="text-align: center;">
            <?php
              if($_SESSION["user_type"] == "client" && $_SESSION["user_bill"]->countUnconfirmedOrders() > 0) {
            ?>
              <a class="btn btn-finish" href="../Controller/ControllerPedido.php?mode=confirm" style="margin-top: 25px;">Confirmar Pedido!</a>
            <?php } ?>
            <!--<button type="button" class="btn btn-finish" style="margin-top: 25px;">Confirmar Pedido!</button> -->
          </div>
        </div>
        <div id="pay" class="tab-pane fade
        <?php 
            if($active_tab == 2)
              echo "in active";
        ?>">
          <h3 style="font-weight: bold;">Conta</h3>
          <form class="form-horizontal" method="POST" action="../Controller/ControllerConta.php?mode=pay">
            <?php 
              if($_SESSION['user_type'] == "client" && $_SESSION["user_bill"]->countConfirmedOrders() > 0) {
            ?>
            <table class="table table-bordered">
              <thead style="background-color: #460202;color: white;">
                <tr>
                  <th scope="col">Produto</th>
                  <th scope="col">Quantidade</th>
                  <th scope="col">Preço</th>
                  <th scope="col">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  addBillOrdersToTable();
                ?>
                <!-- Corpinho da tabela --->
              </tbody>
            </table>
            <?php } ?>
            <?php 
            if($_SESSION['user_type'] == "client" && !$_SESSION['user_bonus']->canUseBonus()  && $_SESSION["user_bill"]->countConfirmedOrders() > 0 && $_SESSION['user_bonus']->getValue() > 0)
              echo "<h5 style='color: #ff0000; margin-top: -10px; margin-bottom: 20px; text-align:right;'><b>Você não pode utilizar seu bônus porque seu último pagamento foi feito hoje!</b></h5>";
            else if($_SESSION['user_type'] == "client" && $_SESSION["user_bill"]->countConfirmedOrders() > 0 && $_SESSION['user_bonus']->getValue() == 0)
              echo "<h5 style='color: #ff0000; margin-top: -10px; margin-bottom: 20px; text-align:right;'><b>Você não possui bônus.</b></h5>";
            ?>
            <?php 
              if($_SESSION['user_type'] == "client" && $_SESSION["user_bill"]->countConfirmedOrders() > 0) {
            ?>
            <h4 style="margin-top:-10px; text-align:right;">Subtotal: R$ <?php echo $billTotal;?></h4>
            <h4 style="margin-top:-10px; text-align:right;">Bônus Disponível (Desconto): - R$ <?php $usedBonus = $_SESSION['user_bonus']->calcUsedBonus($_SESSION['user_bill']->billTotal()); viewShared::format_money($usedBonus); echo $usedBonus;?></h4>
            <h4 style="margin-top: 10px; text-align:right;">Total Final: <?php $ft = $_SESSION['user_bill']->calcFinalTotal($_SESSION['user_bonus']); viewShared::format_money($ft); echo $ft;?></h4>
            <h4 style="margin-top: 10px; text-align:right;">Bônus Restante (Pós Pagamento): R$ <?php $remBonus = $_SESSION['user_bonus']->calcRemainingBonus($_SESSION['user_bill']->billTotal()); viewShared::format_money($remBonus); echo $remBonus;?></h4>
            <h4 style="margin-top: -10px; text-align:right;">
              <span data-toggle="modal" data-target="#bonusModal">
                <i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Detalhes"></i>
              </span>
              Bônus Adquirido (Pós Pagamento): R$<?php $awardedBonus = $_SESSION['user_bonus']->calcAwardedBonus($_SESSION['user_bill']->calcFinalTotal($_SESSION['user_bonus'])); viewShared::format_money($awardedBonus); echo $awardedBonus;?></h4>

            <h3 style="font-weight: bold;">Pagamento</h3>
            <span style="font-size:17px">Ao realizar o pagamento, sua conta será fechada e o bônus adquirido será adicionado ao seu cadastro.</span>

            <div class="form-group">
              <label class="control-label col-sm-2">Tipo:</label>
              <label class="radiobtn"><input type="radio" name="pay_Method" checked id="credit" onclick=toggle()><span class="radiolbl">Crédito</span></label>
              <label class="radiobtn"><input type="radio" name="pay_Method" id="debit" onclick=toggle()> <span class="radiolbl">Débito</span></label>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="pay_cardNumber">Número do Cartão:</label>
              <div class="col-sm-10 nospinner">
                <input style="-webkit-appearance: none;margin: 0;-moz-appearance: textfield;" type="text" class="form-control" required id="pay_cardNumber" name="pay_cardNumber" placeholder="Insira o número do seu cartão" pattern="([0-9]{16})" title="Favor inserir dezesseis dígitos numéricos">
              </div>
            </div>
  
            <div class="form-group" style="margin-right: 0;">
              <label class="control-label col-sm-2" for="pay_holder">Titular do Cartão:</label>
              <div class="col-sm-10" style="padding-right: 0px;">
                <input type="text" class="form-control" required id="pay_holder" name="pay_holder" placeholder="Insira o nome do titular, como escrito no cartão">
              </div>
            </div>

            <div class="form-group" style="margin-right: 0;">
              <label class="control-label col-sm-2" for="pay_cvv">CVV:</label>
              <div class="col-sm-10 nospinner" style="padding-right: 0px;">
                <input type="text" class="form-control" required id="pay_cvv" name="pay_cvv" placeholder="Insira o CVV de seu cartão, geralmente localizado na parte de trás" pattern="([0-9]{3})" title="Favor inserir no formato: 'XXX'">
              </div>
            </div>

            <div class="form-group" style="margin-right: 0;" id="pay_installmentsDiv">
              <label class="control-label col-sm-2" for="pay_installments">Parcelas:</label>
              <div class="col-sm-10" style="padding-right: 0px;">
                <select class="form-control" required>
                <?php 
                  $bTotalValue = $_SESSION['user_bill']->calcFinalTotal($_SESSION['user_bonus']);
                  if($bTotalValue > 10) {
                    for($i = 1; $i <= 6; $i++) {
                      $instalment = ($bTotalValue/$i);
                      $instalment = round($instalment, 2);
                      viewShared::format_money($instalment);
                      echo "<option>$i" . "x de $instalment (sem juros)</option>";
                    }
                  }
                  else {
                    viewShared::format_money($bTotalValue);
                    echo "<option>1x de $bTotalValue (sem juros)</option>";
                  }
                ?>
                </select>  
              </div>
            </div>

            <div class="form-group" style="text-align: center;">
              <div class="col-sm-offset-1 col-sm-10">
                <button type="submit" class="btn btn-finish" style="color: white;margin-top:10px">Realizar Pagamento</button>
              </div>
            </div>
            <?php }
            else {
              echo "<h3 style='margin-top:0px;'>Sua conta está vazia no momento.</h3>";
              echo "<h1 style='text-align:center'><b>☹️</b></h1>";
            }
            ?>
        </div>
      </div>

    </div>

    <!-- JQuery para personalizar devidamente as tooltips dos botões. -->
    <script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });
    </script>

</body>
</html>