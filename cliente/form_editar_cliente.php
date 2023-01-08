<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
		
		<script type="text/javascript" src="validacoes.js"></script>
		
		<script type="text/javascript">
			$("#telefone").mask("(00) 00000-0000");
		</script>
		
		<link rel="stylesheet" href="../css/styles.css"/>
		
	</head>
	<body>
		<?php
			
			/*Formulário de edição de cliente. Chamado a partir da validação de login
			(valida_login.php).
			->Adicionar a lista de solicitações do usuário abaixo.*/
			
			include '../classes/Conexao.php';
			include '../classes/Cliente.php';
			include '../classes/Session.php';
			
			session_start();
			$session = new Session;
			$session->validaSessao();
			
			$objCon = new Conexao;
			$cliente = new Cliente;
			$con = $objCon->conecta();
			$idCliente = null;
			
			if(isset($_GET['cl'])){
				$idCliente = $_GET['cl'];
				$selecionado = $cliente->selectCliente($idCliente);
				
				if(isset($_SESSION['msg'])){
					if($_SESSION['msg'] == "ins_err"){
						echo "Ocorreu um erro ao inserir o cliente.<br/>";
						$_SESSION['msg'] = null;
					}
					if($_SESSION['msg'] == "id"){
						echo "Um cliente deve ser selecionado.<br/>";
						$_SESSION['msg'] = null;
					}
					if($_SESSION['msg'] == "telefone"){
						echo "Um telefone válido deve ser informado.<br/>";
						$_SESSION['msg'] = null;
					}
					if($_SESSION['msg'] == "instituicao"){
						echo "Uma instituição deve ser informada.<br/>";
						$_SESSION['msg'] = null;
					}
					if($_SESSION['msg'] == "email"){
						echo "Um email válido deve ser informado.<br/>";
						$_SESSION['msg'] = null;
					}
				}

				while($var = $selecionado->fetch_assoc()){
					$id = $var["id_cliente"];
					$cpf = $var["cpf"];
					$nome = $var["nome"];
					$telefone = $var["telefone"];
					$email = $var["email"];
					$instituicao = $var["instituicao"];
		?>
					<form action="action_editar_cliente.php" class="formCliente" method="post">
						<div class="formLinhaA">
							<h1>Edite seu cadastro:</h1>
						</div>
						<input type="hidden" name="cliente_id" value="<?php print $id;?>"/>
						<div class="formLinha">
							<label>Nome:</label> <input type="text" name="cliente_nome" class="input3" value="<?php print $nome;?>" readonly="readonly"/>
						</div>
						<div class="formLinha">
							<label>CPF:</label> <input type="text" name="cliente_cpf" class="input2" value="<?php print $cpf;?>" readonly="readonly"/> &nbsp;
							<label>Telefone:</label> <input type="text" id="telefone" class="input2" name="cliente_telefone" value="<?php print $telefone;?>" onblur="testaTelefone(this);" autofocus/>
						</div>
						<div class="formLinha">
							<label>Email:</label> <input type="text" name="cliente_email" id="email" class="input3" value="<?php print $email;?>" onblur="testaEmail(this);"/>
						</div>
						<div class="formLinha">
							<label>Instituição:</label> <input type="text" name="cliente_instituicao" class="input3" value="<?php print $instituicao;?>" onblur="testaInstituicao(this);"/>
						</div>
						<div class="formLinhaZ">
							<input type="submit" name="submit" class="botaoForm" value="Atualizar"/>
						</div>						
					</form>
					<p><a href="../caixas/listall_caixa.php" target="_self"><< Voltar</a></p>
		<?php
				}
			} else{	
		?>
				<p>Para continuar você deve informar um CPF e selecionar uma caixa didática.</p>
				<p><a href="../caixas/listall_caixa.php" target="_self"><< Voltar</a></p>
		<?php
			}
		?>
	</body>
</html>