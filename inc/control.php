
<?
include "config.php";

if($_SESSION["Member_id"]!='admin'){
	MsgLocation("세션이 만료 되었습니다. 로그인 후 이용해 주세요", '-1');
	exit;
}
?>
<?

$NowFolder = $_SERVER['PHP_SELF'];

//LIB::PLog($NowFolder);
if( preg_match ("/^/",$NowFolder))
{
}
if( preg_match("/^/member/",$NowFolder))
{
	$nav01="class=on";
	if( preg_match("/^general.php",$NowFolder) ) 
		{
			$snav1="class=on";
		}
	elseif( preg_match("/^statistic.html",$NowFolder) ) 
		{
			$snav2="class=on";
		}

}
elseif( preg_match("/^/goods/",$NowFolder))
{
	$nav02="class=on";
	if( preg_match("/^goods.php",$NowFolder) ) 
		{
			$snav1="class=on";
		}
	elseif( preg_match("/^goods_category.php",$NowFolder) ) 
		{
			$snav2="class=on";
		}


}
elseif( preg_match("/^board/",$NowFolder))
{
	$nav03="class=on";
	if( preg_match("/^notice.php",$NowFolder) ) 
		{
			$snav1="class=on";
		}
	elseif( preg_match("/^1on1.php",$NowFolder) ) 
		{
			$snav2="class=on";
		}
	elseif( preg_match("/^error.php",$NowFolder) ) 
		{
			$snav3="class=on";
		}
}



elseif( preg_match("/^manage/",$NowFolder))
{
	$nav04="class=on";
	if( preg_match("/^setting.php",$NowFolder) ) 
		{
			$snav1="class=on";
		}
	elseif( preg_match("/^weather_word.php",$NowFolder) ) 
		{
			$snav2="class=on";
		}

	elseif( preg_match("/^setting_reservation_date.php",$NowFolder) ) 
		{
			$snav3="class=on";
		}
}

?>