<?php
namespace v1\objects;
use \config\Helpers;
use \config\Response;

include_once 'api/autoload.php';

class Website {
 
    private $conn;
	private $helpers;

    public $Id;
	public $SiteUrl;
	public $MonitorResponseBody;
	public $MonitorHttpCode;
	public $DateCreated;
 
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
		date_default_timezone_set('Australia/Melbourne');
		$dateCreated = new \DateTime();
		$dateCreated = $dateCreated->format("Y-m-d H:i:s");
		$query = "INSERT INTO sitemonitor
				SET
					SiteUrl = :SiteUrl, 
					MonitorResponseBody = :MonitorResponseBody,
					MonitorHttpCode = :MonitorHttpCode,
					DateCreated = :DateCreated";
	
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":SiteUrl", $this->SiteUrl);
		$stmt->bindParam(":MonitorResponseBody", $this->MonitorResponseBody);
		$stmt->bindParam(":MonitorHttpCode", $this->MonitorHttpCode);
		$stmt->bindParam(":DateCreated", $dateCreated);
		
		try {
			if ($stmt->execute()) {
				$this->Id=$this->conn->lastInsertId();
				return new Response(true, "Created successfully", $this);
				die();
			}
		} catch (\PDOException $e) {
			return new Response(false, "Create failed. " .$e->Message(), null);
		}

		return new Response(false, "Create failed.", null);
	}
}