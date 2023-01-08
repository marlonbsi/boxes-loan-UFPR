<?php

	/*Ação do formulário de edição de cliente. Recebe as variáveis 
	por $_POST, cria e preenche os objetos e chama a função update*/
	
	include '../classes/Conexao.php';
	include '../classes/Cliente.php';
	include '../classes/Session.php';
			
	session_start();
	$session = new Session;
	$session->validaSessao();
	$_SESSION['msg'] = null;
	
	$objCon = new Conexao;
	$con = $objCon->conecta();
	$cliente = new Cliente;
	
	$cli = null;
	$ret = null;
	
	if(isset($_POST['submit'])){
		
		if(isset($_POST['cliente_id'])){
			$cli = $_POST['cliente_id'];
		}else{
			$_SESSION['msg'] = "id";
		}
		
		if(isset($_POST['cliente_telefone'])){
			$telefone = $_POST['cliente_telefone'];
		}else{
			$_SESSION['msg'] = "telefone";
		}
		
		if(isset($_POST['cliente_instituicao'])) {
			$instituicao = $_POST['cliente_instituicao'];
		}else{
			$_SESSION['msg'] = "instituicao";
		}
		
		if(isset($_POST['cliente_email'])) {
			$email = $_POST['cliente_email'];
		}else{
			$_SESSION['msg'] = "email";
		}
		
		if($_SESSION['msg'] == null){
			$cliente->setIdCliente($_POST['cliente_id']);
			$cliente->setCpf($_POST['cliente_cpf']);
			$cliente->setNome($_POST['cliente_nome']);
			
			$ret = $cliente->setTelefone($telefone);
			if($ret == null){
				$ret = $cliente->setEmail($email);
				if($ret == null){
					$ret = $cliente->setInstituicao($instituicao);
					if($ret == null){
						$cliente->updateCliente($cliente);
						$_SESSION['msg'] = "upcli";
						header("Location: ../caixas/listall_caixa.php");
					} else {
						$_SESSION['msg'] = "instituicao";
						header("Location: form_editar_cliente.php?cl=$cli");
					}
				} else{
					$_SESSION['msg'] = "email";
					header("Location: form_editar_cliente.php?cl=$cli");
				}
			} else{
				$_SESSION['msg'] = "telefone";
				header("Location: form_editar_cliente.php?cl=$cli");
			}
				
		}else{
			header("Location: form_editar_cliente.php?cl=$cli");
		}
		
	}
	
?>

<p><a href="../index.php" target="_self">Voltar</a></p>