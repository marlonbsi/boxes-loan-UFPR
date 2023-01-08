<?php

	/*Ação do formulário de busca de cliente. Direciona para form_editar_cliente
	quando o CPF é encontrado*/
	
	include '../classes/Conexao.php';
	include '../classes/Cliente.php';
	include '../classes/Session.php';
	include 'isCpfValid.php';
	
	$session = new Session;
	$session->inicia();
	
	$objCon = new Conexao;
	$con = $objCon->conecta();
	
	$idCliente = null;
	$nivel = null;

	if(isset($_POST['submit'])) {
		$cliente = new Cliente;
		if(isset($_POST['cliente_cpf'])) {
			$num = 0;
			$j = 0;
			$cpf = $_POST['cliente_cpf'];
			$ehValido = isCpfValid($cpf);
			if($ehValido){
				//retira pontos e traços
				for($i=0; $i<(strlen($cpf)); $i++){
					if(is_numeric($cpf[$i])){
							$num = $num.$cpf[$i];
							$j++;
						}
				}
				$cpf = $num;
			}
			$cli_selecionado = $cliente->validaLogin($cpf);
			if ($cli_selecionado <> null){
				while($var = $cli_selecionado->fetch_assoc()){
					$idCliente = $var["id_cliente"];
					$nivel = $var["nivel"];
				}
				$_SESSION['idCliente'] = $idCliente;
				$_SESSION['nivel'] = $nivel;
				header("Location: ../caixas/listall_caixa.php");
			} else{
				header("Location: ../caixas/listall_caixa.php"); //dar mensagem??
			}
		} else{
			echo "Para continuar você deve informar um CPF";
		}
	} ?>

<p><a href="../caixas/listall_caixa.php" target="_self">Voltar</a></p>