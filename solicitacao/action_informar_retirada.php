<?php

	/*Ação que aprova uma solicitação, executada a partir da lista geral de solicitações
	Chamada a partir de listall_solicitacoes.php (requer nível = "adm")*/
	
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
	$nivel = null;
	
	if(isset($_SESSION['idCliente'])){
		$cliente = new  Cliente;
		$cliSelecionado = $cliente->selectCliente($_SESSION['idCliente']);
		$idCliente = $_SESSION['idCliente'];
		
		if(isset($_POST['emprestimo_data_retirada'])){
			$dataRet = $_POST['emprestimo_data_retirada'];
			
			while($var = $cliSelecionado->fetch_assoc()){
				$nivel = $var['nivel'];	
			}
			
			if($nivel == "adm"){
				$idEmprestimo = $_POST['emprestimo_id'];
				$observacoes = $_POST['obs'];
				
				$emprestimo->informarRetirada($dataRet, $idEmprestimo, $idCliente, $observacoes);
				
				header('Location: listall_solicitacao.php');
			} else{
				echo "<p>Você não tem privilégios para acessar essa página!</p>";
				echo "<p><a href='../caixas/listall_caixa.php'>Voltar</a></p>";
			}
			
		} else{
			echo "<p>Para registrar uma devolução é necessário informar uma data.</p>";
			echo "<p><a href='listall_solicitacao.php'>Voltar</a></p>";
		}
		
		
	} else{
		echo "<p>Você não tem privilégios para acessar essa página!</p>";
		echo "<p><a href='../caixas/listall_caixa.php'>Voltar</a></p>";
	}
	
	
?>