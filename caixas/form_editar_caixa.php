<html>
	<head>
		<link rel="stylesheet" href="../css/styles.css"/>
	</head>
	<body>

		<?php

			/*Formulário de edição de caixas didáticas. Busca por id
			recebido por $_GET. Chamado a partir de listall_caixa.php*/

			include '../classes/Conexao.php';
			include '../classes/Caixa.php';	
			include '../classes/Session.php';
			
			session_start();
			$session = new Session;
			$session->validaSessao();
			
			$objCon = new Conexao;
			$con = $objCon->conecta();
			$id = $_GET['id'];
			$caixa = new Caixa;
			$selecionada = $caixa->selectCaixa($id);
			while($var = $selecionada->fetch_assoc()){
				$id = $var["id_caixa"];
				$nome = $var["nome"];
				$area = $var["area_tematica"];
				$descricao = $var["descricao"];
				$foto = $var["foto"];
		?>
				<form action="action_editar_caixa.php" class="formCaixa" method="post" enctype="multipart/form-data">
					<div class="formLinhaA">
						<h1>Editar Caixa Didática</h1>
					</div>
					<div class="formImagemCentralizada">
						<img src="<?php print $foto?>" class="miniatura"/>
					</div>
					<div class="formLinha">
						<label>Nome:</label> <input type="text" name="caixa_nome" class="input3" maxlength="80" value="<?php print $nome;?>" autofocus/>
					</div>
					<div class="formLinha">
						<label>Área Temática:</label> <input type="text" name="caixa_area" class="input3" maxlength="60" value="<?php print $area;?>"/>
					</div>
					<div class="formTextArea">
						<label>Descrição:</label> <textarea name="caixa_descricao" class="textarea1" rows="14" cols="80" maxlength="1024"><?php print $descricao;?></textarea>
					</div>
					<div class="formLinha">
						<label>Alterar Imagem:</label><input type="file" name="caixa_foto" class="inputFile"/>
					</div>
					<input type="hidden" name="id" value="<?php print $id;?>"/>
					<input type="hidden" name="foto_antiga" value="<?php print $foto;?>"/>
					<div class="formLinhaZ">
						<input type="submit" name="submit" class="botaoForm" value="Atualizar"/>
					</div>
				</form>
				<p><a href="listall_caixa.php"><< Voltar</a></p>
		<?php
			}
		?>

	</body>
</html>