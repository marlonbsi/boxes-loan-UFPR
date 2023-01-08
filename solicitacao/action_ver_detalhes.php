<?php

	/*Valida permissões do usuário para permitir visualização da solicitação.
	Libera para o solicitante e para nível "adm"*/
	
	include '../classes/Conexao.php';
	include '../classes/Emprestimo.php';
	include '../classes/Cliente.php';
	include '../classes/Session.php';
	
	session_start();
	$session = new Session;
	$session->validaSessao();
	
	$objCon = new Conexao;
	$con = $objCon->conecta();
	
	$emprestimo = new Emprestimo;
	$cliente = new Cliente;
	$idEmprestimo = null;
	$idClienteLogado = null;
	$idClienteSol = null;
	$nivelLog = null;
	$nivel = null;
	
	if(isset($_SESSION['idCliente'])){
		if(isset($_GET['emp'])){
			$idClienteLogado = $_SESSION['idCliente'];
			$cliLogado = $cliente->selectCliente($idClienteLogado);
			while($varL = $cliLogado->fetch_assoc()){
				$nivelLog = $varL['nivel'];	
			}
			
			$idEmprestimo = $_GET['emp'];
			$consultaClienteSol = $emprestimo->retornaCliente($idEmprestimo);
			
			while($varClienteSol = $consultaClienteSol->fetch_assoc()){
				$idClienteSol = $varClienteSol["id_cliente"];
			}
			
			if(($idClienteSol == $idClienteLogado) || ($nivelLog == "adm")){
				header("Location: view_detalhes.php?emp=$idEmprestimo");
				
			} else{
				echo "<p>Você não tem privilégios para acessar essa página!</p>";
				echo "<p><a href='../caixas/listall_caixa.php'>Voltar</a></p>";
			}
		} else{
			echo "<p>Um empréstimo deve ser informado!</p>";
			echo "<p><a href='../caixas/listall_caixa.php'>Voltar</a></p>";
		}
	} else{
		echo "<p>Você não tem privilégios para acessar essa página!</p>";
		echo "<p><a href='../caixas/listall_caixa.php'>Voltar</a></p>";
	}
	
	
?>