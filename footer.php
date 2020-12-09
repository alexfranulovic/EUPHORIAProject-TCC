<footer class="ftco-footer ftco-section" style="background: #7c088a;">

    <?php
      $result_footer =  mysqli_query($conn, "SELECT * FROM pag WHERE id = '2' LIMIT 1");
      $linhas_footer = mysqli_fetch_assoc($result_footer);
           
           if ($linhas_footer['cad_news'] == 1) {
              echo '
    <section class="ftco-section-parallax">
      <div class="parallax-img d-flex align-items-center" style="margin-bottom: 0px;">
        <div class="container">
          <div class="row d-flex justify-content-center py-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
              <h1 class="big">E-MAIL</h1>
              <h2>Cadastre-se para novidades</h2>
              <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-8">
                  <form action="processa/proc_cad_news.php" method="post" class="subscribe-form">
                    <div class="form-group d-flex">
                      <input type="email" class="form-control" name="email" placeholder="Coloque seu e-mail" required>
                      <input type="submit" value="Cadastrar" class="submit px-3">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>';
           }

            echo '

      <div class="container ftco-animate">
        <div class="row">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Redes sociais</h2>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft">';
              if ($linhas_footer['face'] != '') {
                echo '<li class="ftco-animate"><a href="'.$linhas_footer['face'].'"><span class="icon-facebook"></span></a></li>';
              }
              if ($linhas_footer['insta'] != '') {
                echo '<li class="ftco-animate"><a href="'.$linhas_footer['insta'].'"><span class="icon-instagram"></span></a></li>';
              }
              if (!empty($linhas_footer['twitter'])) {
                echo '<li class="ftco-animate"><a href="'.$linhas_footer['twitter'].'"><span class="icon-twitter"></span></a></li>';
              }
              echo '
              </span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">INFORMAÇÕES</h2>
              <div class="d-flex">
                <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
                  <li><a href="http://www.correios.com.br/" class="d-block">Rastreio</a></li>
                  <li><a href="trades_devolutions.php" class="d-block">Trocas e devoluções</a></li>
                  <li><a href="terms_conditions.php" class="d-block">Termos e condições</a></li>
                </ul>
                <ul class="list-unstyled">
                  <li><a href="about.php" class="d-block">Sobre</a></li>
                  <li><a href="contact.php" class="d-block">Contato</a></li>
                  <li><a href="politica.php" class="d-block">Políticas da loja</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Tem alguma dúvida, bro?</h2>
              <div class="block-23 mb-3">
                <ul>';
              if ($linhas_footer['endereco'] != '') {
                //echo '<li><span class="icon icon-map-marker"></span><span class="text">'.$linhas_footer['endereco'].'</span></li>';
              }
              if ($linhas_footer['telefone'] != '') {
                echo '<li><a href="tel://+55 '.$linhas_footer['telefone'].'"><span class="icon icon-phone"></span><span class="text">+55 '.$linhas_footer['telefone'].'</span></a></li>';
              }
              if (!empty($linhas_footer['email'])) {
                echo '<li><a href="mailto:'.$linhas_footer['email'].'"><span class="icon icon-envelope"></span><span class="text">'.$linhas_footer['email'].'</span></a></li>';
              }
          ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p style="color: white;">
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
             &copy;<script>document.write(new Date().getFullYear());</script> Máfia do Azeite 
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
        </div>
      </div>
    </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="js/modist/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/modist/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="js/modist/main.js"></script>
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.mask.min.js"></script>
  <script>
      jQuery(function($){
        $("#cpf").mask("999.999.999-99");
        $("#senderCPF").mask("999.999.999-99");
        $("#creditCardHolderCPF").mask("999.999.999-99");

        $("#qtdprod").mask("99");
        $("#rg").mask("99.999.999-9");
        $("#cep").mask("99.999-999");

        $("#shippingAddressPostalCode").mask("99.999-999");
        $("#billingAddressPostalCode").mask("99.999-999");

        $("#tel").mask("(99) 99999-9999");
        $("#senderPhone").mask("(99) 99999-9999");
        $("#mask-phone2").mask("(99) 99999-9999");
        $("#mask-phoneconta").mask("99 999999999");
        $("#mask-phonewpp").mask("99999999999");

        $("#cnpj").mask("99.999.999/9999-99");
        $("#mask-num").mask("999999");

        $("#data").mask("99/99/9999");
        $("#creditCardHolderBirthDate").mask("99/99/9999");

        $("#mask-percent").mask("99%");
      });
  </script>