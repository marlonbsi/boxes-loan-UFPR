<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Lista de caixas didáticas</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
		<script type="text/javascript" src="../cliente/validacoes.js"></script>
		
		<script type="text/javascript">
			$("#cpf").mask("000.000.000-00");
		</script>
		
		<link rel="stylesheet" href="../css/styles.css"/>
	</head>
	<body>
		<div class="cabecalho">
			<?php
				/*Lista as caixas disponíveis chamando a função listall.
				Permite ações.*/

				include '../classes/Conexao.php';
				include '../classes/Caixa.php';
				include '../classes/Cliente.php';
				include '../classes/Session.php';
				
				session_start();
				$session = new Session;
				$session->validaSessao();
				
				if(isset($_SESSION['idCliente'])){
					$id = $_SESSION['idCliente'];
					
					$cli = new Cliente;
					$cli_selecionado = $cli->selectCliente($id);
					
					while($var = $cli_selecionado->fetch_assoc()){
						$email = $var['email'];
						$nivel = $var['nivel'];	
					}
			?>
					<div id="links">
						<div class='saudacao'>
							<p>Olá <em><?php echo "$email!"; ?></em><br/>
								<a href="../cliente/form_editar_cliente.php?cl=<?php echo "$id"; ?>">Edite seu cadastro aqui.</a>
							</p>
						</div>
						
						<div class='logout'>
							<a href='../logout.php'>Sair</a>
						</div>
					</div>
					
				<?php } else{
				?>
					<div id="links">
						<div id="link_login">
							<form action="../cliente/action_pre_login.php" method="post" class="formLogin">
								<label>CPF:</label> <input type="text" name="cliente_cpf" id="cpf" maxlength="14" onblur="testaCPF(this);" autofocus />
								&nbsp;&nbsp;<input type="submit" name="submit" class="botaoForm" value="Login"/>
							</form>
						</div>
						<div id="link_cadastro">
							<a href='../cliente/form_add_cliente.php'>Cadastre-se</a>
						</div>
					</div>
				<?php
				}
				if (!isset($_SESSION['nivel'])){
					$nivel = "us";
				}
				
				$objCon = new Conexao;
				$con = $objCon->conecta();
				$caixa = new Caixa;
				
				if ($nivel == "adm"){
					$lista = $caixa->listAll();
				} else{
					$lista = $caixa->listAllDisponiveis();
				}
			?>
			<div class="mensagens">
				<?php
					if(isset($_SESSION['msg'])) {
						if($_SESSION['msg'] == "addcli"){
							echo "Usuário adicionado com sucesso!";
							$_SESSION['msg'] = null;
						}
						if($_SESSION['msg'] == "upcli"){
							echo "Cadastro atualizado com sucesso!";
							$_SESSION['msg'] = null;
						}
						if($_SESSION['msg'] == "excx"){
							echo "A caixa didática selecionada se tornou indisponível!";
							$_SESSION['msg'] = null;
						}
						if($_SESSION['msg'] == "dpcx"){
							echo "A caixa didática selecionada está disponível!";
							$_SESSION['msg'] = null;
						}
						if($_SESSION['msg'] == "upcx"){
							echo "Caixa didática atualizada com sucesso!";
							$_SESSION['msg'] = null;
						}
						if($_SESSION['msg'] == "adcx"){
							echo "Caixa didática adicionada com sucesso!";
							$_SESSION['msg'] = null;
						}
						if($_SESSION['msg'] == "usbl"){
							echo "Não é possível fazer a solicitação, o usuário está bloqueado!";
							$_SESSION['msg'] = null;
						}
					}
				?>
			</div>
		</div>
		<div class="lista_caixas">
			<h1>Lista de caixas didáticas <?php if($nivel == "us" || $nivel == "bl"){?>disponíveis<?php } ?></h1>
			<table>
				<tr>
					<th>MINIATURA</th>
					<th class="celula_nome">NOME</th>
					<th class="celula_descricao">DESCRIÇÃO</th>
					<th>AÇÃO</th>
				</tr>
				<?php if($lista <> null){
					while($dado = $lista->fetch_array()) { ?>
					<tr>
						<td class="celula_miniatura"><?php echo "<img src=\"".$dado['foto']."\" class=\"miniatura\"/>"; ?></td>
						<td><?php echo $dado['nome']; ?></td>
						<td><?php echo $dado['descricao']; ?></td>
						<td class="celula_acao">
							<a href="">
								<img src="../img/ver.png" class="icone_acao" title="Ver Galeria" /></a>&nbsp;
							<?php
								if(isset($_SESSION['idCliente'])){
									if($nivel == "us" || $nivel == "adm"){
							?>
										<a href="../solicitacao/form_solicita_emprestimo.php?cl=<?php echo $_SESSION['idCliente'];?>&cx=<?php echo $dado['id_caixa'];?>">
											<img src="../img/emprestar.png" class="icone_acao" title="Solicitar Empréstimo" /></a>&nbsp;
							<?php
									} else {
							?>			
										<img src="../img/emprestar.png" class="icone_acao_desabilitado" title="Usuário Bloqueado. Não é possível solicitar" /></a>&nbsp;
							<?php
									}
								} else{
							?>
									<a href="../cliente/form_pos_login.php?caixa_id=<?php echo $dado['id_caixa']; ?>">
										<img src="../img/emprestar.png" class="icone_acao" title="Solicitar Empréstimo" /></a>&nbsp;
							<?php
								}
							?>
							<?php
								if(isset($_SESSION['nivel'])){
									if($_SESSION['nivel'] == "adm"){
							?>
									<a href="form_editar_caixa.php?id=<?php echo $dado['id_caixa']; ?>">
										<img src="../img/editar.png" class="icone_acao" title="Editar Cadastro" /></a>&nbsp;
									
									<?php
										if($dado['disponibilidade'] > 0){	
									?>
											<a href="action_ocultar_caixa.php?id=<?php echo $dado['id_caixa']; ?>" onClick="return confirm('Deseja realmente ocultar a caixa: <?php echo $dado['nome'];?>?')">
												<img src="../img/ocultar.png" class="icone_acao" title="Ocultar Caixa" /></a>
									<?php
										} else{
									?>
											<a href="action_disponibilizar_caixa.php?id=<?php echo $dado['id_caixa']; ?>" onClick="return confirm('Deseja disponibilizar a caixa: <?php echo $dado['nome'];?> ?')">
												<img src="../img/disponibilizar.png" class="icone_acao" title="Disponibilizar Caixa" /></a>
							<?php
										}
									}
								}
							?>
						</td>
					</tr>
				<?php }
				} ?>
			</table>
			<?php
				if($nivel == "adm"){	
			?>
					<p><a href="form_add_caixa.php">Cadastrar nova caixa</a></p>
			<?php
				}
				if(isset($_SESSION['idCliente'])){
			?>
					<p><a href="../solicitacao/listall_solicitacao.php">Ver lista de solicitações</a></p>
			<?php
				}
			?>
		</div>
	</body>
</html>