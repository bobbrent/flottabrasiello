<?php

	Class dbObj{
		var $dbhost = HOST;
		var $username = USER;
		var $password = PSWD;
		var $dbname = DATABASE;
		var $conn;
		function getConnstring() {
		$con = mysqli_connect($this->dbhost, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
		if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
		} else {
		mysqli_set_charset ( $con , "utf8" );
		$this->conn = $con;
		}
		return $this->conn;
		}
	}

	class dataBaseMailer{
		public $dbhost = HOSTMAILER;
		public $username = USERMAILER;
		public $password = PSWDMAILER;
		public $dbname = DATABASEMAILER;
		public $conn;
		public function getConnstring()
		{
			$con = mysqli_connect($this->dbhost, $this->username, $this->password, $this->dbname) or die("Errore di Connessione: " . mysqli_connect_error());
			if (mysqli_connect_errno()) {
				printf("Errore di Connessione: %s\n", mysqli_connect_error());
				exit();
			} else {
				mysqli_set_charset($con, "utf8");
				$this->conn = $con;
			}
			return $this->conn;
		}
	}

?>