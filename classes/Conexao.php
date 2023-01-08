<?php
class Conexao{
	public function conecta(){
		$servername = "localhost";
		$database = "mae2";
		$username = "root";
		$password = "";
		
		$conn = mysqli_connect($servername, $username, $password, $database);
		$conn->set_charset("utf8");
		
		if(!$conn){
			die("Conexão falhou: ".mysqli_connect_error());
		}
		
		//echo "Conectado!";
		return $conn;
	}
}
?>
