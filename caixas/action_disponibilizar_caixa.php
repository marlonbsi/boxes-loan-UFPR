<?php

	/*Ação de excluir a caixa, passando o id por $_GET.
	Chamada a partir de listall_caixa.php*/
	
	include '../classes/Conexao.php';
	include '../classes/Caixa.php';
	include '../classes/Session.php';
			
	session_start();
	$session = new Session;
	$session->validaSessao();
			
	$objCon = new Conexao;
	$con = $objCon->conecta();
	$caixa = new Caixa;
	
	$id = $_GET['id'];
	$caixa->disponibilizarCaixa($id);
	
	$_SESSION['msg'] = "dpcx";	
	header('Location: ../caixas/listall_caixa.php');
	
?>