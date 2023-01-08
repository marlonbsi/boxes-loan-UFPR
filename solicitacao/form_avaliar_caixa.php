<html>
	<head>
		<link rel="stylesheet" href="../css/styles.css"/>
	</head>
	<body>
		<?php
			/*Formulário para negar uma solicitação de empréstimo. Recebe o id por $_GET.
			Chamado a partir de listall_caixa.php. Requer nível = "adm"*/

			include '../classes/Conexao.php';
			include '../classes/Emprestimo.php';
			include '../classes/Cliente.php';
			include '../classes/Session.php';
			
			session_start();
			$session = new Session;
			$session->validaSessao();
			
			$objCon = new Conexao;
			$con = $objCon->conecta();
			$idEmprestimo = null;
			
			if(isset($_SESSION['idCliente'])){
				if(isset($_GET['emp'])){
					$idEmprestimo = $_GET['emp'];
		?>
					<form action="action_avaliar_caixa.php" class="formAvaliacao" method="post" enctype="multipart/form-data">
						<div class="formLinhaA">
							<h1>Avalie a Caixa Didática</h1>
						</div>
						<div class="formTextAreaP">
							<label>Seus Comentários:</label> <br/>
							<textarea name="comentarios" rows="6" cols="80" maxlength="400" autofocus ></textarea>
						</div>
						<input type="hidden" name="id_emprestimo" value="<?php print $idEmprestimo;?>"/>
						<div class="formLinhaZ">
							<input type="submit" name="submit" class="botaoForm" value="Confirmar"/>
						</div>
					</form>
		<?php
				}
			} else {
				echo "<p>Você não tem privilégios para acessar essa página!</p>";
			}
		?>
		<a href="listall_solicitacao.php"><< Voltar</a>
	</body>
</html>