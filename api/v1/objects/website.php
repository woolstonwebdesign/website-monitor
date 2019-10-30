<?php
namespace v1\objects;
include_once 'api/autoload.php';

use \config\Helpers;
use \config\Response;

class Website {
 
    private $conn;
	private $helpers;

    public $Id;
	public $SiteUrl;
	public $MonitorResponseBody;
	public $MonitorHttpCode;
 
    public function __construct($db){
		$this->conn = $db;
		$this->helpers = new Helpers();
	}

	function getAll($userName) {
		$query = "SELECT * FROM sitemonitor";
		$stmt = $this->conn->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		return new Response(true, "Read all successful.", $stmt->fetchAll(PDO::FETCH_ASSOC));
	}

	function create() {
		$query = "INSERT INTO sitemonitor
				SET
					SiteUrl = :SiteUrl, 
					MonitorResponseBody = :MonitorResponseBody,
					MonitorHttpCode = :MonitorHttpCode";
	
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":SiteUrl", $this->SiteUrl);
		$stmt->bindParam(":MonitorResponseBody", $this->MonitorResponseBody);
		$stmt->bindParam(":MonitorHttpCode", $this->MonitorHttpCode);
	
		try {
			if ($stmt->execute()) {
				$this->Id=$this->conn->lastInsertId();
				return new Response(true, "Created successfully". $userId, $this);
				die();
			}
		} catch (\PDOException $e) {
			return new Response(false, "Create failed. " .$e->Message(), null);
		}

		return new Response(false, "Create failed.", null);
	}
}