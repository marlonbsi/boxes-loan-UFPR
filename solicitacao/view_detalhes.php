<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Detalhes da solicitação</title>
		<link rel="stylesheet" href="../css/styles.css"/>
	</head>
	<body>
		<?php
		
			include '../classes/Conexao.php';
			include '../classes/Emprestimo.php';
			include '../classes/Session.php';
			
			session_start();
			$session = new Session;
			$session->validaSessao();
			
			$emprestimo = new Emprestimo;
			$emp = null;
			$dado = null;
			$solNum = null;
			
			if(isset($_GET['emp'])){
				
				$emp = $_GET['emp'];
				$listaEmp = $emprestimo->retornaVerDetalhes($emp);
				$listaPar = $emprestimo->retornaPareceres($emp);
				$listaAval = $emprestimo->retornaAvaliacao($emp);
		?>
				<div class="detalhes_solicitacao">
					<div class="formLinhaA">
						<h1>Detalhes da Solicitação</h1>
					</div>
					<?php 
						while($dado = $listaEmp->fetch_array()) {
							$solNum = $dado['e_num'];
							$cxNome = $dado['cx_nome'];
					?>
							<div class="formLinha">
								<p><strong>#:</strong> <?php echo $dado['e_num'];?> &nbsp;&nbsp;<strong>Caixa:</strong> <?php echo $cxNome; ?></p>
							</div>
							<div class="formLinha">
								<p><strong>Data de empréstimo:</strong> <?php echo $dado['e_data_e'];?> &nbsp;&nbsp;
									<strong>Data de devolução prevista:</strong> <?php echo $dado['e_data_d']; ?></p>
							</div>
							<div class="formLinha">
								<p><strong>Solicitante:</strong> <?php echo $dado['cli_nome'];?> / <?php echo $dado['cli_inst'];?></p>
							</div>
							<div class="formLinha">
								<p><strong>Estado:</strong> <?php echo $dado['e_status'];?></p>
							</div>
					<?php 
						}	
					?>
				</div>
				<hr/>
				<div class="pareceres_solicitacao">
					<div class="formLinhaA">
						<h1>Pareceres da Solicitação <u><?php echo $solNum;?></u></h1>
					</div>
					<?php 
						if($listaPar <> null){
							$seq = 1;
							while($dadoP = $listaPar->fetch_array()) {
						?>
								<div class="formLinha">
									<p><strong>#: <?php echo $seq;?> &nbsp;&nbsp;Parecer:</strong> <?php echo $dadoP['obs']; ?>
										<br/><strong>Responsável:</strong> <?php echo $dadoP['adm'];?></p>
									</p>
								</div>
						<?php 
							$seq++;
							}
						}						
					?>
				</div><br/>
				<hr/>
				<div class="avaliacao_caixa">
					<div class="formLinhaA">
						<h1>Avaliação da Caixa <u><?php echo $cxNome;?></u></h1>
					</div>
					<?php 
						if($listaAval <> null){
							$seq = 1;
							while($dadoA = $listaAval->fetch_array()) {
						?>
								<div class="formLinha">
									<p><?php echo $dadoA['av']; ?></p>
								</div>
						<?php 
							$seq++;
							}
						}						
					?>
				</div>
		<?php
				
			}
		?>
		<br/><br/>
		<p><a href="listall_solicitacao.php"><< Voltar</a></p>
	</body>
</html>