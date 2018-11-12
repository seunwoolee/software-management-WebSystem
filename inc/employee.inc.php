<?
class Employee
{
	var $department;

	function Employee($db)
	{
		$this->db = $db;
	}

	// function getTotalCount()
	// {
		// $this->db->que = " SELECT COUNT(e.seq) FROM employee as e LEFT JOIN department as d ON e.departmentSeq = d.seq WHERE (1) ". $this->where;
		// $this->db->query();
		// $totalCount = $this->db->getOne();
		// return $totalCount;
	// }
	
	function getEmployee()
	{
		$this->db->que = " SELECT e.seq , e.name as employeeName , d.seq as departmentSeq , d.name as departmentName 
						   FROM employee as e LEFT JOIN department as d ON d.seq = e.departmentSeq WHERE (1) ".$this->where;
		$this->db->query();	
		$rows = $this->db->getRows();
		$employeeInfo = $this->getEmployeeInfoList($rows);
		return $employeeInfo;
	}

	function getEmployeeInfoList($rows)
	{
		$count = count($rows);
		for($i=0;$i<count($rows);$i++)
		{
			$row = $rows[$i];
			$employeeInfo .= "
								<tr>
								  <td>".$row["seq"]."</th>
								  <td>".$row["employeeName"]."</td>
								  <td>".$row["departmentName"]."</td>
								  <td>					  
								  <button type='button' class='btn btn-primary btn-xs' onclick=\"modify(".$row["seq"].",".$row["departmentSeq"].",'".$row["employeeName"]."')\">수정</button>
								  <button type='button' class='btn btn-primary btn-xs' onclick='remove(".$row["seq"].");'>삭제</button>
								  </td>
								</tr>";	
		}
		return $employeeInfo;
	}
	
	function getDepartment()
	{
		$this->db->que = " SELECT * FROM department order by name ";
		$this->db->query();
		$department = $this->db->getRows();
		return $department;
	}
	
	
	public function getDepartmentSelectBoxOptions($selectedSeq=0)
	{
		$department = $this->getDepartment();
		$count = count($department);
		for($i=0; $i<$count; $i++)
		{
			$name = $department[$i]["name"];
			if($selectedSeq == $department[$i]["seq"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}


			$LIST .= "<option value='". $department[$i]["seq"]. "' ". $selected. ">". $name. "</option>\n";
		}
		
		return $LIST;
	}
}
?>