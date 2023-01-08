<?php
class Devolucao{
	
	//Atributos:
	public $idDevolucao;
	public $emprestimo;
	public $status;
	public $data;
	
	//Métodos:
	public function setIdDevolucao($id){
		$this->idDevolucao = $id;
	}
	
	public function getIdDevolucao(){
		return $this->idDevolucao;
	}
	
	public function setEmprestimo($emprestimo){
		$this->emprestimo = $emprestimo;
	}
	
	public function getEmprestimo(){
		return $this->emprestimo;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function getStatus(){
		return $this->status;
	}
	
	public function setData($data){
		$this->data = $data;
	}
	
	public function getData(){
		return $this->data;
	}
	
	public function getDetalhes(){
		echo "<br/>";
		return "{$this->getIdDevolucao()}: Devolução de {$this->getEmprestimo()->getIdEmprestimo()}, status {$this->getStatus()} em {$this->getData()}";
	}
}
?>