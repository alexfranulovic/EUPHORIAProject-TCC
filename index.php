<?php
  include("conexao.php");
  include ("menu.php");
$result = "SELECT * FROM pag WHERE id = '1' LIMIT 1";
      $resultado = mysqli_query($conn, $result);
        while($linhas = mysqli_fetch_assoc($resultado)){
            $imagem = 'imagens/paginas/'.$linhas['imagem'];
            echo '

            <div class="hero-wrap js-fullheight" style="background-image: url('.$imagem.')"> 
            
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
          <!--<h3 class="v">EUPHORIA - ALWAYS IN TOP</h3>
          <h3 class="vr">Since - 2020</h3>-->
          <div class="col-md-11 ftco-animate text-center">
            <h1>'.$linhas['nome'].'</h1>';
            if ($linhas['sub'] != '') {
              echo '<h2><span>'.$linhas['sub'].'</span></h2>';
            }
            
          echo '</div>
          <div class="mouse">
      <a href="#" class="mouse-icon">
        <div class="mouse-wheel"><span class="ion-ios-arrow-down"></span></div>
      </a>
      </div>
        </div>
      </div>
    </div>';
            
?>
    <div class="goto-here"></div>
<?php
    if ($linhas['mod_carrousel_prod'] != 1) {
      echo "";
    }else{ 
      include("modulos/mod_carrousel_prod.php");
    }

    if ($linhas['mod_destaque_carrinho'] != 1) {
      echo "";
    }else{ 
      include("modulos/mod_destaque_carrinho.php");
    }

    if ($linhas['mod_banner'] != 1) {
      echo "";
    }else{ 
      include("modulos/mod_banner.php");
    }

    if ($linhas['mod_numeros'] != 1) {
      echo "";
    }else{ 
      include("modulos/mod_numeros.php");
    }

    if ($linhas['mod_destaque_principal'] != 1) {
      echo "";
    }else{ 
      include("modulos/mod_destaque_principal.php");
    }

    if ($linhas['mod_coments'] != 1) {
      echo "";
    }else{ 
      include("modulos/mod_coments.php");
    }

    if ($linhas['mod_services'] != 1) {
      echo "";
    }else{ 
      include("modulos/mod_services.php");
    }

  }
      include ("footer.php");
    ?>
  </body>
</html>