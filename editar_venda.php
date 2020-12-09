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
  $id = $_GET['id'];
  //Executa consulta
  $result = mysqli_query($conn, "SELECT * FROM pagamentos WHERE reference = '$id'");
  $row = mysqli_fetch_assoc($result);
  $reference = $row['reference'];
  $usuario_id = $row['usuario_id'];
  $tipo_pg = $row['tipo_pg'];
?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Ir para home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Listar vendas</a> <a href="#" class="current">Fatura</a> </div>
    <h1>Fatura</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <?php
        $result_prod = mysqli_query($conn, "SELECT * FROM pagamentos WHERE reference = '$id'");
        if(($result_prod) AND ($result_prod->num_rows == 0)){
          echo'
            <div class="widget-box">
            <div class="widget-title"> 
              <span class="icon"><i class="icon-th"></i></span>
              <h5>Cliente</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered table-striped">
                <tbody>
                    <tr class="odd gradeX">
                      <td><b>Não existe nenhum pedido cadastrado com este ID.</b></td>           
                    </tr>
                </tbody>
              </table>
            </div>
          </div>';

        }else{
        ?>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
            <h5>Cliente</h5>
            <div class="pull-right" style=" font-size: 20px; ">
              <a href="invoice.php?id=<?php echo $row['reference']; ?>" title="Editar produto">
                <span class="icon"><i style="color: blue;" class="icon-eye-open"></i></span>
              </a>
              <a href="listar_vendas.php" title="Listar produto">
                <span class="icon"><i style="color: green;" class="icon-reorder"></i></span>
              </a>
            </div>
          </div>
<!------------------------------------------------------------------------------------------------------------------------------->
          <?php if ($tipo_pg == 1) { ?>
          <div class="widget-content">
            <form method="POST" action="processa/processa_edit_venda.php">
              <input type="hidden" name="id" value="<?php echo $row['reference']; ?>" />
              <input type="hidden" name="cod_trans" value="<?php echo $row['cod_trans']; ?>" />
<!------------------------------------------------------------------------------------------------------------------------------->
            <div class="row-fluid">
              <div class="span6">
                <?php                
                  $result_end = mysqli_query($conn, "SELECT * FROM atendimentos WHERE reference_id = '$reference'");
                  $row_atend = mysqli_fetch_assoc($result_end);
                ?>

                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                      <td class="width30">Nome:</td>
                      <td class="width70"><strong><?php echo $row['nome']; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Telefone:</td>
                      <td><?php echo formatTelefone($row['telefone']); ?></td>
                    </tr>
                    <tr>
                      <td>E-mail:</td>
                      <td><?php echo $row['email']; ?></td>
                    </tr>
                    <tr>
                      <td class="width30">Endereço de entrega:</td>
                      <td><?php echo $row_atend['endereco'].', '.$row_atend['numero'].' '.$row_atend['complemento'].' - '.$row_atend['bairro'].' - '.$row_atend['cidade'].' - '.$row_atend['uf'].'<br>C.E.P: '.formatCep($row_atend['cep']) ;?>   
                      </td>
                    </tr>
                    <tr>
                      <td class="width30">Endereço dono cartão:</td>
                      <td class="width70">
                      <?php echo $row['billing_endereco'].', '.$row['billing_numero'].' '.$row['billing_complemento'].' - '.$row['billing_bairro'].' - '.$row['billing_cidade'].' - '.$row['billing_uf'].'<br>C.E.P: '.formatCep($row['billing_cep']) ;?>
                        
                      </td>
                    </tr>
                    <tr>
                      <td>Frete e prazo:</td>
                      <td><?php
                            if($row['tipo_frete'] == 1){
                              echo 'PAC / R$ ';
                            }if($row['tipo_frete'] == 2){
                              echo 'SEDEX / R$ ';
                            }if($row['tipo_frete'] == 3){
                              echo 'Sem frete / R$ ';
                            }
                            echo number_format($row['valor_frete'],2,",",".").' - prazo de: '; 
                            if ($row_atend['prazo'] == 0) {
                              echo "A combinar.";
                            }else{
                              echo $row_atend['prazo'].' dias.';
                            }
                          ?> 
                      </td>
                    </tr>
                    <?php
                      if ($row['status_pag'] == 3) {   
                        $status_id = $row_atend['status_atendimento'];
                        echo'              
                        <tr>
                          <td>Editar status:</td>
                          <td>
                            <select name="status_atend" class="span11" style="margin: 0px;">';
                              $result_status = mysqli_query($conn, "SELECT * FROM status_atendimento WHERE id ='$status_id' OR escalao ='2'");
                              while($row_status = mysqli_fetch_assoc($result_status)){
                                $id_status = $row_status['id'];
                                echo "<option value=".$row_status['id']; if($id_status == $status_id){ echo ' selected'; } echo">".$row_status['nome']."</option>";
                              }
                            echo'
                            </select>
                          </td>
                        </tr>';
                      }
                    ?>
                  </tbody>   
                </table>
              </div>

              <div class="span6">
                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                      <td class="width30">Cód Transação:</td>
                      <td class="width70"><strong><?php echo $row['cod_trans']; ?></strong></td>
                    </tr>
                    <tr>
                      <td class="width30">Referência:</td>
                      <td class="width70"><strong><?php echo $row['reference']; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Data da compra:</td>
                      <td><strong><?php echo formatData($row['created']); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Data de mudança:</td>
                      <td><strong><?php echo formatData($row['data_transacao']); ?></strong></td>
                    </tr>
                    <tr>
                      <td class="width30">Tipo de pagamento:</td>
                      <td class="width70">
                        <strong>Cartão de crédito em </strong><?php echo $row['vezes_cartao'].'X de R$ '.number_format($row['valor_parcela'],2,",","."); ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Status da transação:</td>
                      <td><strong><?php echo statusEchoPagseguro($row['status_pag']); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Status da compra:</td>
                      <td><strong><?php echo statusEchoAtend($row_atend['status_atendimento']); ?></strong></td>
                    </tr>
                    <?php
                      if ($row['status_pag'] == 3 || $row['status_pag'] == 4 || $row['status_pag'] == 5) {   
                        echo'              
                        <tr>
                          <td>Ações:</td>
                          <td>
                            <label class="checkbox" style="margin-bottom: 0px;">
                              <input name="cancel_refund" id="Estornar" value="Estornar" type="checkbox"> Estornar
                            </label>
                          </td>
                        </tr>';
                      }elseif ($row['status_pag'] == 1 || $row['status_pag'] == 2) {   
                        echo'              
                        <tr>
                          <td>Ações:</td>
                          <td>
                            <label class="checkbox" style="margin-bottom: 0px;">
                              <input name="cancel_refund" id="Cancelar" value="Cancelar" type="checkbox"> Cancelar
                            </label>
                          </td>
                        </tr>';
                      }
                    ?>
                  </tbody>
                  
                </table>
              </div>
            </div>
<!------------------------------------------------------------------------------------------------------------------------------->
            <div class="row-fluid">
              <div class="span12">
                
                <div class="span6">              
                  <div class="control-group">
                    <label for="normal" class="control-label">Cód. de rastreio:</label>
                    <div class="controls">
                      <input type="text" minlength="13" maxlength="14" name="rastreio" class="span12" placeholder="Cód. de rastreio" value="<?php echo $row_atend['rastreio']; ?>">
                    </div>
                  </div>
                </div>

                <div class="span6">
                  <div class="control-group">
                    <label for="normal" class="control-label">Cód. de rastreio devolução:</label>
                    <div class="controls">
                      <input type="text" minlength="13" maxlength="14" name="rastreio_dev" class="span12" placeholder="Cód. de rastreio devolução" value="<?php echo $row_atend['rastreio_dev']; ?>">
                    </div>
                  </div>
                </div>

                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th class="head0">Id</th>
                      <th class="head1">Nome</th>
                      <th class="head0 right">Preço</th>
                      <th class="head1 right">Quantidade</th>
                      <th class="head0 right">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result_produtos = mysqli_query($conn, "SELECT * FROM venda WHERE reference_id = '$reference'");

                    while($linhas = mysqli_fetch_assoc($result_produtos)){

                      echo "<tr>";
                      echo "<td>".$linhas['produto_id']."</td>";
                      echo "<td>".$linhas['nome_prod']."</td>";
                      echo "<td>R$ ".number_format($linhas['preco'],2,",",".")."</td>";
                      echo "<td>".$linhas['quantidade']."</td>";

                      $sub = $linhas['quantidade'] * $linhas['preco'];

                      echo "<td>R$ ".number_format($sub,2,",",".")."</td>";

                      echo "</tr>";
                    }

                    ?>
                  </tbody>
                </table>

                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th>Ações</th>
                      <th>Parcelas</th>
                      <th>Valor parcela</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="msg-invoice" >
                        <a href="http://www.correios.com.br/" class="tip-bottom" title="Site Correios">Site Correios</a> | 
                          <br class="hidden-desktop"> 
                        <a href="https://pagseguro.uol.com.br/" class="tip-bottom" title="PagSeguro">PagSeguro</a> |
                          <br class="hidden-desktop"> 
                        <a href="chat.php?id=<?php echo $row['reference']; ?>" class="tip-bottom" title="Chat">Ver mensagens</a>
                      <td class="right">
                        <?php echo $row['vezes_cartao']."X"; ?>
                      </td>
                      <td class="right">
                        R$ <?php 
                            echo number_format($row['valor_parcela'],2,",","."); 
                          ?>   
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="form-actions">
                  <button type="submit" class="btn btn-success">Editar</button>
                </div>

              </div>
            </form>
<!------------------------------------------------------------------------------------------------------------------------------->
          </div>
        <?php }elseif ($tipo_pg == 2) { ?>
          <div class="widget-content">
            <form method="POST" action="processa/processa_edit_venda.php">
              <input type="hidden" name="id" value="<?php echo $row['reference']; ?>" />
              <input type="hidden" name="cod_trans" value="<?php echo $row['cod_trans']; ?>" />
<!------------------------------------------------------------------------------------------------------------------------------->
            <div class="row-fluid">
              <div class="span6">

                <?php                
                  $result_end = mysqli_query($conn, "SELECT * FROM atendimentos WHERE reference_id = '$reference'");
                  $row_atend = mysqli_fetch_assoc($result_end);
                ?>

                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                      <td class="width30">Nome:</td>
                      <td class="width70"><strong><?php echo $row['nome']; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Telefone:</td>
                      <td><?php echo formatTelefone($row['telefone']); ?></td>
                    </tr>
                    <tr>
                      <td>E-mail:</td>
                      <td><?php echo $row['email']; ?></td>
                    </tr>
                    <tr>
                      <td class="width30">Endereço de entrega:</td>
                      <td><?php echo $row_atend['endereco'].', '.$row_atend['numero'].' '.$row_atend['complemento'].' - '.$row_atend['bairro'].' - '.$row_atend['cidade'].' - '.$row_atend['uf'].'<br>C.E.P: '.formatCep($row_atend['cep']) ;?>   
                      </td>
                    </tr>
                    <tr>
                      <td>Frete:</td>
                      <td><?php
                            if($row['tipo_frete'] == 1){
                              echo 'PAC / R$ ';
                            }if($row['tipo_frete'] == 2){
                              echo 'SEDEX / R$ ';
                            }if($row['tipo_frete'] == 3){
                              echo 'Sem frete / R$ ';
                            }
                            echo number_format($row['valor_frete'],2,",",".").' - prazo de: '; 
                            if ($row_atend['prazo'] == 0) {
                              echo "A combinar.";
                            }else{
                              echo $row_atend['prazo'].' dias.';
                            }
                          ?> 
                      </td>
                    </tr>
                    <?php
                      if ($row['status_pag'] == 3) {   
                        $status_id = $row_atend['status_atendimento'];
                        echo'              
                        <tr>
                          <td>Editar status:</td>
                          <td>
                            <select name="status_atend" class="span11" style="margin: 0px;">';
                              $result_status = mysqli_query($conn, "SELECT * FROM status_atendimento WHERE id ='$status_id' OR escalao ='2'");
                              while($row_status = mysqli_fetch_assoc($result_status)){
                                $id_status = $row_status['id'];
                                echo "<option value=".$row_status['id']; if($id_status == $status_id){ echo ' selected'; } echo">".$row_status['nome']."</option>";
                              }
                            echo'
                            </select>
                          </td>
                        </tr>';
                      }
                    ?>
                  </tbody>   
                </table>
              </div>

              <div class="span6">
                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                      <td class="width30">Cód Transação:</td>
                      <td class="width70"><strong><?php echo $row['cod_trans']; ?></strong></td>
                    </tr>
                    <tr>
                      <td class="width30">Referência:</td>
                      <td class="width70"><strong><?php echo $row['reference']; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Data da compra:</td>
                      <td><strong><?php echo formatData($row['created']); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Data de mudança:</td>
                      <td><strong><?php echo formatData($row['data_transacao']); ?></strong></td>
                    </tr>
                    <tr>
                      <td class="width30">Tipo de pagamento:</td>
                      <td class="width70">
                        <strong>Boleto</strong>
                      </td>
                    </tr>
                    <tr>
                      <td>Status da transação:</td>
                      <td><strong><?php echo statusEchoPagseguro($row['status_pag']); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Status da compra:</td>
                      <td><strong><?php echo statusEchoAtend($row_atend['status_atendimento']); ?></strong></td>
                    </tr>
                    <?php
                      if ($row['status_pag'] == 3 || $row['status_pag'] == 4 || $row['status_pag'] == 5) {   
                        echo'              
                        <tr>
                          <td>Ações:</td>
                          <td>
                            <label class="checkbox" style="margin-bottom: 0px;">
                              <input name="cancel_refund" id="Estornar" value="Estornar" type="checkbox"> Estornar
                            </label>
                          </td>
                        </tr>';
                      }elseif ($row['status_pag'] == 1 || $row['status_pag'] == 2) {   
                        echo'              
                        <tr>
                          <td>Ações:</td>
                          <td>
                            <label class="checkbox" style="margin-bottom: 0px;">
                              <input name="cancel_refund" id="Cancelar" value="Cancelar" type="checkbox"> Cancelar
                            </label>
                          </td>
                        </tr>';
                      }
                    ?>
                  </tbody>
                  
                </table>
              </div>
            </div>
<!------------------------------------------------------------------------------------------------------------------------------->
            <div class="row-fluid">
              <div class="span12">
                
                <div class="span6">              
                  <div class="control-group">
                    <label for="normal" class="control-label">Cód. de rastreio:</label>
                    <div class="controls">
                      <input type="text" minlength="13" maxlength="14" name="rastreio" class="span12" placeholder="Cód. de rastreio" value="<?php echo $row_atend['rastreio']; ?>">
                    </div>
                  </div>
                </div>

                <div class="span6">
                  <div class="control-group">
                    <label for="normal" class="control-label">Cód. de rastreio devolução:</label>
                    <div class="controls">
                      <input type="text" minlength="13" maxlength="14" name="rastreio_dev" class="span12" placeholder="Cód. de rastreio devolução" value="<?php echo $row_atend['rastreio_dev']; ?>">
                    </div>
                  </div>
                </div>

                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th class="head0">Id</th>
                      <th class="head1">Nome</th>
                      <th class="head0 right">Preço</th>
                      <th class="head1 right">Quantidade</th>
                      <th class="head0 right">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result_produtos = mysqli_query($conn, "SELECT * FROM venda WHERE reference_id = '$reference'");

                    while($linhas = mysqli_fetch_assoc($result_produtos)){

                      echo "<tr>";
                      echo "<td>".$linhas['produto_id']."</td>";
                      echo "<td>".$linhas['nome_prod']."</td>";
                      echo "<td>R$ ".number_format($linhas['preco'],2,",",".")."</td>";
                      echo "<td>".$linhas['quantidade']."</td>";

                      $sub = $linhas['quantidade'] * $linhas['preco'];

                      echo "<td>R$ ".number_format($sub,2,",",".")."</td>";

                      echo "</tr>";
                    }

                    ?>
                  </tbody>
                </table>

                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th>Ações</th>
                      <th >Taxa</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="msg-invoice" >
                        <a href="<?php echo $row['link_boleto_do']; ?>" class="tip-bottom" title="Ver boleto">Ver boleto</a> |  
                          <br class="hidden-desktop">
                        <a href="http://www.correios.com.br/" class="tip-bottom" title="Site Correios">Site Correios</a> | 
                          <br class="hidden-desktop"> 
                        <a href="https://pagseguro.uol.com.br/" class="tip-bottom" title="PagSeguro">PagSeguro</a> |
                          <br class="hidden-desktop"> 
                        <a href="chat.php?id=<?php echo $row['reference']; ?>" class="tip-bottom" title="Chat">Ver mensagens</a>
                      <td class="right">
                        R$ 1,00
                      </td>
                      <td class="right">
                        R$ <?php 
                            echo number_format($row['total'],2,",","."); 
                        ?>   
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="form-actions">
                  <button type="submit" class="btn btn-success">Editar</button>
                </div>

              </div>
            </form>
<!------------------------------------------------------------------------------------------------------------------------------->
          </div>
        <?php }elseif ($tipo_pg == 3) {?>
          <div class="widget-content">
            <form method="POST" action="processa/processa_edit_venda.php">
              <input type="hidden" name="id" value="<?php echo $row['reference']; ?>" />
              <input type="hidden" name="cod_trans" value="<?php echo $row['cod_trans']; ?>" />
<!------------------------------------------------------------------------------------------------------------------------------->
            <div class="row-fluid">
              <div class="span6">

                <?php                
                  $result_end = mysqli_query($conn, "SELECT * FROM atendimentos WHERE reference_id = '$reference'");
                  $row_atend = mysqli_fetch_assoc($result_end);
                ?>

                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                      <td class="width30">Nome:</td>
                      <td class="width70"><strong><?php echo $row['nome']; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Telefone:</td>
                      <td><?php echo formatTelefone($row['telefone']); ?></td>
                    </tr>
                    <tr>
                      <td>E-mail:</td>
                      <td><?php echo $row['email']; ?></td>
                    </tr>
                    <tr>
                      <td class="width30">Endereço de entrega:</td>
                      <td><?php echo $row_atend['endereco'].', '.$row_atend['numero'].' '.$row_atend['complemento'].' - '.$row_atend['bairro'].' - '.$row_atend['cidade'].' - '.$row_atend['uf'].'<br>C.E.P: '.formatCep($row_atend['cep']) ;?>   
                      </td>
                    </tr>
                    <tr>
                      <td>Frete:</td>
                      <td><?php
                            if($row['tipo_frete'] == 1){
                              echo 'PAC / R$ ';
                            }if($row['tipo_frete'] == 2){
                              echo 'SEDEX / R$ ';
                            }if($row['tipo_frete'] == 3){
                              echo 'Sem frete / R$ ';
                            }
                            echo number_format($row['valor_frete'],2,",",".").' - prazo de: '; 
                            if ($row_atend['prazo'] == 0) {
                              echo "A combinar.";
                            }else{
                              echo $row_atend['prazo'].' dias.';
                            }
                          ?> 
                      </td>
                    </tr>
                    <?php
                      if ($row['status_pag'] == 3) {   
                        $status_id = $row_atend['status_atendimento'];
                        echo'              
                        <tr>
                          <td>Editar status:</td>
                          <td>
                            <select name="status_atend" class="span11" style="margin: 0px;">';
                              $result_status = mysqli_query($conn, "SELECT * FROM status_atendimento WHERE id ='$status_id' OR escalao ='2'");
                              while($row_status = mysqli_fetch_assoc($result_status)){
                                $id_status = $row_status['id'];
                                echo "<option value=".$row_status['id']; if($id_status == $status_id){ echo ' selected'; } echo">".$row_status['nome']."</option>";
                              }
                            echo'
                            </select>
                          </td>
                        </tr>';
                      }
                    ?>
                  </tbody>   
                </table>
              </div>

              <div class="span6">
                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                      <td class="width30">Cód Transação:</td>
                      <td class="width70"><strong><?php echo $row['cod_trans']; ?></strong></td>
                    </tr>
                    <tr>
                      <td class="width30">Referência:</td>
                      <td class="width70"><strong><?php echo $row['reference']; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Data da compra:</td>
                      <td><strong><?php echo formatData($row['created']); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Data de mudança:</td>
                      <td><strong><?php echo formatData($row['data_transacao']); ?></strong></td>
                    </tr>
                    <tr>
                      <td class="width30">Tipo de pagamento:</td>
                      <td class="width70">
                        <strong>Débito online</strong>
                      </td>
                    </tr>
                    <tr>
                      <td>Status da transação:</td>
                      <td><strong><?php echo statusEchoPagseguro($row['status_pag']); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Status da compra:</td>
                      <td><strong><?php echo statusEchoAtend($row_atend['status_atendimento']); ?></strong></td>
                    </tr>
                    <?php
                      if ($row['status_pag'] == 3 || $row['status_pag'] == 4 || $row['status_pag'] == 5) {   
                        echo'              
                        <tr>
                          <td>Ações:</td>
                          <td>
                            <label class="checkbox" style="margin-bottom: 0px;">
                              <input name="cancel_refund" id="Estornar" value="Estornar" type="checkbox"> Estornar
                            </label>
                          </td>
                        </tr>';
                      }elseif ($row['status_pag'] == 1 || $row['status_pag'] == 2) {   
                        echo'              
                        <tr>
                          <td>Ações:</td>
                          <td>
                            <label class="checkbox" style="margin-bottom: 0px;">
                              <input name="cancel_refund" id="Cancelar" value="Cancelar" type="checkbox"> Cancelar
                            </label>
                          </td>
                        </tr>';
                      }
                    ?>
                  </tbody>
                  
                </table>
              </div>
            </div>
<!------------------------------------------------------------------------------------------------------------------------------->
            <div class="row-fluid">
              <div class="span12">

                <div class="span6">              
                  <div class="control-group">
                    <label for="normal" class="control-label">Cód. de rastreio:</label>
                    <div class="controls">
                      <input type="text" minlength="13" maxlength="14" name="rastreio" class="span12" placeholder="Cód. de rastreio" value="<?php echo $row_atend['rastreio']; ?>">
                    </div>
                  </div>
                </div>

                <div class="span6">
                  <div class="control-group">
                    <label for="normal" class="control-label">Cód. de rastreio devolução:</label>
                    <div class="controls">
                      <input type="text" minlength="13" maxlength="14" name="rastreio_dev" class="span12" placeholder="Cód. de rastreio devolução" value="<?php echo $row_atend['rastreio_dev']; ?>">
                    </div>
                  </div>
                </div>

                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th class="head0">Id</th>
                      <th class="head1">Nome</th>
                      <th class="head0 right">Preço</th>
                      <th class="head1 right">Quantidade</th>
                      <th class="head0 right">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result_produtos = mysqli_query($conn, "SELECT * FROM venda WHERE reference_id = '$reference'");

                    while($linhas = mysqli_fetch_assoc($result_produtos)){

                      echo "<tr>";
                      echo "<td>".$linhas['produto_id']."</td>";
                      echo "<td>".$linhas['nome_prod']."</td>";
                      echo "<td>R$ ".number_format($linhas['preco'],2,",",".")."</td>";
                      echo "<td>".$linhas['quantidade']."</td>";

                      $sub = $linhas['quantidade'] * $linhas['preco'];

                      echo "<td>R$ ".number_format($sub,2,",",".")."</td>";

                      echo "</tr>";
                    }

                    ?>
                  </tbody>
                </table>

                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th>Ações</th>
                      <th >Taxa</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="msg-invoice" >
                        <a href="<?php echo $row['link_boleto_do']; ?>" class="tip-bottom" title="Link do banco">Link do banco</a> |  
                          <br class="hidden-desktop">
                        <a href="http://www.correios.com.br/" class="tip-bottom" title="Site Correios">Site Correios</a> | 
                          <br class="hidden-desktop"> 
                        <a href="https://pagseguro.uol.com.br/" class="tip-bottom" title="PagSeguro">PagSeguro</a> |
                          <br class="hidden-desktop"> 
                        <a href="chat.php?id=<?php echo $row['reference']; ?>" class="tip-bottom" title="Chat">Ver mensagens</a>
                      <td class="right">
                        R$ 0,00
                      </td>
                      <td class="right">
                        R$ <?php 
                            echo number_format($row['total'],2,",","."); 
                        ?>   
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="form-actions">
                  <button type="submit" class="btn btn-success">Editar</button>
                </div>

              </div>
            </form>
<!------------------------------------------------------------------------------------------------------------------------------->
          </div>
          <?php }?>
<!------------------------------------------------------------------------------------------------------------------------------->
          <?php }?>
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
<script src="js/matrix.js"></script>