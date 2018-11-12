<?
class Location
{
	var $department;

	function Location($db)
	{
		$this->db = $db;
	}

	function getTotalCount()
	{
		$this->db->que = " SELECT COUNT(seq) FROM location ";
		$this->db->query();
		$totalCount = $this->db->getOne();
		return $totalCount;
	}
	
	function getLocation()
	{
		$this->db->que = " SELECT seq , gubun , locationName FROM location LIMIT  ". $this->startRow. ", ". $this->endRow;
		$this->db->query();	
		$rows = $this->db->getRows();
		$locationInfo = $this->getLocationInfoList($rows);
		return $locationInfo;
	}

	function getLocationInfoList($rows)
	{
		$count = count($rows);
		for($i=0;$i<count($rows);$i++)
		{
			$row = $rows[$i];
			$locationInfo .= "
								<tr>
								  <td>".$row["seq"]."</th>
								  <td>".$row["gubun"]."</td>
								  <td>".$row["locationName"]."</td>
								  <td>					  
								  <button type='button' class='btn btn-primary btn-xs' onclick=\"modify(".$row["seq"].",'".$row["gubun"]."','".$row["locationName"]."')\">수정</button>
								  <button type='button' class='btn btn-primary btn-xs' onclick='remove(".$row["seq"].");'>삭제</button>
								  </td>
								</tr>";	
		}
		return $locationInfo;
	}
	
	function getDepartment()
	{
		$this->db->que = " SELECT * FROM department ";
		$this->db->query();
		$department = $this->db->getRows();
		return $department;
	}
	
	
	function getDepartmentSelectBoxOptions($selectedSeq=0)
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