<?php
	include "../conexao.php";
	include "functions.php";
	include "../../processa/configuracao.php";
	require("../lib/lib_env_email.php");

	$notificationCode = $_POST['notificationCode'];

	$url = URL_RETORNO.$notificationCode."?email=".EMAIL_PAGSEGURO."&token=".TOKEN_PAGSEGURO;

	$Curl=curl_init($url);
	curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,true);
	curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
	$Retorno=curl_exec($Curl);
	curl_close($Curl);

	$xml=simplexml_load_string($Retorno);

	$status = $xml->status;
	$reference = $xml->reference;
	$lastEventDate = $xml->lastEventDate;

	$result = mysqli_query($conn, "UPDATE pagamentos set status_pag ='$status', data_transacao='$lastEventDate' WHERE reference ='$reference'");

	if ($status == 3) {

		$result_vend = mysqli_query($conn, "SELECT * FROM venda WHERE reference_id = '$reference'");
		while($resultado_vend = mysqli_fetch_assoc($result_vend)){
			$quantidade = $resultado_vend['quantidade'];
			$usuario_id = $resultado_vend['usuario_id'];
			$produto_id = $resultado_vend['produto_id'];
			$tamanho_id = $resultado_vend['tamanho_id'];
/*--------------------------------------------------------------------------------------------------------------------*/
			$result_prod = mysqli_query($conn, "SELECT * FROM produtos WHERE id = '$produto_id'");
			$row_prod = mysqli_fetch_assoc($result_prod);

			$up_pedido_prod = $quantidade + $row_prod['pedido_id'];
			$up_prod = mysqli_query($conn, "UPDATE produtos set pedido_id ='$up_pedido_prod' WHERE id='$produto_id'");
/*--------------------------------------------------------------------------------------------------------------------*/
	        $result_usu = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$usuario_id'");
	        $row_usu = mysqli_fetch_assoc($result_usu); 

	        $up_pedido_usu = $quantidade + $row_usu['pedido_id'];
	        $up_usu = mysqli_query($conn, "UPDATE usuarios set pedido_id ='$up_pedido_usu' WHERE id='$usuario_id'");
/*--------------------------------------------------------------------------------------------------------------------*/
			if ($row_prod['tipo_estoque'] == 1) {

				$estoque_atual = $row_prod['estoque'] - $quantidade;

				if ($estoque_atual <= 0) {
					$result_cart = mysqli_query($conn, "DELETE FROM carrinho WHERE produto_id = '$produto_id'");
					$result = mysqli_query($conn, "UPDATE produtos set estoque ='0', situacao_id = '3', modified = NOW() WHERE id ='$produto_id'");
				}else{
					$result = mysqli_query($conn, "UPDATE produtos set estoque ='$estoque_atual', modified = NOW() WHERE id ='$produto_id'");
				}
					
				$result = mysqli_query($conn, "UPDATE carrinho set quantidade -= '$quantidade', modified = NOW() WHERE produto_id ='$produto_id'");

			}elseif ($row_prod['tipo_estoque'] == 2) {
				$result_sub = mysqli_query($conn, "SELECT * FROM subprodutos WHERE produto_id = '$produto_id' AND id = '$tamanho_id'");
				$row_sub = mysqli_fetch_assoc($result_sub);
				$estoque_atual = $row_sub['quantidade'] - $quantidade;

				if ($estoque_atual <= 0) {
					$estoque_atual = 0;
				}
				$result_sub = mysqli_query($conn, "UPDATE subprodutos set quantidade ='$estoque_atual', modified = NOW() WHERE produto_id = '$produto_id' AND id = '$tamanho_id'");

				$quantidade_estoque = 0;
				$result_sub = mysqli_query($conn, "SELECT * FROM subprodutos WHERE produto_id = '$produto_id'");
				while($resultado_subresult = mysqli_fetch_assoc($result_sub)){
				  $quantidade_estoque += $resultado_subresult['quantidade'];
  				}

				if ($quantidade_estoque <= 0) {
					$result_cart = mysqli_query($conn, "DELETE FROM carrinho WHERE produto_id = '$produto_id'");
					$result_prod = mysqli_query($conn, "UPDATE produtos set situacao_id = '3', modified = NOW() WHERE id ='$produto_id'");
				}

			}/*elseif ($row_prod['tipo_estoque'] == 3) {

				if ($quantidade_final >= 10) {
					$quantidade_final = 10;
				}	
				
			}elseif ($row_prod['tipo_estoque'] == 4) {

				if ($quantidade_final >= 10) {
					$quantidade_final = 10;
				}
			}*/
		}

		$result_status = mysqli_query($conn, "UPDATE atendimentos set status_atendimento = '8', modified = NOW() WHERE reference_id='$reference'");
	}

	if ($status == 6) {

		$result_vend = mysqli_query($conn, "SELECT * FROM venda WHERE reference_id = '$reference'");
		while($resultado_vend = mysqli_fetch_assoc($result_vend)){
			$quantidade = $resultado_vend['quantidade'];
			$produto_id = $resultado_vend['produto_id'];
			$tamanho_id = $resultado_vend['tamanho_id'];

			$result_prod = mysqli_query($conn, "SELECT * FROM produtos WHERE id = '$produto_id'");
			$row_prod = mysqli_fetch_assoc($result_prod);

			if ($row_prod['tipo_estoque'] == 1) {
				$estoque_atual = $row_prod['estoque'] + $quantidade;

				$result = mysqli_query($conn, "UPDATE produtos set estoque ='$estoque_atual', modified = NOW() WHERE id ='$produto_id'");

			}elseif ($row_prod['tipo_estoque'] == 2) {
				$result_sub = mysqli_query($conn, "SELECT * FROM subprodutos WHERE produto_id = '$produto_id' AND id = '$tamanho_id'");
				$row_sub = mysqli_fetch_assoc($result_sub);
				$estoque_atual = $row_sub['quantidade'] + $quantidade;

				/*if ($estoque_atual <= 0) {
					$estoque_atual = 0;
				}*/
				$result_sub = mysqli_query($conn, "UPDATE subprodutos set quantidade ='$estoque_atual', modified = NOW() WHERE produto_id = '$produto_id' AND id = '$tamanho_id'");

				/*$quantidade_estoque = 0;
				$result_sub = mysqli_query($conn, "SELECT * FROM subprodutos WHERE produto_id = '$produto_id'");
				while($resultado_subresult = mysqli_fetch_assoc($result_sub)){
				  $quantidade_estoque += $resultado_subresult['quantidade'];
  				}

				if ($quantidade_estoque <= 0) {
					$result_prod = mysqli_query($conn, "UPDATE produtos set situacao_id = '3', modified = NOW() WHERE id ='$produto_id'");
				}*/

			}/*elseif ($row_prod['tipo_estoque'] == 3) {

				if ($quantidade_final >= 10) {
					$quantidade_final = 10;
				}	
				
			}elseif ($row_prod['tipo_estoque'] == 4) {

				if ($quantidade_final >= 10) {
					$quantidade_final = 10;
				}
			}*/
		}

		$result_status = mysqli_query($conn, "UPDATE atendimentos set status_atendimento = '6', modified = NOW() WHERE reference_id='$reference'");
	}

	if ($status == 7) {
		$result_status = mysqli_query($conn, "UPDATE atendimentos set status_atendimento = '7', modified = NOW() WHERE reference_id='$reference'");
	}

	if ($status != 1) {
		
		$result_pag = mysqli_query($conn, "SELECT * FROM pagamentos WHERE reference = '$reference'");
		$resultado_pag = mysqli_fetch_assoc($result_pag);

		$result_atend = mysqli_query($conn, "SELECT * FROM atendimentos WHERE reference_id = '$reference'");
		$resultado_atend = mysqli_fetch_assoc($result_atend);

		$nome = $resultado_pag['nome'];
		$email = $resultado_pag['email'];

		$assunto = "Status de compra alterado";

		$mensagem = "Olá, " . $nome . "!<br><br>";
		$mensagem .= "O status do seu pedido mudou!.<br>";
		$mensagem .= "Sua referência de pedido é: ".$reference.".<br><br>"; 
		$mensagem .= "O status de seu pedido foi alterado para: <strong>".statusEchoAtend($resultado_atend['status_atendimento'])."</strong>.<br><br>";

		$mensagem .= "Respeitosamente, EUPHORIA GROUP.<br>";
		$mensagem_texo = $mensagem;

	    email_phpmailer($assunto, $mensagem, $mensagem_texo, $nome, $email, $conn);
	}
?>