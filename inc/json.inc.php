<?
class Json
{
	var $arrayList;
	var $arrayCount = 0;
	var $camel = false;

	var $result;

	function Json()
	{
		$this->result["resultCode"] = 0;
		$this->result["resultMessage"] = "";
	}

	function setCamel($camel) 
	{
		$this->camel = $camel;
	}

	function setMessage($message)
	{
		$this->result["resultCode"] = 1;
		$this->result["resultMessage"] = $message;
	}

	
	//리스트 변수 초기화
	function initList()
	{
		unset($this->arrayList);
		$this->arrayCount = 0;
	}

	//리스트 배열 추가
	function addList($data)
	{
		foreach($data as $key => $value)
		{
			if($this->camel == true)
			{
				$this->arrayList[$this->arrayCount][$this->camelize($key)] = $value;
			}
			else
			{
				$this->arrayList[$this->arrayCount][$key] = $value;
			}
		}
		
		$this->arrayCount += 1;
	}

	//리스트 배열 만들기
	function getList()
	{
		$list = $this->arrayList;
		return $list;
	}

	//Object 추가
	function add($name, $object)
	{
		if($this->camel == true)
		{
			if(is_array($object))
			{
				foreach($object as $key => $value)
				{
					unset($object[$key]);
					$object[$this->camelize($key)] = $value;
				}
			}

			$this->result[$this->camelize($name)] = $object;
		}
		else
		{
			$this->result[$name] = $object;
		}
	}


	function getResult()
	{
		return json_encode($this->result);
	}

	function my_json_encode($arr)
	{
		//convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So such characters are being "hidden" from normal json_encoding
		array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
		return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');
	}

	function decamelize($word) 
	{
		return preg_replace('/(^|[a-z])([A-Z])/e', 'strtolower(strlen("\\1") ? "\\1_\\2" : "\\2")', $word); 
	}

	//카멜표기로 변경
	function camelize($word) 
	{ 
		if($this->camel == true)
		{
			return preg_replace('/(_)([a-z])/e', 'strtoupper("\\2")', $word); 
		}
		else
		{
			return $word;
		}
	}
}

?>