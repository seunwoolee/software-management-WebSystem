<?
class Price
{	

	// 지역 CODE
	//
	////////////////
	// 서울(음성평균) = 10
	// 부산(김해평균) = 20
	// 김해(김해) = 21
	// 대구(대구) = 30
	// 부경(부경평균) = 31

	// 품목 CODE
	//
	////////////////
	// 계란(특란) = 1020
	// 육계(대) = 2010
	// 양돈 = 3010
	// 한우 = 4010
	//
	
	public $pigSeoul;
	public $pigBusan;
	public $pigBuGyeong;
	public $secondPigSeoul;
	public $secondPigBusan;
	public $secondPigBuGyeong;
	public $cowSeoul;
	public $cowBusan;
	public $cowBuGyeong;
	public $secondCowSeoul;
	
	
	public $eggDaegu;
	public $eggBusan;
	public $eggSeoul;
	public $chickenDaegu;
	public $chickenBusan;
	public $chickenSeoul;
	
	public $pigSeoulDiff;
	public $pigBusanDiff;
	public $pigBuGyeongDiff;
	public $cowSeoulDiff;
	
	
	function __CONSTRUCT($db="")
	{
		$this->db = $db;
		$this->getPigSeoul();
		$this->getSecondPigSeoul();
		$this->getPigBusan();
		$this->getSecondPigBusan();
		$this->getPigBuGyeong();
		$this->getSecondPigBuGyeong();
		$this->getCowSeoul();
		$this->getSecondCowSeoul();
		$this->getCowBusan();
		$this->getCowBuGyeong();
		$this->getEggDaegu();
		$this->getEggBusan();
		$this->getEggSeoul();
		$this->getChickenDaegu();
		$this->getChickenBusan();
		$this->getChickenSeoul();
		$this->getDiffValue();
		
	}

	public function getArrowIcon($param)
	{
		if($param > 0)
		{
			$param = "(<i class='fas fa-arrow-up' style='font-size : 12px !important'> {$param})";
		}
		else if($param == 0)
		{
			$param = "(<i class='fas fa-equals' style='font-size : 12px !important'> {$param})";
		}
		else
		{
			$param = "(<i class='fas fa-arrow-down' style='font-size : 12px !important'> {$param})";
		}
		
		return $param;
	}
	
	public function getDiffValue()
	{
		$this->pigSeoulDiff = intval($this->pigSeoul) - intval($this->secondPigSeoul);
		$this->pigSeoulDiff = $this->getArrowIcon($this->pigSeoulDiff);
		
		$this->pigBusanDiff = intval($this->pigBusan) - intval($this->secondPigBusan);
		$this->pigBusanDiff = $this->getArrowIcon($this->pigBusanDiff);
		
		$this->pigBuGyeongDiff = intval($this->pigBuGyeong) - intval($this->secondPigBuGyeong);
		$this->pigBuGyeongDiff = $this->getArrowIcon($this->pigBuGyeongDiff);
		
		$this->cowSeoulDiff = intval($this->cowSeoul) - intval($this->secondCowSeoul);
		$this->cowSeoulDiff = $this->getArrowIcon($this->cowSeoulDiff);
	}
	
	public function getPigSeoul()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 10 AND item_cd = 3030 ORDER BY dDate DESC ";
		$this->db->query();
		$this->pigSeoul = $this->db->getOne();
	}

	public function getSecondPigSeoul()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 10 AND item_cd = 3030 ORDER BY dDate DESC LIMIT 1 , 1";
		$this->db->query();
		$this->secondPigSeoul = $this->db->getOne();
	}
	
	public function getPigBusan()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 20 AND item_cd = 3030 ORDER BY dDate DESC ";
		$this->db->query();
		$this->pigBusan = $this->db->getOne();
	}
	
	public function getSecondPigBusan()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 20 AND item_cd = 3030 ORDER BY dDate DESC LIMIT 1 ,1";
		$this->db->query();
		$this->secondPigBusan = $this->db->getOne();
	}
	
	public function getPigBuGyeong()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 31 AND item_cd = 3030 ORDER BY dDate DESC ";
		$this->db->query();
		$this->pigBuGyeong = $this->db->getOne();
	}
	
	public function getSecondPigBuGyeong()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 31 AND item_cd = 3030 ORDER BY dDate DESC LIMIT 1, 1";
		$this->db->query();
		$this->secondPigBuGyeong = $this->db->getOne();
	}
	
	public function getCowSeoul()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 10 AND item_cd = 4010 ORDER BY dDate DESC ";
		$this->db->query();
		$this->cowSeoul = $this->db->getOne();
	}
	
	public function getSecondCowSeoul()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 10 AND item_cd = 4010 ORDER BY dDate DESC LIMIT 1, 1";
		$this->db->query();
		$this->secondCowSeoul = $this->db->getOne();
	}
	
	public function getCowBusan()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 20 AND item_cd = 4010 ORDER BY dDate DESC ";
		$this->db->query();
		$this->cowBusan = $this->db->getOne();
	}
	
	public function getCowBuGyeong()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 31 AND item_cd = 4010 ORDER BY dDate DESC ";
		$this->db->query();
		$this->cowBuGyeong = $this->db->getOne();
	}
	
	public function getEggDaegu()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 30 AND item_cd = 1020 ORDER BY dDate DESC ";
		$this->db->query();
		$this->eggDaegu = $this->db->getOne();
	}
	
	public function getEggBusan()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 20 AND item_cd = 1020 ORDER BY dDate DESC ";
		$this->db->query();
		$this->eggBusan = $this->db->getOne();
	}
	
	public function getEggSeoul()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 10 AND item_cd = 1020 ORDER BY dDate DESC ";
		$this->db->query();
		$this->eggSeoul = $this->db->getOne();
	}
	
	public function getChickenDaegu()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 30 AND item_cd = 2010 ORDER BY dDate DESC ";
		$this->db->query();
		$this->chickenDaegu = $this->db->getOne();
	}
	
	public function getChickenBusan()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 20 AND item_cd = 2010 ORDER BY dDate DESC ";
		$this->db->query();
		$this->chickenBusan = $this->db->getOne();
	}
	
	public function getChickenSeoul()
	{
		$this->db->que = " SELECT item_price FROM price_info WHERE region_cd = 10 AND item_cd = 2010 ORDER BY dDate DESC ";
		$this->db->query();
		$this->chickenSeoul = $this->db->getOne();
	}
	
	
}
?>