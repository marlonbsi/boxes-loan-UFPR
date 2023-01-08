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
	
	if(isset($_SESSION['idCliente'])){
		if(isset($_POST['id_emprestimo'])){
			$observacoes = $_POST['comentarios'];
			$emprestimo->setIdEmprestimo($_POST['id_emprestimo']);
			$emprestimo->avaliarCaixa($observacoes);
			
			header('Location: listall_solicitacao.php');
		}
	} else{
		echo "<p>Você não tem privilégios para acessar essa página!</p>";
		echo "<p><a href='../caixas/listall_caixa.php'>Voltar</a></p>";
	}	
	
?>