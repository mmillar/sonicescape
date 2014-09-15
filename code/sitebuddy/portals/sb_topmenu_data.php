<?php
//session_start();

// Database information
include("../includes/access.php");
     
//require("../includes/security.php");

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * FROM sb_page";
$result=mysql_query($query);
if($result){
	echo("&numpages=".(mysql_num_rows($result)+1));
	$count=0;
	while($page=mysql_fetch_object($result)){
		$count++;
		echo("&id".$count."=".$page->pageid);
		echo("&name".$count."=".$page->pagename);
		echo("&filename".$count."=".$page->filename);
	}
	$count++;
	echo("&id".$count."=0");
	echo("&name".$count."=Admin");
	echo("&filename".$count."=sb_admin.php");

}
//echo("&done=done");
?>
