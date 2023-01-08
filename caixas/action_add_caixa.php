<?php

	/*Ação do formulário de inclusão de caixa. Recebe as variáveis
	por $_POST, cria e preenche o objeto e chama a função inserir.*/
	
	include '../classes/Conexao.php';
	include '../classes/Caixa.php';
	include '../classes/Session.php';
			
	session_start();
	$session = new Session;
	$session->validaSessao();
	
	$objCon = new Conexao;
	$con = $objCon->conecta();

	if(isset($_POST['submit'])) {
		$nome = $_POST['caixa_nome'];
		$area = $_POST['caixa_area'];
		$descricao = $_POST['caixa_descricao'];
		
		
		$foto = $_FILES['caixa_imagem']['tmp_name'];
		$tamanho_permitido = 2048000; //2 MB
		$pasta = '../uploads';
		
		if (!empty($foto)){
			
			$file = getimagesize($foto);
			
			//TESTA O TAMANHO DO ARQUIVO
			if($_FILES['caixa_imagem']['size'] > $tamanho_permitido){
				echo "erro - arquivo muito grande";
				exit();
			}
			
			//TESTA A EXTENSÃO DO ARQUIVO
			if(!preg_match('/^image\/(?:gif|jpg|jpeg|png)$/i', $file['mime'])){
				echo "erro - extensão não permitida";
				exit();
			}
			
			//CAPTURA A EXTENSÃO DO ARQUIVO
			$extensao = str_ireplace("/", "", strchr($file['mime'], "/"));
			
			//MONTA O CAMINHO DO NOVO DESTINO
			$novoDestino = "{$pasta}/foto_arquivo_".uniqid('', true) . '.' . $extensao;  
			move_uploaded_file ($foto , $novoDestino);
		}
		
		$caixa = new Caixa;
		$caixa->setNome($nome);
		$caixa->setArea($area);
		$caixa->setDescricao($descricao);
		$caixa->setFoto($novoDestino);
		$caixa->inserir();
		$_SESSION['msg'] = "adcx";
		header('Location: listall_caixa.php');

	}	
	
?>

<p><a href="../index.php" target="_self">Voltar</a></p>