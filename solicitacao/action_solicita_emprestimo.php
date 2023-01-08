<?php

	/*Ação do formulário de inclusão de caixa. Recebe as variáveis
	por $_POST, cria e preenche o objeto e chama a função inserir.*/
	
	include '../classes/Conexao.php';
	include '../classes/Emprestimo.php';
	include '../classes/Session.php';
	
	session_start();
	$session = new Session;
	$session->validaSessao();
	
	$objCon = new Conexao;
	$con = $objCon->conecta();

	if(isset ($_SESSION['idCliente'])){
		if(isset($_POST['submit'])) {
			$idCliente = $_POST['cliente_id'];
			$idCaixa = $_POST['caixa_id'];
			$dataEmprestimo = $_POST['emprestimo_data'];
			$dataDevolucao = $_POST['emprestimo_data_devolucao'];
			
			$emprestimo = new Emprestimo;
			$emprestimo->setIdCliente($idCliente);
			$emprestimo->setIdCaixa($idCaixa);
			$emprestimo->setDataEmprestimo($dataEmprestimo);
			$emprestimo->setDataDevolucao($dataDevolucao);
			$emprestimo->setStatus("solicitado");
			$emprestimo->inserir();
			
			header('Location: listall_solicitacao.php'); //mensagem??
		}	
	} else{
		echo "Solicitação não realizada! Para concluir você deve estar autenticado.";
	}
?>

<p><a href="../caixas/listall_caixa.php" target="_self">Voltar</a></p>