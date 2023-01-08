<html>
	<head>
		
	</head>
	<body>
		<?php

			/*Ação do formulário de cadastro de cliente. Recebe as variáveis 
			por $_POST,	cria e preenche o objeto, chama o método inserir*/
			
			include '../classes/Conexao.php';
			include '../classes/Cliente.php';
			include 'isCpfValid.php';
			$objCon = new Conexao;
			$con = $objCon->conecta();
			$msg = null;
			$num = '';
			$j = 0;

			if(isset($_POST['submit'])) {
				if(isset($_POST['cpf'])) {
					$cpf = $_POST['cpf'];
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
						
						if(isset($_POST['cliente_nome'])) {
							$nomeProv = trim($_POST['cliente_nome']);
							if(empty($nomeProv) OR strlen($nomeProv) <= 2){
								$msg = "nome";
							}else{
								$nome = $nomeProv;
							}
						}else{
							$msg = "nome";
						}
						if(isset($_POST['cliente_telefone'])) {
							$telefone = $_POST['cliente_telefone'];
						}else{
							$msg = "telefone";
						}
						
						if(isset($_POST['cliente_email'])) {
							$emailProv = trim($_POST['cliente_email']);
							//verifica se e-mail esta no formato correto de escrita
							if (!preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $emailProv)){
								$msg = 'email';
							}else{
								$email = $emailProv;
							}
						}
						
						if(isset($_POST['cliente_instituicao'])) {
							$instProv = trim($_POST['cliente_instituicao']);
							if(empty($instProv) OR strstr($instProv, '') OR strlen($instProv) <= 2){
								$msg = "instituicao";
							}else{
								$instituicao = $instProv;
							}
						}else{
							$msg = "instituicao";
						}
					}else{
						$msg = "cpf";
					}
				}else{
					$msg = "cpf";
				}
				if($msg == null){
					$cliente = new Cliente;
					$cliente->setCpf($cpf);
					$cliente->setNome($nome);
					$cliente->setTelefone($telefone);
					$cliente->setEmail($email);
					$cliente->setInstituicao($instituicao);
					$alerta = $cliente->inserir();

					if($alerta != ""){
						$_SESSION['msg'] = $msg;
						header("Location: form_add_cliente.php");
					}else{
						$_SESSION['msg'] = $msg;
						header("Location: ../caixas/listall_caixa.php");
					}		
				}else{
					$_SESSION['msg'] = $msg;
					header("Location: form_add_cliente.php");
				}
			}	
			
		?>
	</body>
	</html>