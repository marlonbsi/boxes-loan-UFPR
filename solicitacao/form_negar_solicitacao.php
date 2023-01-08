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
			$idAdm = null;
			
			if(isset($_SESSION['idCliente'])){
				$idAdm = $_SESSION['idCliente'];
				
				$cliente = new  Cliente;
				$cliSelecionado = $cliente->selectCliente($idAdm);
				while($var = $cliSelecionado->fetch_assoc()){
					$nivel = $var['nivel'];	
				}
				if($nivel == "adm"){
					$idEmprestimo = $_GET['emp'];
		?>
					<form action="action_negar_solicitacao.php" method="post" class="formNegar" enctype="multipart/form-data">
						<div class="formLinhaA">
							<h1>Negar Solicitação de Empréstimo</h1>
						</div>
						<div class="formTextAreaP">
							<label>Justificativa:</label> <br/>
								<textarea name="justificativa" rows="6" cols="80" maxlength="400" autofocus ></textarea>
						</div>
						<input type="hidden" name="id_emprestimo" value="<?php print $idEmprestimo;?>"/>
						<div class="formLinhaZ">
							<input type="submit" name="submit" class="botaoForm" value="Confirmar"/>
						</div>
					</form>
					<a href="listall_solicitacao.php"><< Voltar</a>
		<?php
				} else {
					echo "<p>Você não tem privilégios para acessar essa página!</p>";
				}
			} else {
				echo "<p>Você não tem privilégios para acessar essa página!</p>";
			}
		?>
	</body>
</html>