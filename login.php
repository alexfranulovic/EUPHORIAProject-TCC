<?php
  include("conexao.php");
  include ("menu.php");
  unset($_SESSION['usuarioId'],     
          $_SESSION['usuarioNome'],     
          $_SESSION['usuarioNivelAcesso'], 
          $_SESSION['usuarioLogin'],
          //$_SESSION['session_id'],    
          $_SESSION['usuarioSenha']);

$result = "SELECT * FROM pag WHERE id = '2' LIMIT 1";
  $resultado = mysqli_query($conn, $result);
  $linhas = mysqli_fetch_assoc($resultado);
      $imagem = 'imagens/paginas/'.$linhas['imagem'];
      echo '<div class="hero-wrap hero-bread" style="background-image: url('.$imagem.');">';
?>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread">login</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>login</span></p>
          </div>
        </div>
      </div>
    </div>
<!----------------------------------------------- section ---------------------------------------------------------->  
  <section class="ftco-section bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 ftco-animate" >
          <div style="background-color: white; border-radius: 10px;" >
            <div class="billing-form py-3 px-5" >
<!------------------------------------------------- form ------------------------------------------------------------>
              <form action="processa/proc_valida_login.php" method="post">
                  
                <div class="row align-items-end">
                  <img src="imagens/paginas/a.png" style="position: relative; margin-left: auto; margin-right: auto; width: auto; height: 270px;">

                  <div class="col-md-12">
                    <?php
                    if(isset($_SESSION['loginErro'])){
                      echo $_SESSION['loginErro'];
                      unset($_SESSION['loginErro']);
                    }
                    ?>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="firstname">E-mail ou usuário</label>
                      <input type="text" class="form-control" placeholder="Login" name="usuario">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="firstname">Senha</label>
                      <input type="password" class="form-control" placeholder="Senha" name="senha">
                    </div>
                  </div>
                  
                  <div class="col-md-12 ">
                    <div class="text-right">
                      <span class="txt1 p-b-17">
                        <a href="recupera_senha.php" class="txt2">Esqueceu a senha?</a>
                      </span>
                    </div>
                  </div>
                  
                  <div class="col-md-12" style="padding-top: 15px;">
                    <div style="width: 100%; position: relative; margin-left: auto; margin-right: auto;">
                      <input type="submit" value="Entrar" class="btn btn-primary py-3 px-5" style="width: 100%;">
                    </div>
                  </div>
                </div>

              </form>
<!----------------------------------------------- / form ------------------------------------------------------------>
              <div class="row align-items-end">

                <div class="col-md-12" style="padding-top: 20px;">

                  <div style="width: 100%; position: relative; margin-left: auto; margin-right: auto;">
                    <a href="index.php">
                      <button class="btn btn-primary py-3 px-5" style="width: 100%;">
                        Voltar
                      </button>
                    </a>
                  </div>

                  <div class="text-center" style="padding-top: 20px; padding-bottom: 25px;">
                    <span class="txt1 p-b-17" >
                      Nos siga nas redes sociais
                    </span>
                  </div>

                  <div class="ftco-footer-widget text-center">
                    <ul class="ftco-footer-social list-unstyled">
                  <?php
                    $result_redes = mysqli_query($conn, "SELECT * FROM pag WHERE id = '2' LIMIT 1");
                    $linhas_redes = mysqli_fetch_assoc($result_redes);
                        if (!empty($linhas_redes['face'])) {
                          echo '
                      <li class="ftco-animate">
                        <a href="'.$linhas_redes['face'].'" class="btn btn-primary"><span class="icon-facebook"></span></a>
                      </li>';
                        }
                        if (!empty($linhas_redes['twitter'])) {
                          echo '
                      <li class="ftco-animate">
                        <a href="'.$linhas_redes['twitter'].'" class="btn btn-primary"><span class="icon-twitter"></span></a>
                      </li>';
                        }
                        if (!empty($linhas_redes['insta'])) {
                          echo '
                      <li class="ftco-animate">
                        <a href="'.$linhas_redes['insta'].'" class="btn btn-primary"><span class="icon-instagram"></span></a>
                      </li>';
                        }
                  ?>
                    </ul>
                  </div>

                  <div class="text-center" style="padding-bottom: 25px;">
                    <span class="txt1 p-b-17" >
                      Não é membro? <a href="cadastro.php" class="txt2">Cadastre-se</a>
                    </span>
                  </div>

                </div>

              </div>
<!----------------------------------------------- / row ------------------------------------------------------------>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<!----------------------------------------------- section ---------------------------------------------------------->
<script type="text/javascript">
  function mostrarSenha() {
    var tipo = document.getElementById("senha");
    if (tipo.type == "password") {
      tipo.type = "text";
    }else{
      tipo.type = "password";
    }
  } 

</script>
<?php
  include ("footer.php");
?>

  </body>
</html>