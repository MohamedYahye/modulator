<?php 
	


	class CONNECT{


		private $conn;
		private $username;
		private $password;
		private $server;

		function __construct() {
			$this->conn = null;
			$this->username = "mo_po_nl_modulat";
			$this->password = "Rmi3mrkJT2KQ";
			$this->server = "mo-portfolio.nl";

			$this->connect();
			
		}


		public function connect(){

			try{
				$this->conn = new PDO('mysql:host=95.170.72.98;dbname=mo_portfolio_nl_modulat', $this->username, $this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e) {
			    echo 'ERROR: ' . $e->getMessage();
			}
			

		}


		public function returnConnection(){
			return $this->conn;
		}


		public function closeConnection(){
			return $this->conn = null;
		}

	}

?>