<?php
include_once("../conexao.php");
$usuariot = $_POST['usuario'];
$senhat = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE (email='$usuariot' OR login='$usuariot') AND senha='".md5($senhat)."' LIMIT 1";
$result = mysqli_query($conn, $sql);
$resultado = mysqli_fetch_assoc($result);

// or email='$usuariot'

if(empty($resultado)){

	$_SESSION['loginErro'] = '<div class="alert alert-danger" role="alert">
				          <button class="close" data-dismiss="alert">×</button>
				          <strong>Erro!</strong> Usuário ou senha inválido
				        </div>';
	
	header("Location: ../login.php");
}else{

	$usuario_id					= $resultado['id'];
	$_SESSION['usuarioId'] 			= $resultado['id'];
	$_SESSION['usuarioNome'] 		= $resultado['nome'];
	$_SESSION['usuarioSobrenome'] 	= $resultado['sobrenome'];
	$_SESSION['usuarioNivelAcesso'] = $resultado['nivel_acesso_id'];
	$_SESSION['usuarioLogin'] 		= $resultado['login'];
	$_SESSION['usuarioSenha'] 		= $resultado['senha'];
	$_SESSION['usuarioEmail'] 		= $resultado['email'];

	if (isset($_SESSION['session_id'])) {
		$session_id = $_SESSION['session_id'];
		$result_cart = mysqli_query($conn, "SELECT * FROM carrinho WHERE session_id = '$session_id'");
		while($row_cart = mysqli_fetch_assoc($result_cart)){
			//echo $row_cart['id']."<br>";
			$carrinho_id = $row_cart['id'];
			$tamanho_id = $row_cart['tamanho_id'];
			$produto_id = $row_cart['produto_id'];
			$quantidade = $row_cart['quantidade'];
			
			$result_cart2 = mysqli_query($conn, "SELECT * FROM carrinho WHERE usuario_id = '$usuario_id' AND tamanho_id = '$tamanho_id' AND produto_id = '$produto_id'");
			$row_cart_count = mysqli_num_rows($result_cart2);
			$row_cart2 = mysqli_fetch_assoc($result_cart2);

			$carrinho_id_antigo = $row_cart2['id'];

			if ($row_cart2 == 0) {

				$result_cartup = mysqli_query($conn, "UPDATE carrinho set usuario_id ='$usuario_id', session_id = NULL, modified = NOW() WHERE id='$carrinho_id'");
			}else{
				$result_cartup = mysqli_query($conn, "UPDATE carrinho set quantidade ='$quantidade', usuario_id ='$usuario_id', session_id = NULL, modified = NOW() WHERE id='$carrinho_id_antigo'");
			}
		}
	}
	
	if($_SESSION['usuarioNivelAcesso'] == 1){
		//echo " <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../adm/administrativo.php'>"; 
		header("Location: ../adm/administrativo.php");
	}else{
		//echo " <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../usuario.php'>"; 
		header("Location: ../usuario.php");
	}
}

?>