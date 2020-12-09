<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/modist/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/modist/style.css">
    <?php
    $result_favic = mysqli_query($conn,"SELECT * FROM pag WHERE id = '3'");
        while($linhas_favic = mysqli_fetch_assoc($result_favic)){
            $imagem = 'imagens/icons/'.$linhas_favic['imagem'];
            echo '      
    <link rel="icon" type="image/png" href="'.$imagem.'"/>
    <title>'.$linhas_favic['sub'].'</title>';
        }
    ?>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
        <a class="navbar-brand" href="index.php">EUPHORIA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="index.php" class="nav-link" style="color: #7c088a;">Home</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Conta
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="login.php">Login</a>
                <?php
                if (isset($_SESSION['usuarioId'])) {
                  echo '<a class="dropdown-item" href="usuario.php">Perfil</a>';
                }
                ?>
                <a class="dropdown-item" href="cadastro.php">Cadastro</a>
                <?php
                if (isset($_SESSION['usuarioId'])) {
                  echo '
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="sair.php">Sair</a>';
                }
                ?>
              </div>
            </li>
            <?php
            if (isset($_SESSION['usuarioNivelAcesso'])) {
              if ($_SESSION['usuarioNivelAcesso'] == 1) {
                echo '
                <li class="nav-item"><a href="adm/administrativo.php" class="nav-link">Administrador</a></li>';
              }
            }
            ?>
            <li class="nav-item"><a href="shop.php" class="nav-link">Shop</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">Sobre nós</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link">Contato</a></li>
            <li class="nav-item cta cta-colored"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart">
          
            </span>
              [<?php
                if (isset($_SESSION['usuarioId'])) {
                  $usuario_id = $_SESSION['usuarioId'];
                  $result_cart = mysqli_query($conn, "SELECT id FROM carrinho WHERE usuario_id = '$usuario_id'");
                }else{
                  $session_id = $_SESSION['session_id'];
                  $result_cart = mysqli_query($conn, "SELECT id FROM carrinho WHERE session_id = '$session_id'");
                }
                $data = mysqli_num_rows($result_cart);
                  echo $data;
              ?>]
            </a></li>

          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->