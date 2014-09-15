<?php
//session_start();

// Database information
include("../includes/access.php");
     
//require("../includes/security.php");

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die("Unable to select database");

$pageid = $_REQUEST["pageid"];

$query="SELECT * FROM sb_section s left join sb_module m using (moduleid) where s.pageid=$pageid";
$result=mysql_query($query);
if($result){
	echo("&numtabs=".mysql_num_rows($result));
	$count=0;
	while($tab=mysql_fetch_object($result)){
		$count++;
		echo("&pageid".$count."=".urlencode($tab->pageid));
		echo("&moduleid".$count."=".urlencode($tab->moduleid));
		echo("&shortname".$count."=".urlencode($tab->shortname));
		echo("&longname".$count."=".urlencode($tab->longname));
		echo("&description".$count."=".urlencode($tab->shortname));
		echo("&tabcolor".$count."=0x".urlencode($tab->color));
		echo("&filename".$count."=".urlencode($tab->filename));
	}
}
//echo("&done=done");
?>

