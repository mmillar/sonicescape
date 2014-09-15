<?php
/*****************************************
 * SiteBuddy User Administration Screen
 *****************************************/


$action=ISSET($_REQUEST["action"])?$_REQUEST["action"]:null;

include_once("../includes/mysql_conn.php");

if($action=="del"){
	$uid = $_REQUEST["uid"];
	$result = mysql_query("UPDATE sb_users set deleted=1 where userid=".$uid);
} else if($action=="add"){
	$userobj = array($_REQUEST["username"]
		,$_REQUEST["first_nm"]
		,$_REQUEST["last_nm"]
		,$_REQUEST["company"]
		,$_REQUEST["email"]
		,$_REQUEST["password"]);
	$sql = "INSERT INTO sb_users (`username`,`firstname`,`lastname`,`company`,`email`,`deleted`) values ".
		"('".$userobj[0]."','".$userobj[1]."','".$userobj[2]."','".$userobj[3]."','".$userobj[4]."',0);";
	$result = mysql_query($sql);
	$tmpid = mysql_insert_id();
	$sql = "INSERT INTO sb_userauth (`userid`,`password`) values (".$tmpid.",'".crypt($userobj[5])."');";
	$result = mysql_query($sql);
} else if($action=="edit"){
	$userid = $_REQUEST["userid"];
	$userobj = array($_REQUEST["username"]
		,$_REQUEST["first_nm"]
		,$_REQUEST["last_nm"]
		,$_REQUEST["company"]
		,$_REQUEST["email"]
		,$_REQUEST["password"]);
	$sql = "UPDATE sb_users SET username = '".$userobj[0]."', firstname = '".$userobj[1]."', lastname = '".$userobj[2]."',".
		" company = '".$userobj[3]."', email = '".$userobj[4]."' WHERE userid = ".$userid.";";
	$result = mysql_query($sql);
	if($userobj[5]!="undefined"){
		$sql = "UPDATE sb_userauth SET password = '".crypt($userobj[5])."' WHERE userid = $userid;";
		$result = mysql_query($sql);
	}
}
?><html>
<head>
<title>SiteBuddy - User Management</title>
<link rel="stylesheet" type="text/css" href="../css/sb_general.css" />
<script src="../scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="../scripts/AC_ActiveX.js" type="text/javascript"></script>
</head>

<body bgcolor="#FAF8EB">

<div id="top_logo"><img src="../images/titles/sb_user_management.png"></div>

<div>
<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','650','height','50','src','../flash/sb_user_search','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','../flash/sb_user_search', 'bgcolor', '#EACA6A', 'wmode', 'transparent' ); //end AC code
</script><noscript>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="650" height="50" id="sb_user_search" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="../flash/sb_user_search.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#FF0000" />
<param name="wmode" value="transparent" />
<embed src="../flash/sb_user_search" quality="high" bgcolor="#FF0000" width="650" height="50" name="sb_user_search" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object></noscript>
</div>

<?php include "sb_user_search.php"; ?>


</body>
</html>