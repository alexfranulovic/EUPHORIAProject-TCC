<?php
  session_start();
  include_once("seguranca.php");
  include ("conexao.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Administrativo</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="icon" type="img/png" href="img/icons/favicon.ico"/>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="administrativo.php">EUPHORIA</a></h1>
</div>
<!--close-Header-part--> 

<?php
  include ('menu_admin.php');
?>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="administrativo.php" title="Ir para home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
<div class="container-fluid">

<!--Chart-box-->    
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Estatísticas do site</h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
            <div class="span9">
              <canvas id="myChart" style="height: 300px; min-height: 300px; max-height: 300px; width: 100%;min-width: 100%;max-width: 100%;" ></canvas>
            </div>
<!------------------------------------------------------------------------------------------------------------------>            
            <div class="span3">
              <ul class="site-stats">        
                <li class="bg_lh"><i class="icon-user"></i> 
                  <strong>
                    <?php
                      $result = mysqli_query($conn,'SELECT id FROM usuarios');
                      $data = mysqli_num_rows($result);
                        echo $data;
                    ?>
                  </strong> 
                  <small>Total de usuários</small>
                </li>
<!------------------------------------------------------------------------------------------------------------------>     
                <li class="bg_lh"><i class="icon-plus"></i> 
                  <strong>
                    <?php
                      $result = mysqli_query($conn,'SELECT * FROM usuarios WHERE created >= NOW() - INTERVAL 1 DAY;');
                      $data = mysqli_num_rows($result);
                        echo $data;
                    ?>
                  </strong> 
                  <small>Novos usuários</small>
                </li>
<!------------------------------------------------------------------------------------------------------------------>     
                <li class="bg_lh"><i class="icon-shopping-cart"></i> 
                  <strong>
                    <?php
                      $result = mysqli_query($conn,'SELECT id FROM pagamentos');
                      $data = mysqli_num_rows($result);
                        echo $data;
                    ?>
                  </strong>  
                  <small>Total de compras</small>
                </li>
<!------------------------------------------------------------------------------------------------------------------>                     
                <li class="bg_lh"><i class="icon-tag"></i> 
                  <strong>
                    <?php
                      $result = mysqli_query($conn,'SELECT * FROM pagamentos WHERE created >= NOW() - INTERVAL 1 DAY;');
                      $data = mysqli_num_rows($result);
                        echo $data;
                    ?>
                  </strong> 
                  <small>Novos pedidos</small>
                </li>
<!------------------------------------------------------------------------------------------------------------------>     
                <li class="bg_lh"><i class="icon-envelope"></i> 
                  <strong>
                    <?php
                      $result = mysqli_query($conn,'SELECT id FROM mensagens');
                      $data = mysqli_num_rows($result);
                        echo $data;
                    ?>
                  </strong> 
                  <small>Mensagens totais</small>
                </li>
<!------------------------------------------------------------------------------------------------------------------>                  
                <li class="bg_lh"><i class="icon-envelope-alt"></i> 
                  <strong>
                    <?php
                      $result = mysqli_query($conn,'SELECT * FROM mensagens WHERE created >= NOW() - INTERVAL 1 DAY;');
                      $data = mysqli_num_rows($result);
                        echo $data;
                    ?>
                  </strong> 
                  <small>Mensagens novas</small>
                </li>
<!------------------------------------------------------------------------------------------------------------------>  
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--End-Chart-box--> 
    <hr/>
    <div class="row-fluid">
      <div class="span6">

        <div class="widget-box">
          <div class="widget-title"> <span class="icon" data-toggle="collapse" href="#collapseG3"> <i class="icon-th"></i> </span>
            <h5>Últimas mensagens</h5>
            <div class="pull-right" style=" font-size: 20px; ">
              <a href="listar_mensagens.php" title="Listar mensagens">
                <span class="icon"><i style="color: green;" class="icon-reorder"></i></span>
              </a>
            </div>
          </div>
          <div class="widget-content nopadding" id="collapseG3">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Assunto</th>
                  <th class='hidden-phone'>Data</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $result_mens = mysqli_query($conn, "SELECT id FROM mensagens");
                  $resultado_mens = mysqli_fetch_assoc($result_mens);

                  if (count($resultado_mens) == 0) {
                    echo '<tr><td colspan="5">Não há mensagens...</td><tr>';
                  }else{
                    $result = "SELECT * FROM mensagens ORDER BY created desc LIMIT 4";
                    $resultado = mysqli_query($conn, $result);
                    while($linhas = mysqli_fetch_assoc($resultado)){
                      echo "<tr class='gradeX'>";
                        echo "<td>".$linhas['id']."</td>";
                        echo "<td>".$linhas['nome']."</td>";
                        echo "<td>".$linhas['assunto']."</td>";

                        echo "<td class='hidden-phone'>";
                        $data = $linhas['created'];
                        echo date('d/m/Y - H:i:s', strtotime($data));
                        echo "</td>";

                        ?>
                        <td> 
                        <a title="Visualizar" href='visualizar_mensagem.php?id=<?php echo $linhas['id']; ?>'><i style="color: blue;" class="icon-eye-open"></i></a>
                        
                        <a title="Apagar" href='processa/proc_apagar_mensagem.php?id=<?php echo $linhas['id']; ?>'><i style="color: red;" class="icon-remove"></i></a>
                        </td>
                        
                        <?php
                      echo "</tr>";
                    }
                  }
                  ?>
                
              </tbody>
            </table>
          </div>
        </div>

        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>Método de pagamento mais usado</h5>
          </div>
          <div class="widget-content">
            <canvas id="MelhorPaymentMethod" style="height: 300px; min-height: 300px; max-height: 300px; width: 100%;min-width: 100%;max-width: 100%;" ></canvas>
          </div>
        </div>
        
      </div>

      <div class="span6">

        <div class="widget-box">
          <div class="widget-title"> <span class="icon" data-toggle="collapse" href="#collapsPag"> <i class="icon-th"></i> </span>
            <h5>Últimos pagamentos</h5>
            <div class="pull-right" style=" font-size: 20px; ">
              <a href="listar_vendas.php" title="Listar transações">
                <span class="icon"><i style="color: green;" class="icon-reorder"></i></span>
              </a>
            </div>
          </div>
          <div class="widget-content nopadding" id="collapsPag">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Referência</th>
                  <th>Tipo</th>
                  <th class='hidden-phone'>Data</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $result_mens = mysqli_query($conn, "SELECT id FROM pagamentos");
                  $resultado_mens = mysqli_fetch_assoc($result_mens);

                  if (count($resultado_mens) == 0) {
                    echo '<tr><td colspan="5">Não há pedidos...</td><tr>';
                  }else{
                    $result = "SELECT * FROM pagamentos ORDER BY created desc LIMIT 4";
                    $resultado = mysqli_query($conn, $result);
                    while($linhas = mysqli_fetch_assoc($resultado)){
                      echo "<tr class='gradeX'>";
                        echo "<td>".$linhas['id']."</td>";
                        echo "<td>".$linhas['reference']."</td>";
                        echo "<td>";if ($linhas['tipo_pg'] == 1) echo "Cartão de crédito"; elseif($linhas['tipo_pg'] == 2) echo "Boleto"; else echo"Débito online"; echo"</td>";

                        echo "<td class='hidden-phone'>";
                        $data = $linhas['created'];
                        echo date('d/m/Y - H:i:s', strtotime($data));
                        echo "</td>";

                        ?>
                        <td> 
                        <a title="Visualizar" href='invoice.php?id=<?php echo $linhas['reference']; ?>'><i style="color: blue;" class="icon-eye-open"></i></a>
                        
                        <a title="Editar" href='editar_venda.php?id=<?php echo $linhas['reference']; ?>'><i style="color: orange;" class="icon-pencil"></i></a>
                        </td>
                        
                        <?php
                      echo "</tr>";
                    }
                  }
                  ?>
                
              </tbody>
            </table>
          </div>
        </div>

        <div class="widget-box">
          <div class="widget-title bg_lo"> <span class="icon"> <i class="icon-chevron-down"></i> </span>
            <h5>Quantidades de registros</h5>
          </div>
          <div class="widget-content nopadding updates collapse in">
            
            <div class="new-update clearfix">
              <div class="update-done">
                <a title="Ver produtos" href="listar_produtos.php">
                  <span>Quantidade de produtos existentes: 
                    <strong>
                      <?php
                        $result = "SELECT id FROM produtos";
                        $resultado = mysqli_query($conn, $result);
                        $linhas = mysqli_num_rows($resultado);
                          echo $linhas;
                      ?>
                    </strong>
                  </span> </a>
              </div>
            </div>

            <div class="new-update clearfix">
              <div class="update-done">
                <a title="Ver categorias" href="listar_categoria.php">
                  <span>Quantidade de categorias existentes: 
                    <strong>
                      <?php
                        $result = "SELECT id FROM categorias";
                        $resultado = mysqli_query($conn, $result);
                        $linhas = mysqli_num_rows($resultado);
                          echo $linhas;
                      ?>
                    </strong>
                  </span> </a>
              </div>
            </div>

            <div class="new-update clearfix">
              <div class="update-done">
                <a title="Ver promoções" href="promocao.php">
                  <span>Quantidade de promoções existentes: 
                    <strong>
                      <?php
                        $result = "SELECT id FROM promocoes";
                        $resultado = mysqli_query($conn, $result);
                        $linhas = mysqli_num_rows($resultado);
                          echo $linhas;
                      ?>
                    </strong>
                  </span> </a>
              </div>
            </div>

            <div class="new-update clearfix">
              <div class="update-done">
                <a title="Ver usuários" href="listar_usuario.php">
                  <span>Quantidade de usuários existentes: 
                    <strong>
                      <?php
                        $result = "SELECT id FROM usuarios";
                        $resultado = mysqli_query($conn, $result);
                        $linhas = mysqli_num_rows($resultado);
                          echo $linhas;
                      ?>
                    </strong>
                  </span> </a>
              </div>
            </div>

            <div class="new-update clearfix">
              <div class="update-done">
                <a title="Ver e-mails de newsletter" href="listar_news.php">
                  <span>Quantidade de e-mails de newsletter existentes: 
                    <strong>
                      <?php
                        $result = "SELECT id FROM news";
                        $resultado = mysqli_query($conn, $result);
                        $linhas = mysqli_num_rows($resultado);
                          echo $linhas;
                      ?>
                    </strong>
                  </span> </a>
              </div>
            </div>

            <div class="new-update clearfix">
              <div class="update-done">
                <a title="Ver fornecedores" href="listar_fornecedor.php">
                  <span>Quantidade de fornecedores existentes: 
                    <strong>
                      <?php
                        $result = "SELECT id FROM fornecedores";
                        $resultado = mysqli_query($conn, $result);
                        $linhas = mysqli_num_rows($resultado);
                          echo $linhas;
                      ?>
                    </strong>
                  </span> </a>
              </div>
            </div>

            <div class="new-update clearfix">
              <div class="update-done">
                <a title="Ver mensagens" href="listar_mensagens.php">
                  <span>Quantidade de mensagens recebidas: 
                    <strong>
                      <?php
                        $result = "SELECT id FROM mensagens";
                        $resultado = mysqli_query($conn, $result);
                        $linhas = mysqli_num_rows($resultado);
                          echo $linhas;
                      ?>
                    </strong>
                  </span> </a>
              </div>
            </div>

            <div class="new-update clearfix">
              <div class="update-done">
                <a title="Ver pedidos" href="listar_vendas.php">
                  <span>Quantidade de pedidos efetuados: 
                    <strong>
                      <?php
                        $result = "SELECT id FROM pagamentos";
                        $resultado = mysqli_query($conn, $result);
                        $linhas = mysqli_num_rows($resultado);
                          echo $linhas;
                      ?>
                    </strong>
                  </span> </a>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<?php
  include ('footer_admin.php');
?>

<!--end-Footer-part-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        datasets: [
        {
            label: '2020',
            data: [12, 19, 3, 5, 2, 3, 15, 1, 2, 7, 10, 22],
            borderWidth: 3,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'transparent',
            
        },
        {
            label: '2021',
            data: [12, 19, 3, 5, 2, 9, 15, 1, 2, 7, 10, 22],
            borderWidth: 3,
            borderColor: 'rgba(255, 20, 230, 1)',
            backgroundColor: 'transparent',
            
        }
        ]
    },
    options: {
      title: {
        display: true,
        fontSize: 20,
        text: "Total de vendas por mês"

      },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<script src="js/excanvas.min.js"></script> 
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.flot.min.js"></script> 
<script src="js/jquery.flot.resize.min.js"></script> 
<script src="js/jquery.peity.min.js"></script> 
<script src="js/fullcalendar.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.dashboard.js"></script> 
<script src="js/jquery.gritter.min.js"></script> 
<script src="js/matrix.interface.js"></script> 
<script src="js/matrix.chat.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/matrix.form_validation.js"></script> 
<script src="js/jquery.wizard.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/matrix.popover.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.tables.js"></script> 

<script type="text/javascript">
var ctx = document.getElementById('MelhorPaymentMethod').getContext('2d');
var MelhorPaymentMethod = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [
           <?php
            $result_card = "SELECT * FROM pagamentos WHERE tipo_pg = '1'";
            $resultado_card = mysqli_query($conn, $result_card);
            $linhas_card = mysqli_num_rows($resultado_card);
              if ($linhas_card > 0) {
                  echo '"Cartão de crédito", ';
              }

          ?>
          <?php
            $result_bol = "SELECT * FROM pagamentos WHERE tipo_pg = '2'";
            $resultado_bol = mysqli_query($conn, $result_bol);
            $linhas_bol = mysqli_num_rows($resultado_bol);
              if ($linhas_bol > 0) {
                  echo '"Boleto", ';
              }

          ?>
          <?php
            $result_deb = "SELECT * FROM pagamentos WHERE tipo_pg = '3'";
            $resultado_deb = mysqli_query($conn, $result_deb);
            $linhas_deb = mysqli_num_rows($resultado_deb);
              if ($linhas_deb > 0) {
                  echo '"Débito online", ';
              }

          ?>
        ],
        datasets: [
        {
            data: [
              <?php
                if ($linhas_card > 0) {
                  echo $linhas_card.', ';
                }
                if ($linhas_bol > 0) {
                  echo $linhas_bol.', ';
                }
                if ($linhas_deb > 0) {
                  echo $linhas_deb.', ';
                }

              ?>
            ],
            borderWidth: 1,
              borderColor: [
                  'white',
                  'white',
                  'white',
                  'white',
                  'white'
              ],
            backgroundColor: [
                  '#ff6384',
                  'purple',
                  '#488c13',
                  '#ffeb3b',
                  '#154499'
              ],
            
        },
        ]
    },
});
</script>

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
