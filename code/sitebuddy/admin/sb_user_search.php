<?php

// Database information
include_once("../includes/mysql_conn.php");
     
//require("../includes/security.php");

$search_str = ISSET($_REQUEST["s"])?$_REQUEST["s"]:null;

$query="SELECT * FROM sb_users WHERE deleted=0 AND (";
$words = explode("[ ]+", $search_str);
if(count($words)>=1) {
	for($i=0;$i<count($words);$i++){
		if($i>0) $query .= "OR ";
		$query .= "(firstname LIKE '%".$words[$i]."%') OR (lastname LIKE '%".$words[$i]."%') OR (email LIKE '%".$words[$i]."%') OR (company LIKE '%".$words[$i]."%') ";
	}
}
$query.=");";
$result=mysql_query($query);
?>
<SCRIPT TYPE="text/javascript">
<!--
function delUser(str,id){
	if(confirm("Do you want to delete "+str+"?")){
		window.open("sb_user_admin.php?action=del&uid="+id,"_self");
	}
}
function editUser(id){
	window.open("sb_user_profile.php?action=edit&uid="+id,"_self");
}
//-->
</SCRIPT>

<table id="mytable" width="660" cellspacing="0" class="listTable">
<caption>User Search: 'mmillar'</caption>
  <tr>
    <th scope="col" abbr="User">Username</th>
    <th scope="col" abbr="First">First Name</th>
    <th scope="col" abbr="Last">Last Name</th>
	<th scope="col" abbr="E-mail">E-mail</th>
	<th scope="col" abbr="Role">Company</th>
	<th scope="col" abbr="Edit">&nbsp;</th>
	<th scope="col" abbr="Delete">&nbsp;</th>
  </tr>
<?php
while($row=mysql_fetch_object($result)){
?>  <tr>
    <td><?php echo(($row->username!=null)?$row->username:"&nbsp;"); ?></td>
    <td><?php echo($row->firstname); ?></td>
    <td><?php echo($row->lastname); ?></td>
    <td><?php echo($row->email); ?></td>
    <td><?php echo(($row->company!=null)?$row->company:"&nbsp;"); ?></td>
    <td><div class="editIcon" onclick="editUser(<?php echo($row->userid); ?>)"></div></td>
    <td><div class="deleteIcon" onclick="delUser(<?php echo("'".$row->firstname." ".$row->lastname."',".$row->userid); ?>)"></div></td>
  </tr>
<?php } ?>
</table>
