<?php
	session_start();
	include_once("seguranca.php");
	include_once("../conexao.php");
	include("../../processa/configuracao.php");
	require("../lib/lib_env_email.php");


	$id = 				$_POST["id"];
	$rastreio_dev = 	$_POST["rastreio_dev"];
	$rastreio = 		$_POST["rastreio"];
	$cod_trans = 		$_POST["cod_trans"];
	$status_atend = 	$_POST["status_atend"];
	
	$result = mysqli_query($conn, "SELECT * FROM pagamentos WHERE cod_trans = '$cod_trans'");
	$resultado = mysqli_fetch_assoc($result);
	$reference = $resultado['reference'];

	$result_atend = mysqli_query($conn, "SELECT * FROM atendimentos WHERE reference_id = '$id'");
	$resultado_atend = mysqli_fetch_assoc($result_atend);
	$rastreio_id = $resultado_atend['rastreio'];
	$rastreio_dev_id = $resultado_atend['rastreio_dev'];
	
	if(isset($_POST["cancel_refund"])){
		$cancel_refund = 	$_POST["cancel_refund"];
	
		if ($cancel_refund != '') {

			if ($resultado['status_pag'] == 3 || $resultado['status_pag'] == 4 || $resultado['status_pag'] == 5) {

				$Url = URL_CANCELA."refunds?email=".EMAIL_PAGSEGURO."&token=".TOKEN_PAGSEGURO."&transactionCode={$cod_trans}";

				$Curl=curl_init($Url);
				curl_setopt($Curl,CURLOPT_HTTPHEADER,Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
				curl_setopt($Curl,CURLOPT_POST,true);
				curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,true);
				curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
				$Retorno=curl_exec($Curl);
				curl_close($Curl);

				$Xml=simplexml_load_string($Retorno);
				
				//var_dump($Xml);

				$nome = $resultado['nome'];
				$email = $resultado['email'];

				$assunto = "Estorno de pagamento";

				$mensagem = "Olá, " . $nome . "!<br><br>";
				$mensagem .= "Você solicitou estorno de uma compra.<br>";
				$mensagem .= "Sua referência de pedido é: ".$reference.".<br><br>"; 
				$mensagem .= "Em caso de arrependimento, não haverá volta e será necessária a realização de um novo pedido.<br>";
				$mensagem .= "<strong>Deve-se levar em consideração que talvez não teremos mais o produto em estoque, não haverá nada que possa ser feito em relação a este fato.</strong><br><br>";

				$mensagem .= "Nós da EUPHORIA GROUP prezamos para uma ótima experiência e qualidade para nossos clientes, então se houve alguma situação desagradável contigo, gostaríamos que entrasse em contato conosco para esclarecer o ocorrido.<br><br>";
				$mensagem .= "Respeitosamente, EUPHORIA GROUP.<br>";
				$mensagem_texo = $mensagem;

			    email_phpmailer($assunto, $mensagem, $mensagem_texo, $nome, $email, $conn);

			}elseif($resultado['status_pag'] == 1 || $resultado['status_pag'] == 2) {

				$Url = URL_CANCELA."cancels?email=".EMAIL_PAGSEGURO."&token=".TOKEN_PAGSEGURO."&transactionCode={$cod_trans}";

				$Curl=curl_init($Url);
				curl_setopt($Curl,CURLOPT_HTTPHEADER,Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
				curl_setopt($Curl,CURLOPT_POST,true);
				curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,true);
				curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
				$Retorno=curl_exec($Curl);
				curl_close($Curl);

				$Xml=simplexml_load_string($Retorno);
				
				//var_dump($Xml);
				$nome = $resultado['nome'];
				$email = $resultado['email'];

				$assunto = "Cancelamento de pagamento";

				$mensagem = "Olá, " . $nome . "!<br><br>";
				$mensagem .= "Você solicitou cancelamento de uma compra.<br>";
				$mensagem .= "Sua referência de pedido é: ".$reference.".<br><br>"; 
				$mensagem .= "Em caso de arrependimento, não haverá volta e será necessária a realização de um novo pedido.<br>";
				$mensagem .= "<strong>Deve-se levar em consideração que talvez não teremos mais o produto em estoque, não haverá nada que possa ser feito em relação a este fato.</strong><br><br>";

				$mensagem .= "Nós da EUPHORIA GROUP prezamos para uma ótima experiência e qualidade para nossos clientes, então se houve alguma situação desagradável contigo, gostaríamos que entrasse em contato conosco para esclarecer o ocorrido.<br><br>";
				$mensagem .= "Respeitosamente, EUPHORIA GROUP.<br>";
				$mensagem_texo = $mensagem;

			    email_phpmailer($assunto, $mensagem, $mensagem_texo, $nome, $email, $conn);

			}

			}else{

			if ($rastreio_id != $rastreio) {
				$nome = $resultado['nome'];
			    $email = $resultado['email'];

			    $assunto = "Rastreie seu pedido!";

				$mensagem = "Olá, " . $nome . "!<br><br>";
				$mensagem .= "O seu pedido recebeu um código de rastreio do Correios!<br>";
				$mensagem .= "Sua referência de pedido é: ".$reference.".<br><br>"; 
				$mensagem .= "O seu produto foi postado e possui o código de: <strong>".$rastreio."</strong>.<br><br>";

				$mensagem .= "Respeitosamente, EUPHORIA GROUP.<br>";
				$mensagem_texo = $mensagem;

			    email_phpmailer($assunto, $mensagem, $mensagem_texo, $nome, $email, $conn);
			}

			if ($rastreio_dev_id != $rastreio_dev) {
				$nome = $resultado['nome'];
			    $email = $resultado['email'];

			    $assunto = "Cód de rastreio para devolução!";

				$mensagem = "Olá, " . $nome . "!<br><br>";
				$mensagem .= "O seu pedido recebeu um código de rastreio para devolução do Correios!<br>";
				$mensagem .= "Sua referência de pedido é: ".$reference.".<br><br>"; 
				$mensagem .= "O seu produto deverá ter esse código para efetuar a devolução: <strong>".$rastreio_dev."</strong>.<br><br>";
				$mensagem .= "Nós da EUPHORIA GROUP prezamos para uma ótima experiência e qualidade para nossos clientes, então se houve alguma situação desagradável contigo, gostaríamos que entrasse em contato conosco para esclarecer o ocorrido.<br><br>";

				$mensagem .= "Respeitosamente, EUPHORIA GROUP.<br>";
				$mensagem_texo = $mensagem;

			    email_phpmailer($assunto, $mensagem, $mensagem_texo, $nome, $email, $conn);
			}
		}
	}

	$result = mysqli_query($conn, "UPDATE atendimentos set rastreio_dev ='$rastreio_dev', rastreio ='$rastreio', status_atendimento ='$status_atend', modified = NOW() WHERE reference_id='$id'");

	if(mysqli_affected_rows($conn)){
		$_SESSION['msg'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Successo!</strong> Venda editada com sucesso.</div>';
    	header("Location: ../listar_vendas.php"); 
        //echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../listar_vendas.php'>"; 
	}else{
		$_SESSION['msg'] = '<div class="alert alert-error">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Erro!</strong> Venda não foi editada com sucesso.</div>';
        header("Location: ../listar_vendas.php"); 
        //echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../listar_vendas.php'>"; 
	}

	?>