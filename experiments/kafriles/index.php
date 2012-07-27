<?php
$username="kafros";
$password="kafros";
$dbhost="localhost";
$dbname="misc";
$dbusername="root";
$dbpassword="ourt";
class dbConnection {
	var $db;
	var $result;
	function dbConnect() {
		global $dbhost;
		global $dbusername;
		global $dbpassword;
		global $dbname;
		$this->db = mysql_connect($dbhost, $dbusername, $dbpassword) or die (mysql_error());
		mysql_select_db($dbname) or die (mysql_error());
	}
	function dbQuery($query) {
		$this->result=mysql_query($query, $this->db) or die("something went wrong<br><br>$query<br><br>". mysql_error());
	}
	function dbClose() {
		mysql_close($this->db);
	}
}
class diary {
	var $diaryBlock;
	function htmlHeader() {
		print "
		<html>
		<head>
		<title>..::KAFRILES::..</title>
		<META HTTP-EQUIV=\"pragma\" CONTENT=\"nocache\">
		<style type=\"text/css\">
		a:link		{ color:#ff6600; text-decoration:none; }
		a:visited	{ color:#ff6600; text-decoration:none; }
		a:hover		{ color:#333333; text-decoration:none; }
		</style>
		<script>
    var displayed=\"<nobr><b>[jump to top]</b></nobr>\"
    var logolink='javascript:window.scrollTo(0,0)'
    var ns4=document.layers
    var ie4=document.all
    var ns6=document.getElementById&&!document.all
    function regenerate(){
    window.location.reload()
    }
    function regenerate2(){
    if (ns4)
    setTimeout(\"window.onresize=regenerate\",400)
    }
    if (ie4||ns6)
    document.write('<span id=\"logo\" style=\"position:absolute;top:-300;z-index:100\">'+displayed+'</span>')
    function createtext(){
    staticimage=new Layer(5)
    staticimage.left=-300
    staticimage.document.write('<a href=\"'+logolink+'\">'+displayed+'</a>')
    staticimage.document.close()
    staticimage.visibility=\"show\"
    regenerate2()
    staticitns()
    }
    function staticit(){
    var w2=ns6? pageXOffset+w : document.body.scrollLeft+w
    var h2=ns6? pageYOffset+h : document.body.scrollTop+h
    crosslogo.style.left=w2
    crosslogo.style.top=h2
    }
    function staticit2(){
    staticimage.left=pageXOffset+window.innerWidth-staticimage.document.width-28
    staticimage.top=pageYOffset+window.innerHeight-staticimage.document.height-10
    }
    function inserttext(){
    if (ie4)
    crosslogo=document.all.logo
    else if (ns6)
    crosslogo=document.getElementById(\"logo\")
    crosslogo.innerHTML='<a href=\"'+logolink+'\">'+displayed+'</a>'
    w=ns6? window.innerWidth-crosslogo.offsetWidth-20 : document.body.clientWidth-crosslogo.offsetWidth-10
    h=ns6? window.innerHeight-crosslogo.offsetHeight-15 : document.body.clientHeight-crosslogo.offsetHeight-10
    crosslogo.style.left=w
    crosslogo.style.top=h
    if (ie4)
    window.onscroll=staticit
    else if (ns6)
    startstatic=setInterval(\"staticit()\",100)
    }
    if (ie4||ns6){
    window.onload=inserttext
    window.onresize=new Function(\"window.location.reload()\")
    }
    else if (ns4)
    window.onload=createtext
    function staticitns(){
    startstatic=setInterval(\"staticit2()\",90)
    }
    </script>
		</head>
		<body background=\"bg.gif\">
		<table width=\"600\" align=\"center\" cellpadding=\"4\" cellspacing=\"2\" border=\"0\" bgcolor=\"#99CC66\">
			<tr>
				<td colspan=\"2\" align=\"center\" bgcolor=\"#ffffff\"><a href=\"index.php\"><img src=\"logo.gif\" border=\"0\"></a><br><b><font face=\"verdana\" color=\"#333333\" size=\"1\">&nbsp;</font></b></td>
			</tr>
		";
	}
	function htmlFooter() {
		print "
		</table><br>
		<table width=\"600\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\" bgcolor=\"#99CC66\">
			<tr>
				<td bgcolor=\"#CFEB88\" valign=\"middle\" align=\"center\"><a href=\"/\" target=\"_blank\">&nbsp;<!--<img src=\"/mtree/img/meover.jpg\" border=\"1\">--></a></td>
			</tr>
			<tr>
				<td bgcolor=\"#FFBA3D\" valign=\"middle\" align=\"center\"><font face=\"verdana\" color=\"#000000\" size=\"1\">idea,concept : <a href=\"#\">MaNUaL</a>&nbsp;&nbsp;&nbsp;&nbsp;stratiotakia : <a href=\"mailto:alchaos_2@hotmail.com\">alchaos</a>&nbsp;&nbsp;&nbsp;&nbsp;design,developing : <a href=\"#\">Mallinanga</a></font></td>
			</tr>
		</table>
		</body>
		</html>";
	}
	function adminLinks() {
		print "
		<tr>
			<td colspan=\"2\" align=\"center\" bgcolor=\"#FFBA3D\"><b><font face=\"verdana\" color=\"#333333\" size=\"1\"><a href=\"index.php\">home</a> | <a href=\"index.php?action=4\">add kafrila</a> | <a href=\"index.php?action=3\">logout</a></font></b></td>
		</tr>
		<tr>
			<td colspan=\"2\">&nbsp</td>
		</tr>
		";
	}
	function loginLinks() {
		print "
		<tr>
			<td colspan=\"2\" align=\"center\" bgcolor=\"#FFBA3D\"><b><font face=\"verdana\" color=\"#333333\" size=\"1\"><a href=\"index.php\">home</a> | <a href=\"index.php?action=1\">login</a></font></b></td>
		</tr>
		<tr>
			<td colspan=\"2\">&nbsp</td>
		</tr>
		";
	}
	function links() {
		global $loggedIn;
		if ($loggedIn=="GOOD") {
			diary::adminLinks();
		} else {
			diary::loginLinks();
		}
	}
	function viewDiary() {
		global $dbhost;
		global $dbusername;
		global $dbpassword;
		global $dbname;
		global $loggedIn;
		$db=new dbConnection;
		$db->dbConnect();
		$db->dbQuery("SELECT * from kafriles ORDER BY timeGenerated DESC");
		while ($row = mysql_fetch_array($db->result, MYSQL_ASSOC)) {
			$id 		= $row["id"];
			$header = $row["header"];
			$body   = $row["body"];
			$header = stripslashes($header);
			$body		= stripslashes($body);
			$body		= nl2br($body);
			$timeGenerated = $row["timeGenerated"];
			$this->diaryBlock.="
			<tr>
				<td align=\"left\" bgcolor=\"#ffffff\"><b><font face=\"verdana\" color=\"#333333\" size=\"1\">$header</font></b></td>
				<td align=\"right\" bgcolor=\"#ffffff\"><font face=\"verdana\" color=\"#666666\" size=\"1\">$timeGenerated</font></td>
			</tr>
			<tr>
				<td colspan=\"2\" bgcolor=\"#CFEB88\"><font face=\"verdana\" color=\"#000000\" size=\"1\">$body</td>
			</tr>
			<tr>
			";
			if ($loggedIn=="GOOD") {
				$this->diaryBlock.="
					<td colspan=\"2\" align=\"right\" bgcolor=\"#DAE7F2\"><b><font face=\"verdana\" color=\"#333333\" size=\"1\"><a href=\"index.php?action=5&id=$id\">edit</a> | <a href=\"index.php?action=7&id=$id\">delete</a><b></td>
				</tr>
				<tr>
					<td colspan=\"2\" bgcolor=\"#99CC66\">&nbsp;</td>
				</tr>
				";
			} else {
				$this->diaryBlock.="
					<td colspan=\"2\" bgcolor=\"#DAE7F2\"><font face=\"verdana\" color=\"#333333\" size=\"1\">&nbsp;</td>
				</tr>
				<tr>
					<td colspan=\"2\" bgcolor=\"#99CC66\">&nbsp;</td>
				</tr>
				";
			}
		}
		$db->dbClose();
		print $this->diaryBlock;
	}
	function addDiary() {
		global $dbhost;
		global $dbusername;
		global $dbpassword;
		global $dbname;
		if (isset($_POST["formSubmit"])=="TRUE") {
			$timeGenerated= date("Y-m-d H:i:s");
			$db=new dbConnection;
			$db->dbConnect();
			$header=$_POST["header"];
			$body=$_POST["body"];
			$header=addslashes($header);
			$body=addslashes($body);
			$body=htmlentities($body);
			$db->dbQuery("INSERT INTO kafriles (id, timeGenerated, header, body) VALUES('','$timeGenerated', '$header', '$body')");
			$db->dbClose();
			unset($formSubmit);
			header("Location: index.php");
			exit;
		} else {
			$this->diaryBlock.="
			<table width=\"600\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\" bgcolor=\"#99CC66\">
				<tr>
					<td align=\"center\">
						<form action=\"index.php?action=9\" method=\"post\" name=\"diaryEntry\" id=\"diaryEntry\">
						<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\">
							<tr>
								<td align=\"center\" bgcolor=\"#CFEB88\"><font face=\"verdana\" color=\"#333333\" size=\"1\">title</font></br><input name=\"header\" type=\"text\" id=\"header\" size=\"80\" maxlength=\"255\"><br></td>
							</tr>
							<tr>
								<td bgcolor=\"#ffffff\" align=\"center\">&nbsp</td>
							</tr>
							<tr>
								<td align=\"center\" bgcolor=\"#CFEB88\"><font face=\"verdana\" color=\"#333333\" size=\"1\">content</font><br><textarea name=\"body\" cols=\"60\" rows=\"20\" id=\"body\"></textarea><input name=\"formSubmit\" type=\"hidden\" id=\"formSubmit\" value=\"Y\"><br><br><input type=\"submit\" name=\"submit\" value=\"post new kafrila\"></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
			";
		}
		print $this->diaryBlock;
	}
	function editDiary() {
		global $dbhost;
		global $dbusername;
		global $dbpassword;
		global $dbname;
		global $id;
		if (isset($_POST["formSubmit"])=="TRUE") {
			$timeGenerated= date("Y-m-d H:i:s");
			$db=new dbConnection;
			$db->dbConnect();
			$header=$_POST["header"];
			$body=$_POST["body"];
			$id=$_POST["id"];
			$header=addslashes($header);
			$body=addslashes($body);
			$db->dbQuery("UPDATE kafriles SET header='$header', body='$body' WHERE id='$id'");
			$db->dbClose();
			unset($formSubmit);
			header("Location: index.php");
			exit;
		} else {
			$db=new dbConnection;
			$db->dbConnect();
			$db->dbQuery("SELECT * from kafriles WHERE id=$id");
			while ($row = mysql_fetch_array($db->result, MYSQL_ASSOC)) {
				$header = $row["header"];
				$body   = $row["body"];
			}
			$this->diaryBlock.="
			<table width=\"600\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\" bgcolor=\"#99CC66\">
				<tr>
					<td align=\"center\">
						<form action=\"index.php?action=6\" method=\"post\" name=\"diaryEntry\" id=\"diaryEntry\">
						<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" border=\"0\">
							<tr>
								<td align=\"center\" bgcolor=\"#CFEB88\"><font face=\"verdana\" color=\"#333333\" size=\"1\">title</font><br><input name=\"header\" type=\"text\" id=\"header\" size=\"80\" value=\"$header\" maxlength=\"255\"></td>
							</tr>
							<tr>
								<td bgcolor=\"#ffffff\" align=\"center\">&nbsp</td>
							</tr>
							<tr>
								<td align=\"center\" bgcolor=\"#CFEB88\"><font face=\"verdana\" color=\"#333333\" size=\"1\">content</font><br><textarea name=\"body\" cols=\"60\" rows=\"20\" id=\"body\">$body</textarea><br><br><input type=\"submit\" name=\"submit\" value=\"submit edited kafrila\">
									<input name=\"id\" type=\"hidden\" id=\"id\" value=\"$id\">
									<input name=\"formSubmit\" type=\"hidden\" id=\"formSubmit\" value=\"Y\">
								</td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
			";
		}
		print $this->diaryBlock;
	}
	function delDiary() {
		global $id;
		$db=new dbConnection;
		$db->dbConnect();
		$db->dbQuery("DELETE FROM kafriles WHERE id='$id'");
		$db->dbClose();
		header("Location: index.php");
		exit;
	}
}
class authentication {
	function login($username, $password) {
		global $loggedIn;
		if (isset($_POST["formSubmit"])) {
			if (($_POST["username"]==$username) && ($_POST["password"]==$password)) {
				setcookie("state", "dxfhjnb54ifdx3iu09hbdr34",time()+3600);
				$loggedIn="GOOD";
			}
		} else {
			print "
			<tr>
				<td>
					<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
						<tr>
							<td align=\"center\">
								<form action=\"index.php?action=2\" method=\"post\" name=\"diaryEntry\" id=\"diaryEntry\">
								<font face=\"verdana\" color=\"#000000\" size=\"1\">username</font><br><input name=\"username\" type=\"text\" id=\"username\" size=\"20\" maxlength=\"255\"><br>
								<font face=\"verdana\" color=\"#000000\" size=\"1\">password</font><br><input type=\"password\" name=\"password\" id=\"body\" size=\"20\"><input name=\"formSubmit\" type=\"hidden\" id=\"formSubmit\" value=\"Y\"><br><br>
								<input type=\"submit\" name=\"submit\" value=\"login\">
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			";
		}
	}
	function logout() {
		global $loggedIn;
		setcookie("state", "",time()-3600);
		$loggedIn="BAD";
	}
	function checkState() {
		global $loggedIn;
		if ((isset($_COOKIE["state"])) && ($_COOKIE["state"]=="dxfhjnb54ifdx3iu09hbdr34")) {
			$loggedIn="GOOD";
		} else {
			$loggedIn="BAD";
		}
	}
}
authentication::checkState();
if (isset($action)==FALSE) {
	$action="0";
}
switch ($action) {
	case 0:
	//default
	$diary = new diary;
	$diary->htmlHeader();
	$diary->links();
	$diary->viewDiary();
	$diary->htmlFooter();
	break;
	case 1:
	//login
	$diary = new diary;
	$login = new authentication;
	$diary->htmlHeader();
	$diary->links();
	$login->login($username, $password);
	$diary->htmlFooter();
	break;
	case 2:
	//login form
	$login = new authentication;
	$login->login($username, $password);
	$diary = new diary;
	$diary->htmlHeader();
	$diary->links();
	$diary->viewDiary();
	$diary->htmlFooter();
	break;
	case 3:
	//logout
	$login= new authentication;
	$login->logout();
	$diary = new diary;
	$diary->htmlHeader();
	$diary->links();
	$diary->viewDiary();
	$diary->htmlFooter();
	break;
	case 4:
	//add
	if ((isset($loggedIn)) && ($loggedIn=="GOOD")) {
		$diary = new diary;
		$diary->htmlHeader();
		$diary->links();
		$diary->addDiary();
		$diary->htmlFooter();
	} else {
		print "login first";
	}
	break;
	case 5:
	//edit
	if ((isset($loggedIn)) && ($loggedIn=="GOOD")) {
		$diary = new diary;
		$diary->htmlHeader();
		$diary->links();
		$diary->editDiary();
		$diary->htmlFooter();
	} else {
		print "login first";
	}
	break;
	case 6:
	//edit
	$diary = new diary;
	$diary->editDiary();
	break;
	case 7:
	//delete
	if ((isset($loggedIn)) && ($loggedIn=="GOOD")) {
		$diary = new diary;
		$diary->delDiary();
	} else {
		print "login first";
	}
	break;
	case 9:
	//add form
	$diary = new diary;
	$diary->addDiary();
	break;
}
?>
