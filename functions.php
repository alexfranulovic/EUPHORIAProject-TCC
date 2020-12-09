<?php
	function limpar_texto($str){ 
	  return preg_replace("/[^0-9]/", "", $str); 
	}

	function formatCnpjCpf($value){
	  $cnpj_cpf = preg_replace("/\D/", '', $value);
	  
	  if (strlen($cnpj_cpf) === 11) {
	    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
	  } 
	  
	  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
	}

	function formatTelefone($value){
	  if (strlen($value) === 11) {
	    return preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2-\$3", $value);
	  } 
	  elseif (strlen($value) === 10) {
	    return preg_replace("/(\d{2})(\d{4})(\d{4})/", "(\$1) \$2-\$3", $value);
	  }
	}

	function formatCep($value){
	    return preg_replace("/(\d{2})(\d{3})(\d{3})/", "\$1.\$2-\$3", $value);
	}

	function formatData($value){
	    return date('d/m/Y - H:i:s', strtotime($value));
	}

	function formatPrecoFrete($value){
	  $preco = preg_replace("/\D/", '', $value);
	  
	  if (strlen($preco) === 4) {
	    return preg_replace("/(\d{2})(\d{2})/", "\$1.\$2", $preco);
	  } 
	  elseif (strlen($preco) === 5) {
	    return preg_replace("/(\d{3})(\d{2})/", "\$1.\$2", $preco);
	  } 
	  elseif (strlen($preco) === 3) {
	  	return preg_replace("/(\d{1})(\d{2})/", "\$1.\$2", $preco);
	  }
	}

	function statusEchoPagseguro($value){
		switch($value){
			case 1:
			return 'Aguardando pagamento';
			break;
					
			case 2:
			return 'Em análise';
			break;
					
			case 3:
			return 'Paga';
			break;
					
			case 4:
			return 'Disponível';
			break;
					
			case 5:
			return 'Em disputa';
			break;
					
			case 6:
			return 'Devolvida';
			break;

			case 7:
			return 'Cancelada';
			break;

			case 8:
			return 'Debitado';
			break;

			case 9:
			return 'Retenção temporária';
			break;
					
		}
	}

	function statusEchoAtend($value){
		switch($value){
			case 1:
			return 'Aguardando pagamento';
			break;
					
			case 2:
			return '<font color="orange">Em preparação<font>';
			break;
					
			case 3:
			return '<font color="#0dcc00">Objeto postado<font>';
			break;
					
			case 4:
			return '<font color="red">Reclamação aberta<font>';
			break;
					
			case 5:
			return 'Entregue';
			break;
					
			case 6:
			return 'Devolvida';
			break;

			case 7:
			return 'Cancelada';
			break;

			case 8:
			return '<font color="#0dcc00">Pagamento aprovado<font>';
			break;
					
		}
	}

	function tipoEstoqueEcho($value){
		switch($value){
			case 1:
			return 'Simples';
			break;
					
			case 2:
			return 'Composto';
			break;
					
			case 3:
			return 'Simples (encomenda)';
			break;
					
			case 4:
			return 'Composto (encomenda)';
			break;
					
		}
	}

	function vazio($dados){
	    $dados_st = array_map('strip_tags', $dados);
	    $dados_tr = array_map('trim', $dados_st);
	    if(in_array('', $dados_tr)){
	        return false;
	    }else{
	        return $dados_tr;
	    }
	}

?>