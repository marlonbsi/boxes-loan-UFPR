<html>
	<head>
		<script type="text/javascript" src="js/jquery-1.2.6.pack.js"></script>
		<script type="text/javascript" src="js/jquery.maskedinput-1.1.4.pack.js"/></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
		
		<script type="text/javascript" src="validacoes.js"></script>
		<script type="text/javascript">
			$("#telefone").mask("(00) 00000-0000");
			$("#cpf").mask("000.000.000-00");
		</script>
		
		<link rel="stylesheet" href="../css/styles.css"/>
	</head>
	<body>
		<?php

			/*Página com o formulário de cadastro de cliente*/

			include '../classes/Cliente.php';
			include '../classes/Conexao.php';
			
			$objCon = new Conexao;
			$con = $objCon->conecta();
		?>
		<div class="mensagens">
		<?php
			if(isset($_SESSION['msg'])) {
				if($_SESSION['msg'] == "cpf_dup"){
					echo "O CPF informado já está cadastrado.<br/>";
					$_SESSION['msg'] = null;
				}
				if($_SESSION['msg'] == "ins_err"){
					echo "Ocorreu um erro ao inserir o cliente.<br/>";
					$_SESSION['msg'] = null;
				}
				if($_SESSION['msg'] == "cpf"){
					echo "O CPF informado não é válido.<br/>";
					$_SESSION['msg'] = null;
				}
				if($_SESSION['msg'] == "nome"){
					echo "Um nome válido deve ser informado.<br/>";
					$_SESSION['msg'] = null;
				}
				if($_SESSION['msg'] == "telefone"){
					echo "Um telefone válido deve ser informado.<br/>";
					$_SESSION['msg'] = null;
				}
				if($_SESSION['msg'] == "email"){
					echo "Um email válido deve ser informado.<br/>";
					$_SESSION['msg'] = null;
				}
				if($_SESSION['msg'] == "instituicao"){
					echo "Uma instituição válida deve ser informada.<br/>";
					$_SESSION['msg'] = null;
				}
			}
		?>
		</div>
		<form action="action_add_cliente.php" method="post" class="formCliente" onsubmit="return validaForm(this);">

			<div class="formLinhaA">
				<h1>Cadastro de Novo Usuário</h1>
			</div>
			<div class="formLinha">
				<label>Nome:</label> <input type="text" name="cliente_nome" class="input3" onblur="testaNome(this);" autofocus/>
			</div>
			<div class="formLinha">
				<label>CPF:</label> <input type="text" name="cpf" id="cpf" class="input2" maxlength="14" onblur="testaCPF(this);"/> &nbsp;
				<label>Telefone:</label> <input type="text" name="cliente_telefone" id="telefone" class="input2" onblur="testaTelefone(this);"/>
			</div>
			<div class="formLinha">
				<label>Email:</label> <input type="text" name="cliente_email" id="email" class="input3" onblur="testaEmail(this);"/>
			</div>
			<div class="formLinha">
				<label>Instituição:</label> <input type="text" name="cliente_instituicao" class="input3" onblur="testaInstituicao(this);"/>
			</div>
			<div class="formLinhaZ">
				<input type="submit" name="submit" class="botaoForm" value="Cadastrar"/>
			</div>

		</form>
		<p><a href="../caixas/listall_caixa.php" target="_self"><< Voltar</a></p>
	</body>
</html>