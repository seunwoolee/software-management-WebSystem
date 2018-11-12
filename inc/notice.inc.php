<?
class Notice
{	
	function Notice($db)
	{
		$this->db = $db;
	}

	public function getNotice()
	{	
		if($this->gubun == "notice")
		{
			$this->db->que = " SELECT * FROM board WHERE gubun = '{$this->gubun}' ORDER BY seq desc limit ".$this->noticeStartRow.", 8";			
		}
		else
		{
			$this->db->que = " SELECT * FROM board WHERE gubun = '{$this->gubun}' ";			
		}
		
		$this->db->query();
		$rows = $this->db->getRows();
		$DATA = $this->getNoticeList($rows);
		return $DATA;
	}
	
	public function getNoticeSub()
	{	
		$this->db->que = " SELECT * FROM board WHERE gubunDetail = '{$this->gubunDetail}' ";				
		$this->db->query();
		$rows = $this->db->getRows();
		$DATA = $this->getNoticeList($rows);
		return $DATA;
	}
	
	
	private function getNoticeList($rows)
	{
		$count = count($rows);
		$int = $this->noticeStartRow;
		
		if($this->gubunDetail == null)
		{
			$gubun = $this->gubun;
		}
		else
		{
			$gubun = $this->gubunDetail;
		}
		 
		
		for($i=0;$i<$count;$i++)
		{
			$j = $i +1;
			$intSeq = $int + $j;
			$row = $rows[$i];
			$pos = strpos($row["createDate"]," ");
			$createDate = substr($row["createDate"],0,10);
			
			$DATA .= "
						<tr>
						  <td style='text-align: center;'>".$intSeq."</th>
						  <td onclick=\"fetchNoticeDetail({$row['seq']} , '".$gubun."')\" style='cursor : pointer; text-align: center;'>{$row["subject"]}</td>
						  <td style='text-align: center;'>".$createDate."</td>
						</tr>";	
		}
		
			$DATAHTML = "
							<table class='table table-striped animated fadeIn' >
							  <thead >
								<tr>
								  <th scope='col' style='text-align: center;'>#</th>
								  <th scope='col' style='text-align: center;'>제목</th>
								  <th scope='col' style='text-align: center;'>작성일</th>
								</tr>
							  </thead>
							  <tbody>
							  {$DATA}
							  </tbody>
							</table>";
		
		return $DATAHTML;
	}
	
	
}
?>