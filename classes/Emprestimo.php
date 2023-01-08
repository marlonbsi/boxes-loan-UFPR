<?php

class Emprestimo{
	
	//Atributos:
	public $idEmprestimo;
	public $idCliente;
	public $idCaixa;
	public $dataEmprestimo;
	public $dataDevolucao;
	public $dataRetirada;
	public $status;
	public $avaliacao;
	
	private $objCon;
	private $con;
	
	//Construtor:
	public function __construct(){
		$this->objCon = new Conexao;
		$this->con = $this->objCon->conecta();
	}
	
	//Métodos:
	public function setIdEmprestimo($id){
		$this->idEmprestimo = $id;
	}
	
	public function getIdEmprestimo(){
		return $this->idEmprestimo;
	}
	
	public function setIdCliente($idCliente){
		$this->idCliente = $idCliente;
	}
	
	public function getIdCliente(){
		return $this->idCliente;
	}
	
	public function setIdCaixa($idCaixa){
		$this->idCaixa = $idCaixa;
	}
	
	public function getIdCaixa(){
		return $this->caixa;
	}
	
	public function setDataEmprestimo($data){
		$ano = substr($data, -4);
		$mes = substr($data, 3, -5);
		$dia = substr($data, 0, -8);
		
		$data_atual = date("Y-m-d");
		$ano_atual = substr($data_atual, 0, -6);
		$mes_atual = substr($data_atual, 5, -3);
		$dia_atual = substr($data_atual, -2);
		
		//fazer processamento para validar a data informada
		
		if($ano < $ano_atual){
			echo "Data inválida!<br/>";
		} elseif (($ano == $ano_atual) && ($mes < $mes_atual)){
			echo "Data inválida!<br/>";
		} elseif (($ano == $ano_atual) && ($mes == $mes_atual) && ($dia <= $dia_atual)){
			echo "Data inválida!<br/>";
		} else{
			if(checkdate($mes, $dia, $ano)){
				$data = $ano."-".$mes."-".$dia;
				$this->dataEmprestimo = $data;
				return true;
			}else {
				echo "Data inválida!<br/>";
			}
		}
	}
	
	public function getDataEmprestimo(){
		return $this->dataEmprestimo;
	}
	
	public function setDataDevolucao($data){
		$ano = substr($data, -4);
		$mes = substr($data, 3, -5);
		$dia = substr($data, 0, -8);
		$data = $ano."-".$mes."-".$dia;
		$this->dataDevolucao = $data;
	}
	
	public function getDataDevolucao(){
		return $this->dataDevolucao;
	}
	
	public function setDataRetirada($data){
		$ano = substr($data, -4);
		$mes = substr($data, 3, -5);
		$dia = substr($data, 0, -8);
		$data = $ano."-".$mes."-".$dia;
		$this->dataRetirada = $data;
	}
	
	public function getDataRetirada(){
		return $this->dataRetirada;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function getStatus(){
		return $this->status;
	}
	
	public function setAvaliacao($avaliacao){
		$this->avaliacao = $avaliacao;
	}
	
	public function getAvaliacao(){
		return $this->avaliacao;
	}
	
	//Métodos complementares:
	
	public function selectEmprestimo($id){
		$sql = "select * from tb_emprestimo where id_emprestimo = $id;";
		//echo "<br/>$sql<br/>";
		
		$result = mysqli_query($this->con, $sql);
			
		if (($result <> null) && ($result->num_rows <= 0)) {
			$result = null;
			return $result;
		} else {
			echo "Encontrou<br/>";
			return $result;
		}
		$this->con->close();
	}
	
	public function inserir(){
		$dia_emprestimo = substr($this->dataEmprestimo, -2);
		$dia_devolucao = substr($this->dataDevolucao, -2);;
		if(($dia_emprestimo > 0) && ($dia_devolucao > 0)){
			
			$sqlMax = "SELECT MAX(numero) as num FROM tb_emprestimo;";
			$resultMax = mysqli_query($this->con,$sqlMax);
			$row = mysqli_fetch_array($resultMax);
			if($row["num"] < 1000){
				$row["num"] = 1000;
			}
			$max = $row["num"] + 1;
			
			$sql = "insert into tb_emprestimo(numero, id_caixa, id_cliente, data_emprestimo, data_devolucao, status) 
				values('$max', '$this->idCaixa', '$this->idCliente', '$this->dataEmprestimo', '$this->dataDevolucao', '$this->status');";
			$result = mysqli_query($this->con,$sql);
		
			if(!$result){
				echo "Erro ao inserir!";
			} else {
				echo "<br/>Dados inseridos com sucesso!<br/>";
				//echo "<a href='show.php'>View Result</a>";
			}		
		}
		$this->con->close();
	}
	
	public function listAll(){
			
		$sql = "SELECT e.id_emprestimo as e_id, e.numero as e_num, e.id_caixa, e.id_cliente, e.data_emprestimo as d_emp, 
			e.data_devolucao as d_dev,  e.status as e_status,
			cx.id_caixa, cx.nome as cx_nome, 
			cli.id_cliente as cli_id, cli.nome as cli_nome, cli.instituicao as cli_inst, cli.telefone as cli_tel, cli.nivel as cli_nivel
		FROM tb_emprestimo as e 
			inner join tb_cliente as cli on e.id_cliente = cli.id_cliente
			inner join tb_caixa as cx on e.id_caixa = cx.id_caixa
		ORDER BY e_num";
		
		$result = $this->con->query($sql);
		
		if (($result <> null) && ($result->num_rows <= 0)) {
			$result = null;
		} else {
			return $result;
		}
		
		$this->con->close();
	}
	
	public function listAllPorCliente($idCliente){
		
		$sql = "SELECT e.id_emprestimo as e_id, e.numero as e_num, e.id_caixa, e.id_cliente, e.data_emprestimo as d_emp, 
			e.data_devolucao as d_dev, e.status as e_status,
			cx.id_caixa, cx.nome as cx_nome, 
			cli.id_cliente as cli_id, cli.nome as cli_nome, cli.instituicao as cli_inst, cli.telefone as cli_tel, cli.nivel as cli_nivel
		FROM tb_emprestimo as e 
			inner join tb_cliente as cli on e.id_cliente = cli.id_cliente
			inner join tb_caixa as cx on e.id_caixa = cx.id_caixa
		WHERE e.id_cliente = $idCliente
		ORDER BY e_num";
		$result = $this->con->query($sql);
		
		if (($result <> null) && ($result->num_rows <= 0)) {
			$result = null;
		} else {
			return $result;
		}
		$this->con->close();
	}
	
	public function aprovarSolicitacao($idEmprestimo, $idAdm){
		
		$sqlEmp = "update tb_emprestimo
			set status = 'aprovado'
			where id_emprestimo = $idEmprestimo;";
		
		$resultEmp = mysqli_query($this->con, $sqlEmp);
		
		$sqlParecer = "insert into tb_parecer (id_emprestimo, id_adm, observacoes) 
			values ('$idEmprestimo', '$idAdm', 'aprovado');";
			
		$resultParecer = mysqli_query($this->con, $sqlParecer);
		
		if (!$resultEmp || !$resultParecer) {
			echo "Favor contatar suporte!";
		}
		$this->con->close();
	}
	
	public function negarEmprestimo($idEmprestimo, $idAdm, $observacoes){
		
		$sqlEmp = "update tb_emprestimo
			set status = 'negado'
			where id_emprestimo = $idEmprestimo;";
		
		$resultEmp = mysqli_query($this->con, $sqlEmp);
		
		$sqlParecer = "insert into tb_parecer (id_emprestimo, id_adm, observacoes) 
			values ('$idEmprestimo', '$idAdm', '$observacoes');";
			
		$resultParecer = mysqli_query($this->con, $sqlParecer);
		
		if (!$resultEmp || !$resultParecer) {
			echo "Favor contatar suporte!";
		}
		$this->con->close();
	}
	
	public function retornaVerDetalhes($idEmprestimo){
		$sql = "select e.numero as e_num, e.data_emprestimo as e_data_e, e.data_devolucao as e_data_d, 
				e.status as e_status, 
				cx.nome as cx_nome,
				cli.nome as cli_nome, cli.instituicao as cli_inst
			from tb_emprestimo as e 
				inner join tb_caixa as cx on e.id_caixa = cx.id_caixa
				inner join tb_cliente as cli on e.id_cliente = cli.id_cliente
			where e.id_emprestimo = $idEmprestimo;";
		$result = mysqli_query($this->con, $sql);
		
		if (($result <> null) && ($result->num_rows <= 0)) {
			$result = null;
			return $result;
		} else {
			return $result;
		}
		$this->con->close();
	}
	
	public function retornaPareceres($idEmprestimo){
		$sql = "select p.observacoes as obs, p.id_adm as id_adm, c.nome as adm
			from tb_parecer as p
			inner join tb_cliente as c on p.id_adm = c.id_cliente
			where p.id_emprestimo = $idEmprestimo;";
		$result = mysqli_query($this->con, $sql);
		
		if (($result <> null) && ($result->num_rows <= 0)) {
			$result = null;
			return $result;
		} else {
			return $result;
		}
		$this->con->close();
	}
	
	public function retornaAvaliacao($idEmprestimo){
		$sql = "select a.avaliacao as av, a.id_avaliacao as id_av
			from tb_avaliacao as a
			where a.id_emprestimo = $idEmprestimo;";
		$result = mysqli_query($this->con, $sql);
		
		if (($result <> null) && ($result->num_rows <= 0)) {
			$result = null;
			return $result;
		} else {
			return $result;
		}
		$this->con->close();
	}
	
	public function retornaCliente($idEmprestimo){
		$sql = "select id_cliente 
			from tb_emprestimo 
			where id_emprestimo = $idEmprestimo;";
		$result = mysqli_query($this->con, $sql);
		
		if (($result <> null) && ($result->num_rows <= 0)) {
			$result = null;
		} else {
			return $result;
		}
		$this->con->close();
	}
	
	public function confirmarDevolucao($dataDev, $idEmprestimo, $idAdm, $observacoes){
		
		$sqlEmp = "update tb_emprestimo
			set status = 'devolvido'
			where id_emprestimo = $idEmprestimo;";
		$resultEmp = mysqli_query($this->con, $sqlEmp);
		
		$obs = null;
		if($observacoes == null){
			$obs = "Devolvido";
		} else{
			$obs = $observacoes;
		}
		
		$sqlParecer = "insert into tb_parecer (id_emprestimo, id_adm, observacoes) 
			values ('$idEmprestimo', '$idAdm', '$obs');";	
		$resultParecer = mysqli_query($this->con, $sqlParecer);
		
		$sqlDevolucao = "insert into tb_devolucao (data, id_emprestimo, id_adm)
			values ('$dataDev', '$idEmprestimo', '$idAdm');";
		$resultDevolucao = mysqli_query($this->con, $sqlDevolucao);
		
		if (!$resultEmp || !$resultParecer || !$resultDevolucao) {
			echo "Favor contatar suporte!";
		}
		
		$this->con->close();
	}
	
	public function informarRetirada($dataRet, $idEmprestimo, $idAdm, $observacoes){
		
		$emp = new Emprestimo;
		$emp->setDataRetirada($dataRet);
		
		$sqlEmp = "update tb_emprestimo
			set status = 'retirado', data_retirada = '$emp->dataRetirada'
			where id_emprestimo = $idEmprestimo;";
		$resultEmp = mysqli_query($this->con, $sqlEmp);
		
		$obs = null;
		if($observacoes == null){
			$obs = "Retirado";
		} else{
			$obs = $observacoes;
		}
		
		$sqlParecer = "insert into tb_parecer (id_emprestimo, id_adm, observacoes) 
			values ('$idEmprestimo', '$idAdm', '$obs');";	
		$resultParecer = mysqli_query($this->con, $sqlParecer);
		
		if (!$resultEmp || !$resultParecer) {
			echo "Favor contatar suporte!";
		}
		
		$this->con->close();
	}
	
	public function avaliarCaixa($comentarios){
		
		$this->setAvaliacao($comentarios);
		$sqlAvaliacao = "insert into tb_avaliacao (id_emprestimo, avaliacao)
			values ('$this->idEmprestimo', '$comentarios');";
		$resultAvaliacao = mysqli_query($this->con, $sqlAvaliacao);
		
		$sqlEmp = "update tb_emprestimo
			set status = 'avaliado'
			where id_emprestimo = $this->idEmprestimo";
		echo "$sqlEmp";
		$resultEmp = mysqli_query($this->con, $sqlEmp);
		
		if(!$resultAvaliacao || $resultEmp){
			echo "Erro ao inserir. Favor contatar suporte!";
		} else {
			echo "<br/>Dados inseridos com sucesso!<br/>";
		}
	}
	
}
?>