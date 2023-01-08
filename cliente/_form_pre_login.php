<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
		<script type="text/javascript" src="validacoes.js"></script>
		
		<script type="text/javascript">
			$("#cpf").mask("000.000.000-00");
		</script>
		
		<link rel="stylesheet" href="../css/styles.css"/>
		
	</head>
	<body>
		<!--Formulário que armazena dados do usuário na sessão-->
				<form action="action_pre_login.php" method="post">
					CPF: <input type="text" name="cliente_cpf" id="cpf" maxlength="14" onblur="testaCPF(this);" autofocus /><br/><br/>
					<input type="submit" name="submit" value="Login"/>
				</form>
				<p><a href="form_add_cliente.php">Clique aqui para se cadastrar</a></p>
	</body>
</html>