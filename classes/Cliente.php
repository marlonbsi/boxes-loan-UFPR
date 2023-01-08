<?php
class Cliente{
	
	//Atributos:
	public $idCliente;
	public $cpf;
	public $nome;
	public $telefone;
	public $email;
	public $instituicao;
	
	private $objCon;
	private $con;
	
	public function __construct(){
		$this->objCon = new Conexao;
		$this->con = $this->objCon->conecta();
	}
	
	//Métodos:
	public function setCpf($cpf){
		$this->cpf = $cpf;
	}
	
	public function getCpf(){
		return $this->cpf;
	}
	
	public function setIdCliente($id){
		$this->idCliente = $id;
	}
	
	public function getIdCliente(){
		return $this->idCliente;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function setTelefone($telefone){
		$telProv = trim($telefone);
		$regex = '/^\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}$/';
		
		if (preg_match($regex, $telProv)){
			$this->telefone = $telProv;
		}else{
			return "telefone";
		}
	}
	
	public function getTelefone(){
		return $this->telefone;
	}
	
	public function setEmail($email){
		$emailProv = trim($email);
		//verifica se e-mail esta no formato correto de escrita
		if (!preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $emailProv)){
			return "email";
		}else{
			$this->email = $emailProv;
		}
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setInstituicao($inst){
		$instProv = trim($inst);
		if(empty($instProv) OR strstr($instProv, '') OR strlen($instProv) <= 2){
			return "instituicao";
		}else{
			$this->instituicao = $instProv;
		}
	}
	
	public function getInstituicao(){
		return $this->instituicao;
	}
	
	//Métodos complementares:
	public function getDetalhes(){
		echo "<br/>";
		return "{$this->getIdCliente()}: Cliente {$this->getNome()}, CPF: {$this->getCpf()}, telefone {$this->getTelefone()}, da {$this->getInstituicao()}";
	}
	
	public function inserir(){
		$sqlJa = "select * from tb_cliente where cpf = $this->cpf;";
		$resultJa = mysqli_query($this->con, $sqlJa);
		
		if (($resultJa <> null) && ($resultJa->num_rows > 0)) {
			return "cpf_dup";
		} else{
			$sql = "insert into tb_cliente(cpf, nome, telefone, email, instituicao, nivel) values(
				'$this->cpf', '$this->nome', '$this->telefone', '$this->email', '$this->instituicao', 
				'us');";
			$result = mysqli_query($this->con,$sql);
			
			if(!$result){
				return "ins_err";
			} else {
				echo "<br/>Dados inseridos com sucesso!<br/>";
				//echo "<a href='show.php'>View Result</a>";
				return null;
			}
		}		
		$this->con->close();
	}
	
	public function validaLogin($cpf){
		$sql = "select * from tb_cliente where cpf = $cpf;";
		//echo "<br/>$sql<br/>";
		
		$result = mysqli_query($this->con, $sql);
			
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			} else {
				return $result;
			}
			$this->con->close();
	}
	
	public function validaAdm($cpf){
		$sql = "select * from tb_cliente where cpf = $cpf;";
		echo "$sql";
		$result = mysqli_query($this->con, $sql);
		if (($result <> null) && ($result->num_rows <= 0)) {
			$result = null;
			echo "<script language='javascript' type='text/javascript'>
				alert('CPF inválido');</script>";
			die();
		} else {
			return $result;
		}
		$this->con->close();
	}
	
	public function selectCliente($id){
		$sql = "select * from tb_cliente where id_cliente = $id;";
		//echo "<br/>$sql<br/>";
		
		$result = mysqli_query($this->con, $sql);
			
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
				return $result;
			} else {
				return $result;
			}
			$this->con->close();
	}
	
	public function updateCliente($cliente){
			
		$sql = "update tb_cliente 
			set cpf = '$cliente->cpf', nome = '$cliente->nome', telefone = '$cliente->telefone', email = '$cliente->email', instituicao = '$cliente->instituicao'
			where id_cliente = '$cliente->idCliente';";
		$result = mysqli_query($this->con, $sql);
		
		if (!$result) {
			echo "Não foi possível atualizar o registro.";
		}
		$this->con->close();
	}
	
	public function bloquearCliente($idCliente){
			
		$sqlCli = "update tb_cliente 
			set nivel = 'bl'
			where id_cliente = '$idCliente';";
		echo $sqlCli;
			
		$result = mysqli_query($this->con, $sqlCli);
		
		if (!$result) {
			echo "Não foi possível atualizar o registro.";
		} 
		$this->con->close();
	}
	
	public function desbloquearCliente($idCliente){
			
		$sqlCli = "update tb_cliente 
			set nivel = 'us'
			where id_cliente = '$idCliente';";
		echo $sqlCli;
			
		$result = mysqli_query($this->con, $sqlCli);
		
		if (!$result) {
			echo "Não foi possível atualizar o registro.";
		} 
		$this->con->close();
	}
	
	public function testaCli(){
		echo "ok!<br/>";
	}
	
}
?>