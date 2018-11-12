<?
@session_start();

//---+---+---+---+---+---+---+---+---+---+---+---+
// mysql 접속 정보
//---+---+---+---+---+---+---+---+---+---+---+---+

define("_DBID", "kcfeed");
define("_DBPASS", "wjstks132!");
define("_DBNAME", "dbkcfeed");
//define("_DBHOST", "localhost");
define("_DBHOST", "211.43.203.77");


//개발 OR LIVE 설정
define("_DEBUG_MODE", false);



//$mysql = mysql_connect(_DBHOST, _DBID, _DBPASS) or die("connect error");
//mysql_select_db(_DBNAME, $mysql) or die("select_db error");
//$mysql = mysql_connect(':/tmp/mysql.sock', 'sentry', 'passowrd');



//---+---+---+---+---+---+---+---+---+---+---+---+
// 경로
//---+---+---+---+---+---+---+---+---+---+---+---+

// 홈디렉토리
define("_HOME", "");

// 라이브러리
define("_INC", _HOME. "/inc");

//타이틀
define("_TITLE", "케이씨피드 전산");


//url
$host = "http://". $_SERVER[HTTP_HOST];
define("_HTTPHOST", $host);


//---+---+---+---+---+---+---+---+---+---+---+---+
// 로그인 변수
//---+---+---+---+---+---+---+---+---+---+---+---+
if(strlen($_SESSION["Member_id"]) > 2)
{
	$LOGIN = true;
	$Member_id = $_SESSION["Member_id"];
}
else
{
	$LOGIN = false;
}

?>
