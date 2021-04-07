<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script defer>
    function toggle() {
      if(document.getElementById("admin_chkbox").checked) {
        document.getElementById("admin_pwdDiv").classList.remove("hide");
        document.getElementById("func_pwd").disabled = false;
        document.getElementById("func_pwd").required = true;
        document.getElementById("login_form").action = "../Controller/ControllerFuncionario.php?mode=search";
        document.getElementById("login_tableDiv").classList.add("hide");
        document.getElementById("login_table").disabled = true;
        document.getElementById("login_table").required = false;

      }
      else {
        document.getElementById("login_tableDiv").classList.remove("hide");
        document.getElementById("login_table").disabled = false;
        document.getElementById("login_table").required = true;
        document.getElementById("admin_pwdDiv").classList.add("hide");
        document.getElementById("func_pwd").disabled = true;
        document.getElementById("func_pwd").required = false;
        document.getElementById("login_form").action = "../Controller/ControllerCliente.php?mode=search";
      }
    }
  </script>

<?php
  session_start();
  $show_modal = false;
  if(isset($_GET["login"])) {
    $show_modal = true;
    if($_GET["login"] == "fail") {
      $title = "CPF Inválido";
      $body = "O CPF inserido não foi encontrado.";
    }
    else if($_GET["login"] == "fail_func") {
      $title = "Dados Inválidos!";
      $body = "CPF e/ou senha incorretos.";
    }
    else if($_GET["login"] == "unauth") {
      if(isset($_SESSION["user_type"])) {
        header('Location: cardapio.php');
      }
      else {
        $title = "Erro!";
        $body = "Faça login antes de continuar.";
      }
    }
    else if($_GET["login"] == "out") {
      $show_modal = false;
      session_unset();
      session_destroy();
    }
  }
  else if (isset($_GET["register"])) {
    $show_modal = true;
    if($_GET["register"] == "success"){
      $title = "Sucesso!";
      $body = "Seu cadastro foi realizado com êxito.";
    }
    else if ($_GET["register"] == "fail"){
      $title = "Erro!";
      $body = "Sistema indisponível.";
    }
    else if ($_GET["register"] == "exists"){
      $title = "Erro!";
      $body = "CPF já cadastrado.";
    }
  }
  
  if($show_modal) {
    echo "<script type='text/javascript'>
    $(document).ready(function(){
    $('#loginModal').modal('show');
    });
    </script>";
  }
?>

</head>
<body>
  <div id="loginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" style="text-align: center;"><?php echo $title?></h3>
        </div>
        <div class="modal-body" style="text-align: center;">
            <b><?php echo $body?></b>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>

    </div>
  </div>

  <nav class="navbar navbar-inverse" style="border-radius: 0px;">
    <div class="container-fluid stdbgcolor">
      <div class="navbar-header">
        <a class="navbar-brand stdnavcolor" href="#">Le Bistro</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <h1>Bem-vindo ao Le Bistro!</h1>
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" class="stdtxtcolor" href="#login">Fazer Login</a></li>
      <li><a data-toggle="tab" class="stdtxtcolor" href="#register">Cadastrar-se</a></li>
    </ul>

    <div class="tab-content" style="margin-top:15px;">
      <div id="login" class="tab-pane fade in active">
        <form class="form-horizontal" method="POST" name="login_form" id="login_form" action="../Controller/ControllerCliente.php?mode=search">
          <div class="form-group">
            <label class="control-label col-sm-1" for="login_cpf">CPF:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required id="login_cpf" name="cpf" placeholder="Insira seu CPF" pattern="([0-9]{11})" title='Favor inserir onze dígitos numéricos sem pontos ou traços.'>
            </div>
          </div>
          
          <div class="checkbox">
            <div class="col-sm-offset-1 col-sm-10">
              <label style="margin-bottom: 18px; margin-left: -12px;"><input type="checkbox" value="is_admin" onclick=toggle() id="admin_chkbox" name="admin_chkbox">Conta de Funcionário</label>
            </div>
          </div>

          <div class="form-group" style="margin-right: 0;" id="login_tableDiv">
            <label class="control-label col-sm-1" for="login_table">Mesa:</label>
            <div class="col-sm-1" style="padding-right: 0px;">
              <input type="number" class="form-control" required id="login_table" name="login_table" value="1" min="1" placeholder="Insira o número de sua mesa." >
            </div>
          </div>

          <div class="form-group hide" style="margin-right: 0;" id="admin_pwdDiv">
            <label class="control-label col-sm-1" for="func_pwd">Senha:</label>
            <div class="col-sm-10" style="padding-right: 0px;">
              <input type="password" class="form-control" id="func_pwd" name="func_pwd" placeholder="Insira sua senha de funcionário">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
              <button type="submit" class="btn btn-default" style="position: relative;left: -2px;">Fazer Login</button>
            </div>
          </div>
        
        </form>
      </div>
    

      <div id="register" class="tab-pane fade in">
        <form class="form-horizontal" method="POST" action="../Controller/ControllerCliente.php?mode=insert">
          <div class="form-group">
            <label class="control-label col-sm-1" style="padding-top: 0px" for="name">Nome Completo:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required id="name" name="name" placeholder="Insira o nome completo">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-1" for="cpf">CPF:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required id="cpf" name="cpf" placeholder="Insira o seu CPF" pattern="([0-9]{11})" title='Favor inserir onze dígitos numéricos sem pontos ou traços.'>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-1" for="email">E-mail:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required id="email" name="email" placeholder="Insira o seu e-mail">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
              <button type="submit" class="btn btn-default">Cadastrar</button>
            </div>
          </div>
        
        </form>
      </div>
    </div>
    <footer style="margin: 10px auto; padding: 10px; text-align: center; border-top:5px solid; color: #700303"><b>Restaurante Le Bistro</b><br>Rua Barão de Mauá n° 501<br>Ibirapuera<br>São Paulo<br>Brasil<br>Telefone: (11) 4261-1534</footer>
</body>