<?
class Department
{

	function Department($db)
	{
		$this->db = $db;
	}

	// function getTotalCount()
	// {
		// $this->db->que = " SELECT COUNT(seq) FROM department ";
		// $this->db->query();
		// $totalCount = $this->db->getOne();
		// return $totalCount;
	// }
	
	function getDepartment()
	{
		$this->db->que = " SELECT seq , name FROM department WHERE (1) ".$this->where. " ORDER BY name" ;
		$this->db->query();	
		$rows = $this->db->getRows();
		$departmentInfo = $this->getDepartmentInfoList($rows);
		return $departmentInfo;
	}

	function getDepartmentInfoList($rows)
	{
		$count = count($rows);
		for($i=0;$i<count($rows);$i++)
		{
			$j = $i + 1;
			$row = $rows[$i];
			$departmentInfo .= "
								<tr>
								  <td>".$j."</th>
								  <td>".$row["name"]."</td>
								  <td>					  
								  <button type='button' class='btn btn-primary btn-xs' onclick=\"modify(".$row["seq"].",'".$row["name"]."')\">수정</button>
								  <button type='button' class='btn btn-primary btn-xs' onclick='remove(".$row["seq"].");'>삭제</button>
								  </td>
								</tr>";	
		}
		return $departmentInfo;
	}



	
	function getLowerDepartment($where)
	{
		$this->db->que = "select u.seq , u.employeeNumber , u.name , d.name as departmentName from user as u LEFT JOIN department as d ON (u.departmentSeq = d.seq) WHERE  deleteState = 'N' ".$where." order by u.departmentSeq ";
		$this->db->query();
		$rows = $this->db->getRows();
		$lowerDepartment = $this->getLowerDepartmentList($rows);
		return $lowerDepartment;
	}

	function getLowerDepartmentList($rows)
	{
		$count = count($rows);
		$firstRow = 1;
		for($i=0;$i<count($rows);$i++)
		{
			$row = $rows[$i];
			if($firstRow == 1)
			{
				$lowerDepartment .= "
									<td class='text-left'>	".$row["departmentName"]."</td>
									<td class='text-center'>".$row["name"]."</td>
									<td class='text-center'>".$row["employeeNumber"]."</td>
									<td class='text-center'><input type='checkbox' name='check[]' class='list-checkbox' value='". $row["seq"]. "' /></td>	
								</tr>";	
				$firstRow++;						
			}  
			else
			{
				$lowerDepartment .= "
								<tr>
									<td class='text-left'>	".$row["departmentName"]."</td>
									<td class='text-center'>".$row["name"]."</td>
									<td class='text-center'>".$row["employeeNumber"]."</td>
									<td class='text-center'><input type='checkbox' name='check[]' class='list-checkbox' value='". $row["seq"]. "' /></td>	
								</tr>";		
			}
		}
		return $lowerDepartment;
	}

	function getRowSpan($where)
	{
		$upperRowSpan = $this->getUpperRowSpan();
		$lowerRowSpan = $this->getLowerRowSpan($where);
		if ($lowerRowSpan > $upperRowSpan)
		{
			$rowSpan = $lowerRowSpan; 
		}
		else
		{
			$rowSpan = $upperRowSpan;
		}
		return $rowSpan;
	}
}
?>