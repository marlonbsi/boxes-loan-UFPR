<html>
	<head>
		<link rel="stylesheet" href="../css/styles.css"/>
	</head>
	<body>
		<?php

			/*Formulário de inclusão de Caixa Didática*/

			include '../classes/Caixa.php';
			include '../classes/Conexao.php';
			include '../classes/Session.php';
			
			session_start();
			$session = new Session;
			$session->validaSessao();
			
			$objCon = new Conexao;
			$con = $objCon->conecta();
			
			if(isset($_SESSION['idCliente'])){
			
		?>

				<form action="action_add_caixa.php" class="formCaixa" method="post" enctype="multipart/form-data">
					<div class="formLinhaA">
						<h1>Inclusão de Caixa Didática</h1>
					</div>
					<div class="formLinha">
						<label>Nome:</label> <input type="text" name="caixa_nome" class="input3" maxlength="80" autofocus/>
					</div>
					<div class="formLinha">
						<label>Área Temática:</label> <input type="text" name="caixa_area" class="input3" maxlength="60"/>
					</div>
					<div class="formTextArea">
						<label>Descrição:</label> <textarea name="caixa_descricao" class="textarea1" rows="14" cols="80" maxlength="1024"></textarea> <br/>
					</div>
					<div class="formLinha">
						<label>Imagem:</label> <input type="file" name="caixa_imagem" class="inputFile"/><br/>
					</div>
					<div class="formLinhaZ">
						<input type="submit" name="submit" class="botaoForm" value="Cadastrar"/>
					</div>
				</form>
				<p><a href="listall_caixa.php"><< Voltar</a></p>
		<?php 
			} else{
		?>
				<p>Você não possui privilégios para acessar essa página.</p>
		<?php 
			}
		?>
	</body>
</html>