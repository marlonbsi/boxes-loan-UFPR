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
		while($var = $cliSelecionado->fetch_assoc()){
			$nivel = $var['nivel'];	
		}
		if($nivel == "adm"){
			$idSolicitacao = $_GET['emp'];
			$idAdm = $_SESSION['idCliente'];
			$emprestimo->aprovarSolicitacao($idSolicitacao, $idAdm);
			header('Location: listall_solicitacao.php');
		} else{
			echo "Você não tem privilégios para acessar essa página!";
		}
	} else{
		echo "Você não tem privilégios para acessar essa página!";
	}
	
	
?>