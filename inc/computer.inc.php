<?
require_once "software.inc.php"; 

class Computer extends Software
{

	function Computer($db)
	{
		$this->db = $db;
	}

	function getTotalCount()
	{
		$this->db->que = " SELECT COUNT(seq) FROM computer WHERE (1) ".$this->where;
		$this->db->query();
		$totalCount = $this->db->getOne();
		return $totalCount;
	}
		
	public function getTypeSelectBoxOptions($selectedSeq="타입")
	{
		$DATA = $this->getType();
		$count = count($DATA);
		for($i=0; $i<$count; $i++)
		{			
			if($selectedSeq == $DATA[$i]["type"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}
			$LIST .= "<option value='". $DATA[$i]["type"]. "' ". $selected. ">". $DATA[$i]["type"]. "</option>\n";
		}
		return $LIST;
	}

	private function getType()
	{
		$this->db->que = " SELECT distinct type FROM computer WHERE type in ('노트북','데스크탑')";
		$this->db->query();
		$rows = $this->db->getRows();
		return $rows;
	}
	
	public function getDepartmentSelectBoxOptions($selectedSeq=0)
	{
		$DATA = $this->getDepartment();
		$count = count($DATA);
		for($i=0; $i<$count; $i++)
		{			
			if($selectedSeq == $DATA[$i]["seq"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}
			$LIST .= "<option value='". $DATA[$i]["seq"]. "' ". $selected. ">". $DATA[$i]["name"]. "</option>\n";
		}
		return $LIST;
	}

	public function getDepartment()
	{
		$this->db->que = " SELECT * FROM department order by name ";
		$this->db->query();
		$department = $this->db->getRows();
		return $department;
	}
	
	public function getOwnerSelectBoxOptions($selectedSeq=0)
	{
		$owner = $this->getOwner();
		$count = count($owner);
		for($i=0; $i<$count; $i++)
		{
			if($selectedSeq == $owner[$i]["seq"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}


			$LIST .= "<option value='". $owner[$i]["seq"]. "' ". $selected. ">". $owner[$i]["employeeName"]. "</option>\n";
		}
		
		return $LIST;
	}

	private function getOwner()
	{
		$this->db->que = " SELECT e.seq , e.name as employeeName , e.departmentSeq , d.name as departmentName FROM employee as e
						   LEFT JOIN department as d ON e.departmentSeq = d.seq ORDER BY employeeName ";
		$this->db->query();
		$owner = $this->db->getRows();
		return $owner;
	}
	
	public function getLocationSelectBoxOptions($selectedSeq="위치")
	{
		$owner = $this->getOwner();
		$count = count($owner);
		for($i=0; $i<$count; $i++)
		{
			if($selectedSeq == $owner[$i]["seq"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}


			$LIST .= "<option value='". $owner[$i]["seq"]. "' ". $selected. ">". $owner[$i]["employeeName"]. "</option>\n";
		}
		
		return $LIST;
	}
	
	
	public function getEmployeeName($seq)
	{
		$this->db->que = " SELECT name FROM employee where seq =".$seq;
		$this->db->query();
		$DATA = $this->db->getOne();
		return $DATA;
	}

	public function getDepartmentName($seq)
	{
		$this->db->que = " SELECT name FROM department where seq = ".$seq;
		$this->db->query();
		$DATA = $this->db->getOne();
		return $DATA;
	}
	
	public function getComputer()
	{
		$this->db->que = " SELECT * FROM computer WHERE type in ('노트북','데스크탑') ".$this->where;
		$this->db->query();
		$rows = $this->db->getRows();
		$DATA = $this->getComputerList($rows);
		return $DATA;
	}
	
	static function getComputerList($rows)
	{
		$count = count($rows);
		for($i=0;$i<count($rows);$i++)
		{
			//$j = $i + 1;
			$row = $rows[$i];
			$DATA .= "
								<tr>
								  <td>".$row["seq"]."</th>
								  <td>".$row["type"]."</td>
								  <td>".$row["state"]."</td>
								  <td>".$row["departmentName"]."</td>
								  <td>".$row["employeeName"]."</td>
								  <td>".$row["networkName"]."</td>
								  <td>".$row["ip"]."</td>
								  <td>					  																			 																													
								  <button type='button' class='btn btn-primary  btn-xs' onclick=\"modify(".$row["seq"].",'".$row["type"]."','".$row["departmentSeq"]."','".$row["employeeSeq"]."','".$row["locationGubun"]."','".$row["locationName"]."','".$row["networkName"]."','".$row["modelName"]."','".$row["productKey"]."','".$row["purchaseDate"]."','".$row["productCompany"]."','".$row["os"]."','".$row["storeType"]."','".$row["ip"]."','".$row["cpu"]."','".$row["memory"]."','".$row["state"]."','".$row["bigo"]."')\">수정</button>
								  <button type='button' class='btn btn-primary  btn-xs' onclick='remove(".$row["seq"].");'>삭제</button>
								  </td>
								</tr>";	
		}
		return $DATA;
	}	
		
	public function checkOwnerChange()
	{
		$CurrentOwner = $this->getCurrentOwner();
		if($this->newOwner == $CurrentOwner)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private function getCurrentOwner()
	{
		$this->db->que = " SELECT employeeSeq FROM computer WHERE seq = ".$this->seq;
		$this->db->query();
		$CurrentOwner = $this->db->getOne();
		return $CurrentOwner;
	}
	
	public function setLogToBigo()
	{
		$NewOwner = $this->getEmployeeName($this->newOwner);
		$CurrentOwner = $this->getCurrentOwnerName($this->seq);
		$bigo = "<br/>(".date("Y-m-d").") ".$CurrentOwner." -> ".$NewOwner." 변경";
		return $bigo;
	}
	
	private function getCurrentOwnerName($seq)
	{
		$this->db->que = " SELECT employeeName FROM computer WHERE seq = ".$seq;
		$this->db->query();
		$CurrentOwner = $this->db->getOne();
		return $CurrentOwner;
	}
}
?>