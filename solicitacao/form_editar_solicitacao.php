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
				$("#calendario_emp").datepicker({
					beforeShowDay: $.datepicker.noWeekends,
					dateFormat: 'dd/mm/yy',
					minDate: hoje,
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
		
		<!--Script que gera o calendário no campo com o id "calendario_dev"-->
		<script>
			function montaDataDev() {
				var dataEmp = document.getElementById("calendario_emp").value;
				var dd = dataEmp.substring(0, 2);
				var mm = dataEmp.substring(3, 5);
				var yyyy = dataEmp.substring(6, 10);
				
				setDataDev(dd, mm, yyyy);
			};
			
			
			function setDataDev(dd, mm, yyyy){
				var dias = 6;
				var datestr = yyyy + "-" + mm + "-" + dd;
				var dataInicial = new Date(datestr);
				var dataVenc = new Date(dataInicial.getTime() + (dias * 24 * 60 * 60 * 1000));
				
				var dia = dataVenc.getDate();
				if(dia < 10){
					dia = "0" + dia;
				}
				var mes = dataVenc.getMonth() + 1;
				if(mes < 10){
					mes = "0" + mes;
				}
				var ano = dataVenc.getFullYear();
				var dataCompleta = dia + "/" + mes + "/" + ano;
				document.getElementById('calendario_dev').value = dataCompleta;
			};
			
		</script>
		
		<link rel="stylesheet" href="../css/styles.css"/>

	</head>
	<body>
		<?php

			/*Página com o formulário de cadastro de cliente*/

			include '../classes/Caixa.php';
			include '../classes/Cliente.php';
			include '../classes/Conexao.php';
			include '../classes/Session.php';
			
			session_start();
			$session = new Session;
			$session->validaSessao();
			
			if(isset ($_SESSION['idCliente'])){
				$objCon = new Conexao;
				$con = $objCon->conecta();
				$caixa = new Caixa;
				$cliente = new Cliente;
				if(isset($_GET['cl']) && isset($_GET['cx'])) {
					$idCliente = $_GET['cl'];
					$idCaixa = $_GET['cx'];
					$cli_selecionado = $cliente->selectCliente($idCliente);
					while($var = $cli_selecionado->fetch_assoc()){
						$nomeCliente = $var["nome"];
					}
					$caixa_selecionada = $caixa->selectCaixa($idCaixa);
					while($var = $caixa_selecionada->fetch_assoc()){
						$nomeCaixa = $var["nome"];
						$fotoCaixa = $var["foto"];
					} 
		?>
					<form action="action_solicita_emprestimo.php" class="formEmprestimo" method="post">
						<div class="formLinhaA">
							<h1>Nova Solicitação de Empréstimo</h1>
						</div>
						<div class="formImagemCentralizada">
							<?php echo "<img src=\"".$fotoCaixa."\" class=\"miniatura\"/>"; ?>
						</div>
						<div class="formLinha">
							<label>Caixa Didática:</label> <input type="text" name="disabled_caixa" class="input3" value="<?php print $nomeCaixa;?>" disabled="disabled"/>
						</div>
						<div class="formLinha">
							<label>Cliente:</label> <input type="text" name="disabled_cliente" class="input3" value="<?php print $nomeCliente;?>" disabled="disabled"/>
						</div>
						<div class="formLinha">
							<label>Data Emp.:</label> <input type="text" name="emprestimo_data" class="input2" id="calendario_emp" onchange="montaDataDev()"/>
							<label>Devolução:</label> <input type="text" id="calendario_dev" name="emprestimo_data_devolucao" class="input2" readonly="readonly"/>
						</div>
						<input type="hidden" name="cliente_id" value="<?php print $idCliente;?>"/>
						<input type="hidden" name="caixa_id" value="<?php print $idCaixa;?>"/>
						<div class="formLinhaZ">
							<input type="submit" name="submit" class="botaoForm" value="Solicitar"/>
						</div>
					</form>
		<?php
				}
			} else{
		?>
				<p>Para solicitar um empréstimo você deve fazer seu login e selecionar uma caixa didática.</p>
		<?php
			}
		?>
		<p><a href="../caixas/listall_caixa.php" target="_self"><< Voltar</a></p>
	</body>
</html>