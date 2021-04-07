<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Gerência</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="Js/search.js?ver=1.0" defer></script>
  <script defer src="js/setTable.js?ver=1.0"></script>
</head>

<body>
  <?php
    require_once "viewShared.php";
    viewShared::init_topbar();
    $type = viewShared::$type;
    $user_name = viewShared::$user_name;
    $user_bonus = viewShared::$user_bonus;
    $active_tab = 0;

    if($type != 'admin')
      header('Location: ..\View\index.php?login=unauth');
    
    $show_modal = false;
    if(isset($_GET['insert'])) {
      if($_GET['insert'] == 'success'){
        $show_modal = true;
        $title = "Item inserido!";
        $body = "O item foi inserido com sucesso!";
        $color = "success";
        $btn = "Okay";
      }
      else if($_GET['insert'] == 'failed') {
        $show_modal = true;
        $title = "Item não inserido!";
        $body = "Falha ao inserir um item!";
        $color = "cancel";
        $btn = "Okay";
      }
    }

    if(isset($_GET['alter'])) {
      $active_tab = 1;
      if($_GET['alter'] == 'success'){
        $show_modal = true;
        $title = "Item alterado!";
        $body = "O item foi alterado com sucesso!";
        $color = "success";
        $btn = "Okay";
      }
      else if($_GET['alter'] == 'failed') {
        $show_modal = true;
        $title = "Item não alterado!";
        $body = "Falha ao alterar o item!";
        $color = "cancel";
        $btn = "Okay";
      }
    }

    if(isset($_GET['delete'])) {
      $active_tab = 1;
      if($_GET['delete'] == 'success'){
        $show_modal = true;
        $title = "Item removido";
        $body = "O item foi removido com sucesso!";
        $color = "success";
        $btn = "Okay";
      }
      else if($_GET['delete'] == 'failed') {
        $show_modal = true;
        $title = "Item não removido!";
        $body = "Falha ao remover o item!";
        $color = "cancel";
        $btn = "Okay";
      }
    }

    if(isset($_GET['delete_costumer'])) {
      $active_tab = 1;
      if($_GET['delete_costumer'] == 'success'){
        $show_modal = true;
        $title = "Cliente removido";
        $body = "O cliente foi removido com sucesso!";
        $color = "success";
        $btn = "Okay";
      }
      else if($_GET['delete_costumer'] == 'failed') {
        $show_modal = true;
        $title = "Cliente não removido!";
        $body = "Falha ao remover o cliente!";
        $color = "cancel";
        $btn = "Okay";
      }
    }

    if(isset($_GET['add_func'])) {
      $active_tab = 2;
      if($_GET['add_func'] == 'success'){
        $show_modal = true;
        $title = "Funcionário adicionado!";
        $body = "O funcionário foi adicionado com sucesso!";
        $color = "success";
        $btn = "Okay";
      }
      else if($_GET['add_func'] == 'failed') {
        $show_modal = true;
        $title = "Funcionário não removido!";
        $body = "Falha ao remover o funcionário!";
        $color = "cancel";
        $btn = "Okay";
      }
    }

    if($show_modal) {
      echo "<script type='text/javascript'>
      $(document).ready(function(){
      $('#insertModal').modal('show');
      });
      </script>";
    }
  ?>
    <!--LOADER DE BUSCA-->
    <div id="load">
      <img src="ring-1.png" class="ring">
    </div>
      <!-- Modal 
        No produto final, haverá somente uma modal para info e outra para alterações, cujo conteúdo será dinamicamente definido a depender do pedido selecionado.
        No protótipo, somente as ações do primeiro item abrem modais de detalhes e alteração, uma vez que o dinamismo ainda não está implementado. -->
   
  <div id="insertModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" style="text-align: center;"><?php echo $title?></h3>
        </div>
        <div class="modal-body" style="text-align: center;">
            <?php echo $body?>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-<?php echo $color ?>" data-dismiss="modal"><?php echo $btn?></button>
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
              <li class="list-group-item"><b>Tipo: </b><span id="info_modal_type">Comida</span</li>
              <li class="list-group-item"><b>Preço: </b><span id="info_modal_price">R$0</span></li>
              <li class="list-group-item"><b id="info_modal_desc_name">Descrição:</b> <span id="info_modal_desc_text"></span></li>
                <li id="info_modal_ingred_li" class="list-group-item"><b id="info_modal_ingred_name">Ingredientes:</b> <span id="info_modal_ingred_text"></span></li>
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

    <div id="alterModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
  
          <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title">Alterar Produto</h3>
          </div>
          <div class="modal-body">
            
            <form class="form-horizontal" method="POST" action="../Controller/ControllerItem.php?mode=update">
            <input type="hidden" id="alter_code" name="alter_code" value="-1">
              <div class="form-group">
                <label class="control-label col-sm-1">Tipo:</label>
                <label class="radiobtn"><input type="radio" name="alter_type" checked id="alter_food" value="food" onclick=toggle('alter')><span class="radiolbl">Comida</span></label>
                <label class="radiobtn"><input type="radio" name="alter_type" id="alter_beverage" value="beverage" onclick=toggle('alter')> <span class="radiolbl">Bebida</span></label>
              </div>
  
              <div class="form-group">
                <label class="control-label col-sm-1" for="alter_name">Nome:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" required id="alter_name" name="alter_name" placeholder="Insira o nome do produto" value="Frango Grelhado ao Molho de Limão">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-1" for="alter_price">Preço:</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon" style="color: #460202;">R$</span>
                    <input type="number" class="form-control currency" required id="alter_price" name="alter_price" placeholder="Insira o preço do produto" value="27.50" step="0.01" min="0.01" data-number-to-fixed="2">
                  </div>
                </div>
              </div>
  
              <div class="form-group" id="alter_descDiv">
                <div class="col-sm-offset-1 col-sm-10">
                  <label for="alter_desc">Descrição:</label>
                  <textarea class="form-control" required placeholder="Insira a descrição aqui" rows="3" id="alter_desc" name="alter_desc"></textarea>
                </div>
              </div>
  
              <div class="form-group" id="alter_ingredDiv">
                <div class="col-sm-offset-1 col-sm-10">
                  <label for="alter_ingred">Ingredientes:</label>
                  <textarea class="form-control" required placeholder="Insira os ingredientes aqui" rows="3" id="alter_ingred" name="alter_ingred"></textarea>
                </div>
              </div>
              
              <div class="form-group hide" id="alter_supplierDiv">
                <label class="control-label col-sm-1" for="alter_supplier">Fornecedor:</label>
                <div class="col-sm-9" style="margin-left: 50px;">
                  <input type="text" class="form-control" id="alter_supplier" name="alter_supplier" placeholder="Insira o nome do fornecedor">
                </div>
              </div>
  
              <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                  <button type="submit" class="btn btn-default">Alterar</button>
                </div>
              </div>
            
            </form>
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

      <nav class="navbar navbar-inverse" style="border-radius: 0px;">
        <div class="container-fluid stdbgcolor">
          <div class="navbar-header">
            <a class="navbar-brand stdnavcolor" href="cardapio.php">Le Bistro</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a class="stdnavcolor" href="cardapio.php">Home</a></li>
            <li class="active"><a class="stdnavcolor" href="#">Gerência</a></li>
            <li><a class="stdnavcolor" href="cozinha.php">Cozinha</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <li><p class="navbar-text stdnavcolor">Olá, <?php echo $user_name?></p>
            <li data-toggle="modal" data-target="#logoutModal"><a href="#"><span class="glyphicon glyphicon-log-out stdnavcolor"></span> <span class="stdnavcolor">Logout</span></a></li>
          </ul>
        </div>
      </nav>

    <div class="container">
      <h1>Gerência</h1>
      <ul class="nav nav-tabs">
        <li 
        <?php 
        if($active_tab == 0)
          echo "class='active'";
        ?>
        ><a data-toggle="tab" class="stdtxtcolor" href="#add">Adicionar Produtos</a></li>
        <li
        <?php 
        if($active_tab == 1)
          echo "class='active'";
        ?>
        ><a data-toggle="tab" class="stdtxtcolor" href="#find" onclick=setTab(0)>Buscar Produtos</a></li>
        <li
        <?php 
        if($active_tab == 2)
          echo "class='active'";
        ?>
        ><a data-toggle="tab" class="stdtxtcolor" href="#regFunc">Cadastrar Funcionário</a></li>
        <li
        <?php 
        if($active_tab == 3)
          echo "class='active'";
        ?>
        ><a data-toggle="tab" id="costumer_tab" class="stdtxtcolor" href="#costumers" onclick=setTab(1)>Clientes</a></li>
      </ul>
      <div class="tab-content">
        <div id="add" class="tab-pane fade
        <?php 
        if($active_tab == 0)
          echo "in active";
        ?>">
          <h3>Adicionar Produtos ao Cardápio</h3>
          <form class="form-horizontal" method="POST" action="../Controller/ControllerItem.php?mode=insert">
            <div class="form-group">
              <label class="control-label col-sm-1">Tipo:</label>
              <label class="radiobtn"><input type="radio" name="type" value="food" checked id="food" onclick=toggle('add')><span class="radiolbl">Comida</span></label>
              <label class="radiobtn"><input type="radio" name="type" value="bvg" id="beverage" onclick=toggle('add')> <span class="radiolbl">Bebida</span></label>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-1" for="name">Nome:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" required id="name" name="name" placeholder="Insira o nome do produto">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-1" for="price">Preço:</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-addon" style="color: #460202;">R$</span>
                  <input type="number" class="form-control currency" required id="price" name="price" placeholder="Insira o preço do produto" value="10.50" step="0.01" min="0.01" data-number-to-fixed="2">
                </div>
              </div>
            </div>

            <div class="form-group" id="descDiv">
              <div class="col-sm-offset-1 col-sm-10">
                <label for="desc">Descrição:</label>
                <textarea class="form-control" placeholder="Insira a descrição aqui" rows="3" id="desc" name="desc"></textarea>
              </div>
            </div>

            <div class="form-group" id="ingredDiv">
              <div class="col-sm-offset-1 col-sm-10">
                <label for="ingred">Ingredientes:</label>
                <textarea class="form-control" placeholder="Insira os ingredientes aqui" rows="3" id="ingred" name="ingred"></textarea>
              </div>
            </div>
            
            <div class="form-group hide" id="supplierDiv">
              <label class="control-label col-sm-1" for="supplier">Fornecedor:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Insira o nome do fornecedor">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-1 col-sm-10">
                <button type="submit" class="btn btn-default">Adicionar</button>
              </div>
            </div>
          
          </form>
      </div>

      <div id="find" class="tab-pane fade 
      <?php 
        if($active_tab == 1)
          echo "in active";
      ?>">
        <div class="form-group has-feedback">
          <label class="control-label col-sm-1" for="find_inputSuccess" style="padding-top: 7px;">
          Busca:</label>
          <div class="col-sm col-sm-11">
            <input type="text" class="form-control" id="find_inputSuccess">
            <span class="glyphicon glyphicon-search form-control-feedback" style="text-align: left;  margin-right: 5px;"></span>
          </div>
          <div class="checkbox">
                <div class="col-sm-offset-1 col-sm-10" style="margin-top: 10px; margin-bottom: 10px">
                  <label><input checked type="checkbox" value="" id="chkbox_food">Comidas</label>
                  <label style="padding-left: 40px;"><input checked type="checkbox" value="" id="chkbox_beverage">Bebidas</label>
                </div>
          </div>
        </div>

        <div class="container" style="padding-top: 50px;">
          <div class="row">
            <div class="col-12" style="margin-right: 31px;">
              <table class="table table-bordered">
                <thead style="background-color: #460202;color: white;">
                  <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody id="searchTable">
                  <tr>
                    <th scope="row">1</th>
                    <td>Frango Grelhado ao Molho de Limão</td>
                    <td>
                      <span data-toggle="modal" data-target="#infoModal">
                          <button type="button" class="kitchenbtn btn-info" data-toggle="tooltip" data-placement="bottom" title="Detalhes"><i class="glyphicon glyphicon-info-sign"></i></button>
                      </span>
                      <span data-toggle="modal" data-target="#alterModal">
                        <button type="button" class="kitchenbtn btn-neutral" data-toggle="tooltip" data-placement="bottom" title="Alterar"><i class="glyphicon glyphicon-pencil"></i></button>
                      </span>
                      <span data-toggle="modal" data-target="#excludeModal">
                        <button type="button" class="kitchenbtn btn-cancel" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="glyphicon glyphicon-trash"></i></button>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Suco de Abacaxi</td>
                    <td>
                      <button type="button" class="kitchenbtn btn-info" data-toggle="tooltip" data-placement="bottom" title="Detalhes"><i class="glyphicon glyphicon-info-sign"></i></button>
                      <button type="button" class="kitchenbtn btn-neutral" data-toggle="tooltip" data-placement="bottom" title="Alterar"><i class="glyphicon glyphicon-pencil"></i></button>
                      <span data-toggle="modal" data-target="#excludeModal">
                        <button type="button" class="kitchenbtn btn-cancel" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="glyphicon glyphicon-trash"></i></button>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
      </div>

      <div id="regFunc" class="tab-pane fade
      <?php 
        if($active_tab == 2)
          echo "in active";
      ?>">
        <h3>Cadastrar Novo Funcionário</h3>
          <form class="form-horizontal" method="POST" action="../Controller/ControllerFuncionario.php?mode=insert">
            <div class="form-group">
              <label class="control-label col-sm-1">Tipo:</label>
              <label class="radiobtn"><input type="radio" name="type" value="admin" checked id="manager"><span class="radiolbl">Administrador</span></label>
              <label class="radiobtn"><input type="radio" name="type" value="cook" id="cook"> <span class="radiolbl">Cozinheiro</span></label>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-1" for="func_name">Nome:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" required id="func_name" name="func_name" placeholder="Insira o nome do novo funcionário">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-1" for="func_cpf">CPF:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" required id="func_cpf" name="func_cpf" placeholder="Insira o CPF do novo funcionário" pattern="([0-9]{11})" title='Favor inserir onze dígitos numéricos sem pontos ou traços.'>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-1" for="func_pwd">Senha:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" required id="func_pwd" name="func_pwd" placeholder="Insira a senha do novo funcionário">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-1 col-sm-10">
                <button type="submit" class="btn btn-default">Adicionar</button>
              </div>
            </div>
          
          </form>
      </div>

      <div id="costumers" class="tab-pane fade
      <?php 
        if($active_tab == 3)
          echo "in active";
      ?>">
        <div class="form-group has-feedback">
          <label class="control-label col-sm-1" for="costumers_inputSuccess" style="padding-top: 7px;">
          Busca:</label>
          <div class="col-sm col-sm-11">
            <input type="text" class="form-control" id="costumers_inputSuccess">
            <span class="glyphicon glyphicon-search form-control-feedback" style="text-align: left;  margin-right: 5px;"></span>
          </div>
        </div>

        <div class="container" style="padding-top: 50px;">
          <div class="row">
            <div class="col-12" style="margin-right: 31px;">
              <table class="table table-bordered">
                <thead style="background-color: #460202;color: white;">
                  <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Bônus</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody id="costumer_table">
                  <tr>
                    <th scope="row">1</th>
                    <td>João Gabriel Setubal Pires</td>
                    <td>R$420,69</td>
                    <td>
                      <span data-toggle="modal" data-target="#excludeModal">
                        <button type="button" class="kitchenbtn btn-cancel" data-toggle="tooltip" data-placement="bottom" title="Excluir Cliente"><i class="glyphicon glyphicon-trash"></i></button>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Marcela Braga Bahia</td>
                    <td>R$66,66</td>
                    <td>
                      <span data-toggle="modal" data-target="#excludeModal">
                        <button type="button" class="kitchenbtn btn-cancel" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="glyphicon glyphicon-trash"></i></button>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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