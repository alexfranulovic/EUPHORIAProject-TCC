<?php
  include("conexao.php");
  include_once("seguranca.php");
  include ("menu.php");
  include ('processa/functions.php');

  $result = "SELECT * FROM pag WHERE id = '2' LIMIT 1";
      $resultado = mysqli_query($conn, $result);
      $linhas = mysqli_fetch_assoc($resultado);
        $imagem = 'imagens/paginas/'.$linhas['imagem'];
            echo '<div class="hero-wrap hero-bread" style="background-image: url('.$imagem.');">';

  $id = $_SESSION['usuarioId'];;
  //Executa consulta
  $result = "SELECT * FROM usuarios WHERE id = '$id'";
  $resultado = mysqli_query($conn, $result);
  $row = mysqli_fetch_assoc($resultado);      
?>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread"><?php echo "Bem vindo, ".$row['nome'];?> </h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Perfil</span></p>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-animate">
      <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
          <div class="col-md-12 heading-section text-center ftco-animate" style="margin-bottom: 25px;">
            <h1 class="big">Perfil</h1>
            <h2 class="mb-4">Detalhes da conta</h2>
          </div>
        </div>        
      </div>
      <div class="container">

        <?php
        if(isset($_SESSION['msg'])){
          echo $_SESSION['msg'];
          unset($_SESSION['msg']);
        }
        ?>

          <div class="row justify-content-center">
              <div class="col-md-6 d-flex">
                <div class="cart-detail cart-total bg-light p-3 p-md-4">
                  <h3 class="billing-heading mb-4">Meus dados:</h3>
                  <p class="d-flex">
                    <span class="d-none d-sm-block">Nome:</span>
                    <span><?php echo $row['nome']." ".$row['sobrenome']; ?> </span>
                  </p>
                  <p class="d-flex">
                    <span class="d-none d-sm-block">Usuário:</span>
                    <span><?php echo $row['login']; ?></span>
                  </p>
                  <p class="d-flex">
                    <span class="d-none d-sm-block">E-mail:</span>
                    <span><?php echo $row['email']; ?></span>
                  </p>
                  <p class="d-flex">
                    <span class="d-none d-sm-block">Telefone:</span>
                    <span><?php echo formatTelefone($row['telefone']); ?></span>
                  </p>
                  <p class="d-flex">
                    <span class="d-none d-sm-block">C.P.F.:</span>
                    <span><?php echo formatCnpjCpf($row['cpf']); ?></span>
                  </p>
                  
                  <p class="d-flex">
                    <span class="d-none d-sm-block">Endereço:</span>
                    <span>
                      <?php 
                        if (!empty($row['endereco'])) {            
                          echo $row['endereco'].', '.$row['numero'];
                        } else{ 
                          echo'Nenhum endereço cadastrado.';
                        }
                      ?>
                    </span>
                  </p>
                    <hr>
                  <p>
                    <a href="altera_dados.php"class="btn btn-primary py-3 px-4">Alterar dados</a>
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="cart-detail cart-total bg-light p-3 p-md-4">
                  <h3 class="billing-heading mb-4">Minhas coisas:</h3>
                  <p class="d-flex">
                    <a href="fav.php">Meus favoritos</a>
                  </p>
                  <p class="d-flex">
                    <a href="minhas_compras.php">Minhas compras</a>
                  </p>
                  <!--<p class="d-flex">
                    <a href="invoice_usuario.php">Minhas notas fiscais</a>
                  </p>
                  <p class="d-flex">
                    <a href="points.php">Minha fidelidade</a>
                  </p>-->
                  <p class="d-flex">
                    <a href="contact.php">Ajuda</a>
                  </p>
                    <br>
                    <br>
                    <br>
                    
                  <p class="d-flex">
                    <a href="sair.php">Sair</a>
                  </p>
                    <hr>
                  <p><a href="shop.php"class="btn btn-primary py-3 px-4">Fazer compras</a></p>
                </div>
              </div>
            </div>
      </div>
    </section>
    
<?php
  include ("footer.php");
?>
  </body>
</html>
          
          
          
        