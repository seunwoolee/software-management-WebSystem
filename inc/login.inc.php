<?
require_once "employee.inc.php"; 

class Login extends Employee
{

	function Login($db)
	{
		$this->db = $db;
	}
	
	public function getEmployeeInfo($id,$password)
	{
		$securePassword = trim(base64_encode(hash('sha256', $password, true))); 
		$this->db->que = " SELECT e.* , d.name as departmentName FROM employee as e LEFT JOIN department as d ON e.departmentSeq = d.seq  WHERE employeeNumber='". $id. "' AND  pass_word='". $securePassword. "'";
		$this->db->query();
		return $row = $this->db->getRow();
	}
	
	public function checkPassword($id,$password)
	{
		$row = $this->getEmployeeInfo($id,$password);
		return $this->checkSession($row);
	}

	public function logout($cid)
	{
		session_start();
		$_SESSION["seq"] = "";
		$_SESSION["name"] = "";
		$_SESSION["departmentSeq"] = "";
		$_SESSION["employeeNumber"] = "";
		$_SESSION["departmentName"] = "";
		$_SESSION["departmentName"] = "";
	}
	
	public function checkSession($row)
	{
		if($row["seq"] > 0)
		{
			$this->setEmployeeSession($row);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function setEmployeeSession($row)
	{
		session_start();
		$_SESSION["seq"] = $row["seq"];
		$_SESSION["name"] = $row["name"];
		$_SESSION["departmentSeq"] = $row["departmentSeq"];
		$_SESSION["employeeNumber"] = $row["employeeNumber"];
		$_SESSION["departmentName"] = $row["departmentName"];
	}

}