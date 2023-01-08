<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Lista de solicitações</title>
		<link rel="stylesheet" href="../css/styles.css"/>
	</head>
	<body>
		<?php
			/*Lista as solicitações do usuário. Permite ações.*/
			
			include '../classes/Conexao.php';
			include '../classes/Emprestimo.php';
			include '../classes/Cliente.php';
			include '../classes/Session.php';
			
			session_start();
			$session = new Session;
			$session->validaSessao();
		
			$id = null;
			$email = null;
			$nivel = null;
			
			if(isset($_SESSION['idCliente'])){
				$id = $_SESSION['idCliente'];
				
				$cli = new Cliente;
				$cli_selecionado = $cli->selectCliente($id);
				
				while($var = $cli_selecionado->fetch_assoc()){
					$email = $var['email'];
					$nivel = $var['nivel'];
				}
				
				$objCon = new Conexao;
				$con = $objCon->conecta();
				$emprestimo = new Emprestimo;
				
				if ($nivel == "adm"){
					$lista = $emprestimo->listAll();
				} else{
					$lista = $emprestimo->listAllPorCliente($id);
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
				
				<div class="lista_solicitacoes">
					<?php
						if($nivel == "adm"){
							$cab = "Lista de solicitações";
						} else {
							$cab = "Minhas solicitações";
						}
						echo "<h1>$cab</h1>";
						
						if($lista <> null){
					?>
							<table>
								<tr>
									<th class="th_sol_numero">#</th>
									<th class="th_sol_caixa">CAIXA</th>
									<th class="th_sol_solicitante">SOLICITANTE</th>
									<th class="th_sol_inst">INSTITUIÇÃO</th>
									<th class="th_sol_contato">CONTATO</th>
									<th class="th_sol_emp">EMPRÉSTIMO</th>
									<th class="th_sol_dev">DEVOLUÇÃO</th>
									<th class="th_sol_acoes">AÇÕES</th>
								</tr>
					<?php
							while($dado = $lista->fetch_array()) { 
								$emp = $dado['d_emp'];
								$dev = $dado['d_dev'];
								$hoje = date('Y-m-d');
								$timestamp_dt_atual = strtotime($hoje);
								$timestamp_dt_dev = strtotime($dev);
								$cliNome = $dado['cli_nome'];
								$cliId = $dado['cli_id'];
					?>
								
									<tr>
										<td class="td_sol_numero"><?php echo $dado['e_num']; ?></td>
										<td class="td_sol_caixa"><?php echo $dado['cx_nome']; ?></td>
										<td class="td_sol_solicitante"><?php echo $cliNome ?></td>
										<td class="td_sol_inst"><?php echo $dado['cli_inst']; ?></td>
										<td class="td_sol_contato"><?php echo $dado['cli_tel']; ?></td>
										<td class="td_sol_emp"><?php echo date('d/M/y',strtotime($emp)); ?></td>
										<?php if($timestamp_dt_atual > $timestamp_dt_dev){ ?>
											<td class="td_sol_dev_at"><?php echo date('d/M/y',strtotime($dev)); ?></td>
										<?php } else { ?>
											<td class="td_sol_dev"><?php echo date('d/M/y',strtotime($dev)); ?></td>
										<?php } ?>
										<td class="celula_acao">
											
											<!-- Ícone VER DETALHES -->
											<a href="action_ver_detalhes.php?emp=<?php echo $dado['e_id'];?>">
													<img src="../img/ver_detalhes.png" class="icone_acao" title="Ver detalhes da solicitação" /></a>&nbsp;
										
											<?php if($nivel == "adm"){
												// Ícone APROVAR 
												if(($dado['e_status'] == "solicitado") || ($dado['e_status'] == "negado")){ ?>
													<a href="../solicitacao/action_aprovar_solicitacao.php?emp=<?php echo $dado['e_id'];?>" 
														onClick="return confirm('Deseja realmente aprovar a solicitação <?php echo $dado['e_num'];?>?')">
															<img src="../img/aprovar.png" class="icone_acao" title="Aprovar Solicitação" /></a>&nbsp;
												<?php
												} 
												/* Ícone NEGAR */
												if(($dado['e_status'] == "solicitado") || ($dado['e_status'] == "aprovado")){ ?>
													<a href="../solicitacao/form_negar_solicitacao.php?emp=<?php echo $dado['e_id'];?>">
														<img src="../img/negar.png" class="icone_acao" title="Negar Solicitação" /></a>&nbsp;
												<?php 
												} else{ ?>
													<img src="../img/aprovar.png" class="icone_acao_desabilitado" title="Não é possível aprovar a solicitação." /></a>&nbsp;
												<?php 
												}
												
												
												/* Ícone INFORMAR RETIRADA */
												if($dado['e_status'] == "aprovado"){ ?>
													<a href="../solicitacao/form_informar_retirada.php?emp=<?php echo $dado['e_id'];?>">
														<img src="../img/retirar.png" class="icone_acao" title="Informar Retirada" /></a>&nbsp;
												<?php } 
												
												/* Ícone CONFIRMAR DEVOLUÇÃO */
												if(($dado['e_status'] == "retirado") || ($dado['e_status'] == "atrasado")){ ?>
													<a href="../solicitacao/form_confirmar_devolucao.php?emp=<?php echo $dado['e_id'];?>">
														<img src="../img/confirmar_devolucao.png" class="icone_acao" title="Confirmar Devolução" /></a>&nbsp;
												<?php } 
												
												/* Ícone BLOQUEAR USUÁRIO */
													if($dado['cli_nivel'] == "us"){
												?>
														<a href="../cliente/action_bloquear_cliente.php?id=<?php echo $cliId;?>" 
															onClick="return confirm('Deseja realmente bloquear <?php echo $cliNome;?>?')">
																<img src="../img/bloquear.png" class="icone_acao" title="Bloquear Usuário" /></a>&nbsp;
											<?php	
													} else {
														if($dado['cli_nivel'] == "bl"){
											?>
															<a href="../cliente/action_desbloquear_cliente.php?id=<?php echo $cliId;?>" 
															onClick="return confirm('Deseja realmente desbloquear <?php echo $cliNome;?>?')">
																<img src="../img/desbloquear.png" class="icone_acao" title="Desbloquear Usuário" /></a>&nbsp;
											<?php
														} else{
											?>
															<img src="../img/bloquear.png" class="icone_acao_desabilitado" title="Não é possível bloquear o usuário." /></a>&nbsp;
											<?php
														}
													}
											}
											
											if(($nivel == "us") || ($nivel == "bl")){
												/* Ícone EDITAR SOLICITAÇÃO */
												if(($dado['e_status'] == "solicitado") && ($nivel == "us")){ ?>
													<a href="../solicitacao/form_editar_solicitacao.php?sol=<?php echo $dado['e_id'];?>">
														<img src="../img/editar.png" class="icone_acao" title="Alterar Solicitação" /></a>&nbsp;
												<?php } else { ?>
														<img src="../img/editar.png" class="icone_acao_desabilitado" title="Não é possível alterar a solicitação." /></a>&nbsp;
												<?php }
												
												/* Ícone AVALIAR CAIXA */
												if($dado['e_status'] == "devolvido"){ ?>
													<a href="../solicitacao/form_avaliar_caixa.php?emp=<?php echo $dado['e_id'];?>">
														<img src="../img/avaliar.png" class="icone_acao" title="Avaliar Caixa Didática" /></a>&nbsp;
												<?php } else { ?>
														<img src="../img/avaliar.png" class="icone_acao_desabilitado" title="Não é possível avaliar essa caixa até que ela seja devolvida." /></a>&nbsp;
												<?php }
												
											}?>
										</td>
									</tr>
						<?php 
							} 
						} else { ?>
							<br/><br/>
							<p>Não existem solicitações para esse usuário.</p>
							<br/><br/>
						<?php } ?>
					</table>
				</div>
		<?php
			} else {
		?>
				<p>Para acessar a lista um usuário deve estar autenticado!</p>
			<?php } ?>
		<br/><br/>
		<p><a href="../caixas/listall_caixa.php"><< Voltar</a></p>
	</body>
</html>