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
		<?php

			/*Página com o campo CPF para busca de cliente*/

			include '../classes/Cliente.php';
			include '../classes/Conexao.php';
			
			$objCon = new Conexao;
			$con = $objCon->conecta();
			if(isset($_GET['caixa_id'])) {
				$idCaixa = $_GET['caixa_id']; 
				if(isset($_GET['msg'])) {
					$msg = $_GET['msg'];
					if($msg == "cne"){
						echo "Erro: CPF não encontrado!";
					} 
				} ?>	
				<form action="action_pos_login.php" class="formLogin" method="post">
					<input type="hidden" name="caixa_id" value="<?php echo $idCaixa;?>"/>
					<label>CPF:</label> <input type="text" name="cliente_cpf" id="cpf" maxlength="14" onblur="testaCPF(this);" autofocus />
					&nbsp;&nbsp;<input type="submit" name="submit" class="botaoForm" value="Login"/>
				</form>
				
				<br/><br/>
				<p><a href="form_add_cliente.php">Clique aqui para efetuar seu cadastro</a></p>
				<br/><br/>
		<?php
			} else{ ?>
				<p>Para solicitar um empréstimo você deve selecionar uma caixa didática!</p>
		<?php
			} ?>
		<p><a href="../caixas/listall_caixa.php"><< Voltar</a></p>
	</body>
</html>