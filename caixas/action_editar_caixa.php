<?php

	/*Ação do formulário de inclusão de caixas didáticas. Recebe variáveis 
	por $_POST, cria e preenche os objetos e chama a função update.*/
	
	include '../classes/Conexao.php';
	include '../classes/Caixa.php';
	include '../classes/Session.php';
			
	session_start();
	$session = new Session;
	$session->validaSessao();
	
	$objCon = new Conexao;
	$con = $objCon->conecta();
	$caixa = new Caixa;

	if(isset($_POST['submit'])) {
		
		$caixa->setIdCaixa($_POST['id']);
		$caixa->setNome($_POST['caixa_nome']);
		$caixa->setArea($_POST['caixa_area']);
		$caixa->setFoto($_POST['foto_antiga']);
		$caixa->setDescricao($_POST['caixa_descricao']);
		
		print $caixa->getFoto()."<br/><br/>";
		
		if(isset($_FILES['caixa_foto'])) {
			$foto = $_FILES['caixa_foto']['tmp_name'];
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
				$caixa->setFoto($novoDestino);
			}
		}
		print $caixa->getFoto()."<br/><br/>";
		
		$caixa->updateCaixa($caixa);
		
		$_SESSION['msg'] = "upcx";
		header('Location: listall_caixa.php');
	}	
	
?>