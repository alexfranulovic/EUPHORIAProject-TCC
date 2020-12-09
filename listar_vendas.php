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
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
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
  include ('processa/functions.php');

  $result = "SELECT * FROM pagamentos ORDER BY 'id'";
  $resultado = mysqli_query($conn, $result);
?>

<!--main-container-part-->
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="administrativo.php" title="Ir para a home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Listar Vendas</a> </div>
    <h1>Listar Vendas</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <?php
        if(isset($_SESSION['msg'])){
          echo $_SESSION['msg'];
          unset($_SESSION['msg']);
        }
        ?>
      <div class="widget-box">
          <div class="widget-title"> 
            <span class="icon"><i class="icon-th"></i></span>
            <h5>Tabela Vendas</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Referência</th>
                  <th class='hidden-phone'>Tipo</th>
                  <th class='hidden-phone'>Código</th>
                  <th>Status</th>
                  <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    while($linhas = mysqli_fetch_assoc($resultado)){
                      $reference = $linhas['reference'];
                      $result_atend = mysqli_query($conn, "SELECT * FROM atendimentos WHERE reference_id ='$reference'");
                      $row_atend = mysqli_fetch_assoc($result_atend);
                        
                        echo "<tr class='gradeX'>";
                        echo "<td class='center'>".$linhas['id']."</td>";
                        echo "<td>".$linhas['reference']."</td>";
                        echo "<td class='hidden-phone'>";if ($linhas['tipo_pg'] == 1) echo "Cartão de crédito"; elseif($linhas['tipo_pg'] == 2) echo "Boleto"; else echo"Débito online"; echo"</td>";

                        echo "<td class='hidden-phone'>".$linhas['cod_trans']."</td>";
                        echo "<td>".statusEchoAtend($row_atend['status_atendimento'])."</td>";

                        ?>
                        <td> 
                        <a class="tip-bottom" title="Visualizar" href='invoice.php?id=<?php echo $linhas['reference']; ?>'><i style="color: blue;" class="icon-eye-open"></i></a>
                        
                        <a class="tip-bottom" title="Editar" href='editar_venda.php?id=<?php echo $linhas['reference']; ?>'><i style="color: orange;" class="icon-pencil"></i></a>
                        </td>
                        
                        <?php
                      echo "</tr>";
                    }
                  ?>
                
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
</div>
</div>
<!--main-container-part-->

<!--Footer-part-->
<?php
  include ('footer_admin.php');
?>
<!--end-Footer-part-->
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script>
</body>
</html>
