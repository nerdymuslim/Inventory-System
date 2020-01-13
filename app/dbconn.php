<?php

class Database{

	function __construct(){
		$this->connect();
	}

	public function connect(){
		$host = "localhost";
		$name = "root";
		$pass = "";
		$dbname = "inventory";

		$db = new mysqli($host,$name,$pass,$dbname);
		if(mysqli_connect_error()){
			die("Connection Error");
		}
	}

	public function query($sql){
		$host = "localhost";
		$name = "root";
		$pass = "";
		$dbname = "inventory";

		$db = new mysqli($host,$name,$pass,$dbname);
		if(mysqli_connect_error()){
			die('Connection Error');
		}

		return $query = $db-> query($sql);
	}

}

?>
