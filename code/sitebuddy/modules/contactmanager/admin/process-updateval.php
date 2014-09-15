<?php 
/* This is where you would inject your sql into the database 
but we're just going to format it and send it back 
*/ 
$baseURL = "../../../";
include_once($baseURL."includes/mysql_conn.php");

$delim = (!is_numeric($_GET['value']))?"'":"";
mysql_query($sql[] = "UPDATE sb_cnt_fields SET ".$_GET['attrib']." = ".$delim.$_GET['value'].$delim." WHERE fieldid = ".$_GET['fieldid']); 

//print_r ($sql);
echo("<font color='green'>Attribute ".$_GET['attrib']." updated!!!!</font>");
?>