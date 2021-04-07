<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cozinha</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script defer src="js/setTable.js"></script>
</head>

<body>
  <?php
    require_once "viewShared.php";
    require_once "../Controller/ControllerPedido.php";
    require_once "../Model/Comida.php";
    require_once "../Model/Bebida.php";
    viewShared::init_topbar();
    $type = viewShared::$type;
    $user_name = viewShared::$user_name;
    $user_bonus = viewShared::$user_bonus;
    if($type == 'client')
      header('Location: ..\View\index.php?login=unauth');

    function addRow($order) {
      $num = $order->getNum();
      $qty = $order->getQty();
      $item = $order->getItem();
      $item_name = $order->getItem()->getName();
      if($item instanceof Comida) {
        $item_desc = $order->getItem()->getDesc();
        $item_ingred = $order->getItem()->getIngredients();
      }
      else if($item instanceof Bebida) {
        $item_sup = $order->getItem()->getSupplier();
      }
      $table = $order->getTable();
      echo "
      <tr name=$num id=$num>
        <th scope='row'>$qty</th>
        <td id='item_name-$num'>$item_name</td>";
        if($item instanceof Comida) {
          echo "<td id='item_type-$num' hidden>1</td>";
          echo "<td id='item_desc-$num' hidden>$item_desc</td>";
          echo "<td id='item_ingred-$num' hidden>$item_ingred</td>";
        }
        else if($item instanceof Bebida) {
          echo "<td id='item_type-$num' hidden>2</td>";
          echo "<td id='item_sup-$num' hidden>$item_sup</td>";
        }
        echo "<td>$table</td>
        <td>
          <span data-toggle='modal' data-target='#infoModal'>
              <button type='button' name='info-$num' id='info-$num' class='kitchenbtn btn-info' onclick=setInfoTextKitchen(this.id) data-toggle='tooltip' data-placement='bottom' title='Detalhes'><i class='glyphicon glyphicon-info-sign'></i></button>
          </span>
          <a href='../Controller/ControllerPedido.php?mode=finish&id=$num'><button type='button' class='kitchenbtn btn-success' data-toggle='tooltip' data-placement='bottom' title='Finalizar'><i class='glyphicon glyphicon-ok-sign'></i></button></a>
          <span data-toggle='modal' data-target='#excludeModal'>
            <button type='button' name='cancel-$num' id='cancel-$num' onclick=setKitchenDeleteLinkId(this.id) class='kitchenbtn btn-cancel' data-toggle='tooltip' data-placement='bottom' title='Cancelar'><i class='glyphicon glyphicon-trash'></i></button>
          </span>
        </td>
      </tr>
      <tr>";
    }

    function addOpenOrdersToTable() {
      foreach ($_SESSION['open_orders'] as $order) {
        addRow($order);
      }
    }
  ?>
    <nav class="navbar navbar-inverse" style="border-radius: 0px;">
        <div class="container-fluid stdbgcolor">
          <div class="navbar-header">
          <?php
              if($type == "admin") {
                echo '<a class="navbar-brand stdnavcolor" href="cardapio.php">Le Bistro</a>';
              }
              else
                echo '<a class="navbar-brand stdnavcolor" href="#">Le Bistro</a>';
          ?>
            
          </div>
          <ul class="nav navbar-nav">
          <?php
              if($type == "admin") {
                echo '<li><a href="cardapio.php" class="stdnavcolor">Home</a></li>';
                echo '<li><a href="gerencia.php" class="stdnavcolor">Gerência</a></li>';
              }
          ?>
            <li class="active"><a href="#" class="stdnavcolor">Cozinha</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><p class="navbar-text stdnavcolor">Olá, <?php echo $user_name?></p>
            <li data-toggle="modal" data-target="#logoutModal"><a href="#"><span class="glyphicon glyphicon-log-out stdnavcolor"></span> <span class="stdnavcolor">Logout</span></a></li>
          </ul>
        </div>
    </nav>

    <!-- Modal 
        No produto final, haverá somente uma modal, cujo conteúdo será dinamicamente alterado a depender do pedido selecionado.
        Uma segunda modal foi criada abaixo para fins de demonstração, ela será removida no produto final.
        A segunda modal foi implementada aqui porque é relativamente simples e representa a diferença entre comida e bebida nos detalhes do pedido. -->
    <div id="infoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 id="info_modal_title" class="modal-title">lorem</h3>
        </div>
        <div class="modal-body">
            <ul class="list-group">
                <li class="list-group-item"><b id="info_modal_desc_name">Descrição:</b> <span id="info_modal_desc_text">Deliciosa combinação do seu frango grelhado preferido com um apetitoso molho de limão com temperos tropicais.</span></li>
                <li id="info_modal_ingred_li" class="list-group-item"><b id="info_modal_ingred_name">Ingredientes:</b> <span id="info_modal_ingred_text">Filé de frango, óleo de coco, creme de leite fresco, raspas de limão tahiti, suco de limão, manteiga, açúcar mascavo, sal, vagens.</span></li>
            </ul>
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

      <div class="container">
        <h1>Cozinha</h1>
        <h3>Pedidos em Aberto</h3>
        <div class="container">
            <div class="row">
              <div class="col-12">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Quantidade</th>
                      <th scope="col">Pedido</th>
                      <th scope="col">Mesa</th>
                      <th scope="col">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Aqui serão inseridas as linhas da tabela dinamicamente, conforme resgatadas do BD. -->
                    <?php
                      addOpenOrdersToTable();
                    ?>
                  </tbody>
                </table>
              </div>
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