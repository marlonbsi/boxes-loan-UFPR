<html>
	<head>
		<script language=javascript src = "../mascaras.js"> </script>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
		<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
		
		<!--Script que gera o calendário no campo com o id "calendario_emp"-->
		<script>
			$(function() {
				var hoje = new Date;
				$("#calendario_dev").datepicker({
					beforeShowDay: $.datepicker.noWeekends,
					dateFormat: 'dd/mm/yy',
					maxDate: new Date(''),
					changeMonth: true,
					changeYear: true,
					showOtherMonths: true,
					selectOtherMonths: true,
					numberOfMonths: 1,
					dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
					dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
					monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
				});
			});
		</script>
		
		<link rel="stylesheet" href="../css/styles.css"/>

	</head>
	<body>
		<?php

			/*Página com o formulário de cadastro de cliente*/

			include '../classes/Cliente.php';
			include '../classes/Emprestimo.php';
			include '../classes/Conexao.php';
			include '../classes/Session.php';
			
			session_start();
			$session = new Session;
			$session->validaSessao();
			
			$idCliente = null;
			$email = null;
			$nivel = null;
			$idEmprestimo = null;
			
			if(isset ($_SESSION['idCliente'])){
				
				$idCliente = $_SESSION['idCliente'];
					
				$cli = new Cliente;
				$cli_selecionado = $cli->selectCliente($idCliente);
				
				while($var = $cli_selecionado->fetch_assoc()){
					$email = $var['email'];
					$nivel = $var['nivel'];	
				}
				
				if (!isset($_SESSION['nivel'])){
					$nivel = "us";
				}
				
				$objCon = new Conexao;
				$con = $objCon->conecta();
				
				if(isset($_GET['emp'])) {
					$idEmprestimo = $_GET['emp'];
					$emprestimo = new Emprestimo;
					$listaEmp = $emprestimo->retornaVerDetalhes($idEmprestimo);
		?>
				<div class="detalhes_solicitacao">
					<div class="formLinhaA">
						<h1>Detalhes da Solicitação</h1>
					</div>
					<?php 
						while($dado = $listaEmp->fetch_array()) {
							$solNum = $dado['e_num'];
					?>
							<div class="formLinha">
								<p><strong>#:</strong> <?php echo $dado['e_num'];?> &nbsp;&nbsp;<strong>Caixa:</strong> <?php echo $dado['cx_nome']; ?></p>
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
					<form action="action_confirmar_devolucao.php" class="formDevolucao" method="post">
						<div class="formLinhaA">
							<h1>Informar Devolução do Item</h1>
						</div>
						<div class="formLinha">
							<label>Data de Devolução:</label>
							<input type="text" id="calendario_dev" name="emprestimo_data_devolucao" class="input2" readonly="readonly"/>
						</div>
						<div class="formTextAreaP">
							<label>Observações:</label> <br/>
							<textarea name="justificativa" rows="6" cols="80" maxlength="400" autofocus ></textarea>
						</div>
						<input type="hidden" name="emprestimo_id" value="<?php print $idEmprestimo;?>"/>
						<input type="hidden" name="cliente_id" value="<?php print $idCliente;?>"/>
						<div class="formLinhaZ">
							<input type="submit" name="submit" class="botaoForm" value="Confirmar Devolução"/><br/><br/>
						</div>
					</form>
		<?php
				}
			} else{
		?>
				<p>Você não possui privilégios para acessar essa página.</p>
		<?php
			}
		?>
		<p><a href="listall_solicitacao.php" target="_self"><< Voltar</a></p>
	</body>
</html>