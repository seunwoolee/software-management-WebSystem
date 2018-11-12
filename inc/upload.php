<?

if ($_FILES["upload"]["size"] > 0 ){

	// 현재시간 추출
	$current_time = time();
	$time_info	 = getdate($current_time);

	//오리지널 파일 이름.확장자
	$ext = substr(strrchr($_FILES["upload"]["name"],"."),1);
	$ext = strtolower($ext);
	//$savefilename = uniqid()."_".str_replace(" ", "_", $_FILES["upload"]["name"]);
	$savefilename = uniqid()."".str_replace(" ", "_",".".$ext);


	$date_filedir	 = date("Y/m/d")."/";
	//테스트
	//$uploadpath	 = $_SERVER['DOCUMENT_ROOT']."/goodthings/data/goods_tag/";
	//$uploadsrc = $_SERVER['HTTP_HOST']."/goodthings/data/goods_tag/";

	//상용
	$uploadpath	 = $_SERVER['DOCUMENT_ROOT']."/data/goods_tag/";
	$uploadsrc = $_SERVER['HTTP_HOST']."/data/goods_tag/";

	$uploadpath .= $date_filedir;	
	$uploadsrc .= $date_filedir;

	//$date_filedir = "../../data/goods_tag/".$date_filedir;
	if(is_dir($uploadpath) == false)
	{
		mkdir($uploadpath, 0747, true);	
	}

	//$uploadsrc = $_SERVER['HTTP_HOST']."/upload/images/";
	$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';

	//php 파일업로드하는 부분
	if($ext=="jpg" or $ext=="gif" or $ext =="png"){
		if(move_uploaded_file($_FILES['upload']['tmp_name'],$uploadpath."/".iconv("UTF-8","EUC-KR",$savefilename))){
			$uploadfile = $savefilename;
			//echo "<script type='text/javascript'>alert('업로드성공: ".$savefilename."');</script>;";
		}
	}else{
		echo "<script type='text/javascript'>alert('jpg,gif,png파일만 업로드가능합니다.');</script>;";
	}

}else{
	exit;

}

echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']}, '".$http.$uploadsrc."$uploadfile');</script>;";

?>