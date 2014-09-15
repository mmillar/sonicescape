<?php 
/* This is where you would inject your sql into the database 
but we're just going to format it and send it back 
*/ 
$baseURL = "../../../";
include_once($baseURL."includes/mysql_conn.php");

foreach ($_GET['listItem'] as $position => $item) : 
  mysql_query($sql[] = "UPDATE sb_cnt_fields SET sequence = ".($position+1)." WHERE name = '$item'"); 
endforeach; 
//print_r ($sql);
echo("<font color='green'>Order Updated!!!!</font>");
?>