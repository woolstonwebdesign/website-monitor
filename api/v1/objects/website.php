<?php
namespace v1\objects;
use \config\Helpers;
use \config\Response;

include_once '../autoload.php';

class Website {
 
    private $conn;
	private $helpers;

    public $Id;
	public $Url;
	public $Headers;
 
    public function __construct($db){
		$this->conn = $db;
		$this->helpers = new Helpers();
	}

	function getByUserName($userName) {
		$query = "SELECT 
				u.Id, u.UserName, u.FirstName, u.Surname, u.EmailAddress, u.IsActive, u.DateCreated
			FROM user u
			WHERE u.UserName = '" . $userName . "'
			AND u.IsActive = 1";

		$stmt = $this->conn->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		return $stmt;
	}

	function create() {

		$query = "INSERT INTO user
				SET
					UserName = :UserName, 
					FirstName = :FirstName,
					Surname = :Surname,
					EmailAddress = :EmailAddress,
					IsActive = :IsActive";
	
		$stmt = $this->conn->prepare($query);

		$this->UserName=htmlspecialchars(strip_tags($this->EmailAddress));
		$this->FirstName=htmlspecialchars(strip_tags($this->FirstName));
		$this->Surname=htmlspecialchars(strip_tags($this->Surname));
		$this->EmailAddress=htmlspecialchars(strip_tags($this->EmailAddress));
	
		$stmt->bindParam(":UserName", $this->UserName);
		$stmt->bindParam(":FirstName", $this->FirstName);
		$stmt->bindParam(":Surname", $this->Surname);
		$stmt->bindParam(":EmailAddress", $this->EmailAddress);
		$stmt->bindParam(":IsActive", $this->IsActive);
	
		if ($stmt->execute()) {
			$this->Id=$this->conn->lastInsertId();
			return true;
			die();
		}

		return false;

	}

	function update() {

		if ($this->Id == null) {
			return false;
			die();
		}

		try {

			$query = "UPDATE user
					SET
						UserName = :UserName, 
						FirstName = :FirstName,
						Surname = :Surname,
						EmailAddress = :EmailAddress,
						IsActive = :IsActive
					WHERE Id = :Id";
		
			$stmt = $this->conn->prepare($query);
			
			$this->UserName=htmlspecialchars(strip_tags($this->UserName));
			$this->FirstName=htmlspecialchars(strip_tags($this->FirstName));
			$this->Surname=htmlspecialchars(strip_tags($this->Surname));
			$this->EmailAddress=htmlspecialchars(strip_tags($this->EmailAddress));
		
			$stmt->bindParam(":Id", $this->Id);
			$stmt->bindParam(":UserName", $this->UserName);
			$stmt->bindParam(":FirstName", $this->FirstName);
			$stmt->bindParam(":Surname", $this->Surname);
			$stmt->bindParam(":EmailAddress", $this->EmailAddress);
			$stmt->bindParam(":IsActive", $this->IsActive);
		
			if ($stmt->execute()) {
				return $this;
				die();
			}

			return false;
			die();

		} catch (\Exception $e) {
			return $e->getMessage();
		}

	}

	function delete($userName) {
	
		$this->UserName = $userName;
        
		$query = "DELETE FROM " . $this->table_name . " WHERE UserName = :UserName";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":UserName", $this->UserName);
 		
		if ($stmt->execute()) {
			return true;
		}
	
		return false;
	}	

}