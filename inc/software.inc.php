<?
class Software
{

	function Software($db)
	{
		$this->db = $db;
	}

	function getTotalCount()
	{
		$this->db->que = " SELECT COUNT(s.seq) FROM software as s LEFT JOIN computer as c ON s.owner = c.seq WHERE (1)".$this->where;
		$this->db->query();
		$totalCount = $this->db->getOne();
		return $totalCount;
	}
	
	public function getSoftware()
	{
			
		$this->db->que = " SELECT s.* , c.employeeName , c.departmentName  
						   FROM software as s 
						   LEFT JOIN computer as c ON s.owner = c.seq
						   WHERE (1) ".$this->where.	
						 " order by s.seq ";
		$this->db->query();
		$rows = $this->db->getRows();
		
		if($this->checkIfOwnerFind())
		{
			$rows = $this->whenOwnerFind($rows);			
		}
		
		$softwareInfo = $this->getSoftwareInfoList($rows);
		return $softwareInfo;
	}
	
	private function checkIfOwnerFind()
	{
		if(strpos($this->where,"s.owner like") !== false)
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	private function whenOwnerFind($rows)
	{
		$count = count($rows);
		for($i=0,$j=0;$i<count($rows);$i++)
		{
			$row = $rows[$i];
			if($this->conditionOfSingle($row))
			{
				$DATAS[$j] = $row;
				$j++;
			}
			else if($this->conditionOfCouple($row))
			{
				$DATA = explode(",",$row["owner"]);
				if($this->checkRealOwner($DATA))
				{
					$DATAS[$j] = $row;
					$j++;
				}
				else
				{
					continue;
				}
			}
		}
		return $DATAS;
	}
	
	private function conditionOfSingle($row)
	{
		if($row["amount"] == 1 && $row["owner"] == $this->owner)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function conditionOfCouple($row)
	{
		if(strpos($row["owner"],",") !== false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function checkRealOwner($DATA)
	{
		$count = count($DATA);
		for($i=0;$i<$count;$i++)
		{
			if($DATA[$i] == $this->owner)
			{
				return true;		
			}
			else
			{
				continue;
			}
		}
	}
	
	private function getSoftwareInfoList($rows)
	{

		$count = count($rows);
		for($i=0;$i<count($rows);$i++)
		{
			$row = $rows[$i];
			if($row["amount"] > 1)
			{
				$employeeName = "복수사용자";
			}
			else
			{
				$employeeName = $row["employeeName"];
			}
			$softwareInfo .= "
								<tr>
								  <td>".$row["seq"]."</th>
								  <td>".$row["productName"]."</td>
								  <td>".$row["product"]."</td>
								  <td>".$row["code"]."</td>
								  <td>".$row["productKey"]."</td>
								  <td>".$employeeName."</td>
								  <td>					  
								  <button type='button' class='btn btn-primary btn-xs' onclick=\"modify(".$row["seq"].",'".$row["productName"]."','".$row["product"]."','".$row["productKey"]."','".$row["code"]."','".$row["state"]."','".$row["price"]."','".$row["productCompany"]."','".$row["store"]."','".$row["owner"]."','".$row["bigo"]."',".$row["amount"].")\">수정</button>
								  <button type='button' class='btn btn-primary btn-xs' onclick='remove(".$row["seq"].");'>삭제</button>
								  </td>
								</tr>";	
		}

		return $softwareInfo;
	}
	
	public function getUnusedSoftware()
	{
		$this->db->que = " SELECT s.* , c.employeeName , c.departmentName  FROM software as s LEFT JOIN computer as c ON s.owner = c.seq WHERE s.state = '미사용' order by s.seq ";
		$this->db->query();
		$rows = $this->db->getRows();
		$softwareInfo = $this->getUnusedSoftwareInfoList($rows);
		return $softwareInfo;
	}
	
	private function getUnusedSoftwareInfoList($rows)
	{

		$count = count($rows);
		for($i=0;$i<count($rows);$i++)
		{
			$j = $i + 1;
			$row = $rows[$i];
			$softwareInfo .= "
								<tr>
								  <td>".$j."</th>
								  <td>".$row["product"]."</td>
								  <td>".$row["code"]."</td>
								  <td>					  
								  <button type='button' class='btn btn-warning btn-xs' onclick=\"modify(".$row["seq"].",'".$row["productName"]."','".$row["product"]."','".$row["productKey"]."','".$row["code"]."','".$row["state"]."','".$row["price"]."','".$row["productCompany"]."','".$row["store"]."','".$row["owner"]."','".$row["bigo"]."',".$row["amount"].")\">수정</button>
								  <button type='button' class='btn btn-warning btn-xs' onclick='remove(".$row["seq"].");'>삭제</button>
								  </td>
								</tr>";	
		}

		return $softwareInfo;
	}
	
	public function getProductList()
	{
		$rows = $this->getProduct();
		$count = count($rows);
		for($i=0; $i<$count; $i++)
		{
			$row = $rows[$i];
			$LIST .= "<option>". $row["product"]. "</option>\n";
		}
		return $LIST;
	}
	
	public function getProductSelectBoxOptions($selectedSeq="제품명")
	{
		$DATA = $this->getProduct();
		$count = count($DATA);
		for($i=0; $i<$count; $i++)
		{
			
			if($selectedSeq == $DATA[$i]["product"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}
			$LIST .= "<option value='". $DATA[$i]["product"]. "' ". $selected. ">". $DATA[$i]["product"]. "</option>\n";
		}
		return $LIST;
	}

	public function getProduct()
	{
		$this->db->que = " SELECT distinct product FROM software ";
		$this->db->query();
		$rows = $this->db->getRows();
		return $rows;
	}

	public function getProductName()
	{
		$this->db->que = " SELECT distinct productName FROM software ";
		$this->db->query();
		$rows = $this->db->getRows();
		return $rows;
	}

	public function getProductNameSelectBoxOptions($selectedSeq="제품")
	{
		$DATA = $this->getProductName();
		$count = count($DATA);
		for($i=0; $i<$count; $i++)
		{			
			if($selectedSeq == $DATA[$i]["productName"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}


			$LIST .= "<option value='". $DATA[$i]["productName"]. "' ". $selected. ">". $DATA[$i]["productName"]. "</option>\n";

		}
		return $LIST;
	}
	
	public function getOwnerSelectBoxOptions($selectedSeq=0)
	{
		$owner = $this->getOwner();
		$count = count($owner);
		for($i=0; $i<$count; $i++)
		{			
			$ownerInfo = $owner[$i]["departmentName"]." ".$owner[$i]["employeeName"]."(".$owner[$i]["networkName"].")";
			if($selectedSeq == $owner[$i]["seq"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}


			$LIST .= "<option value='". $owner[$i]["seq"]. "' ". $selected. ">". $ownerInfo. "</option>\n";
		}
		
		return $LIST;
	}
	
	private function getOwner()
	{
		$this->db->que = " SELECT seq , departmentName , employeeName , networkName FROM  computer WHERE type in ('데스크탑' ,'노트북','touchPC') and state = '사용' order by departmentName , employeeName ";
		$this->db->query();
		$owner = $this->db->getRows();
		return $owner;
	}
	
	public function getLocationGubunSelectBoxOptions($selectedSeq="지점구분")
	{
		$DATA = $this->getLocationGubun();
		$count = count($DATA);
		for($i=0; $i<$count; $i++)
		{			
			if($selectedSeq == $DATA[$i]["locationGubun"])
			{
				$selected = "selected";
			}
			else
			{
				$selected = "";
			}


			$LIST .= "<option value='". $DATA[$i]["locationGubun"]. "' ". $selected. ">". $DATA[$i]["locationGubun"]. "</option>\n";
		}
		
		return $LIST;
	}
	
	private function getLocationGubun()
	{
		$this->db->que = " SELECT distinct locationGubun FROM computer ";
		$this->db->query();
		$DATA = $this->db->getRows();
		return $DATA;
	}
	
	public function getAmountSelectBoxOptions()
	{
		for($i=1; $i<30; $i++)
		{			
			$LIST .= "<option value='". $i. "'>". $i. "개</option>\n";
		}
		
		return $LIST;
	}
	
	
}
?>