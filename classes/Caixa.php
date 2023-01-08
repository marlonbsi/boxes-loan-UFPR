<?php
	class Caixa{
		
		//Atributos:
		private $idCaixa;
		private $nome;
		private $area;
		private $descricao;
		private $foto;
		private $disponibilidade;
		
		private $objCon;
		private $con;
		
		//Construtor:
		public function __construct(){
			$this->objCon = new Conexao;
			$this->con = $this->objCon->conecta();
		}
		
		//Métodos Get e Set:
		public function setIdCaixa($id){
			$this->idCaixa = $id;
		}
		
		public function getIdCaixa(){
			return $this->idCaixa;
		}
		
		public function setNome($nome){
			$this->nome = $nome;
		}
		
		public function getNome(){
			return $this->nome;
		}
		
		public function setArea($area){
			$this->area = $area;
		}
		
		public function getArea(){
			return $this->area;
		}
		
		public function setDescricao($descricao){
			$this->descricao = $descricao;
		}
		
		public function getDescricao(){
			return $this->descricao;
		}
		
		public function setFoto($destino){
			$this->foto = $destino;
		}
		
		public function getFoto(){
			return $this->foto;
		}
		
		public function setDisponibilidade($disponibilidade){
			$this->disponibilidade = $disponibilidade;
		}
		
		public function getDisponibilidade(){
			return $this->disponibilidade;
		}
		
		//Métodos complementares:
		public function getDetalhes(){
			echo "<br/>";
			return "{$this->getIdCaixa()}: Caixa {$this->getNome()}, {$this->getDescricao()}";
		}
		
		public function inserir(){
			$sql = "insert into tb_caixa(nome, area_tematica, descricao, foto, disponibilidade) 
				values('$this->nome', '$this->area', '$this->descricao', '$this->foto', 1);";
			echo "<br/>$sql<br/>";
			$result = mysqli_query($this->con,$sql);
			
			if(!$result){
				echo "Erro ao inserir!";
			} else {
				echo "<br/>Dados inseridos com sucesso!<br/>";
			}
			$this->con->close();
		}
		
		public function listAll(){
			
			$sql = "select * from tb_caixa";
			$result = $this->con->query($sql);
			
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			} else {
				return $result;
			}
			$this->con->close();
		}
		
		public function listAllDisponiveis(){
			
			$sql = "select * from tb_caixa where disponibilidade > 0;";
			$result = $this->con->query($sql);
			
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			} else {
				return $result;
			}
			$this->con->close();
		}
		
		public function selectCaixa($id){
			
			$sql = "select * from tb_caixa where id_caixa = $id;";
			$result = mysqli_query($this->con, $sql);
			
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			} else {
				return $result;
			}
			$this->con->close();
		}
		
		public function updateCaixa($caixa){
			
			$sql = "update tb_caixa 
				set nome = '$caixa->nome', area_tematica = '$caixa->area', 
				descricao = '$caixa->descricao', foto = '$caixa->foto'
				where id_caixa = '$caixa->idCaixa';";
				
				echo "$sql<br/><br/>";
			
			$result = mysqli_query($this->con, $sql);
			
			if (!$result) {
				echo "Não foi possível atualizar o registro.";
			}
			$this->con->close();
		
		}
		
		public function excluirCaixa($id){
			
			$sql = "update tb_caixa 
				set disponibilidade = 0 
				where id_caixa = '$id';";
			$result = mysqli_query($this->con, $sql);
			
			if (!$result) {
				echo "Não foi possível excluir o registro.";
			}
			$this->con->close();
		}
		
		public function disponibilizarCaixa($id){
			
			$sql = "update tb_caixa 
				set disponibilidade = 1 
				where id_caixa = '$id';";
			$result = mysqli_query($this->con, $sql);
			
			if (!$result) {
				echo "Não foi possível atualizar o registro.";
			}
			$this->con->close();
		}
}
?>





