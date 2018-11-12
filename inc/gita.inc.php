<?
require_once "computer.inc.php"; 

class Gita extends Computer
{
	function Gita($db)
	{
		$this->db = $db;
	}
	
	private function getType()
	{
		$this->db->que = " SELECT distinct type FROM computer WHERE type not in ('노트북','데스크탑')";
		$this->db->query();
		$rows = $this->db->getRows();
		return $rows;
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

	public function getComputer()
	{
		$this->db->que = " SELECT * FROM computer WHERE type not in ('노트북','데스크탑') ".$this->where;
		$this->db->query();
		$rows = $this->db->getRows();
		$DATA = $this->getComputerList($rows);
		return $DATA;
	}
}
?>