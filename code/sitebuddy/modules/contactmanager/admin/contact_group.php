<?php
/*****************************************
 * Contact Manager Administration Screen
 *****************************************/
session_start();

$baseURL = "../../../";

include_once($baseURL."includes/mysql_conn.php");

$action=ISSET($_REQUEST["action"])?$_REQUEST["action"]:"";

$groupid=ISSET($_REQUEST["group_sel"])?$_REQUEST["group_sel"]:"";
$tableName = "sb_contacts";

if($action=="del_contact_from_group"){
	$query = "DELETE FROM sb_cnt_grouplist WHERE contactid = ".$_REQUEST['contactid']." AND groupid = ".$groupid;
	$result = mysql_query($query);
} else if($action=="update_group"){
	$query = "UPDATE sb_cnt_groups set name='".$_REQUEST['group_name']."', description='".$_REQUEST['group_desc']."' WHERE groupid=".$groupid;
	$result = mysql_query($query);
} else if($action=="delete_group"){
	$query = "DELETE FROM sb_cnt_groups WHERE groupid=".$groupid;
	$result = mysql_query($query);

	$query = "DELETE FROM sb_cnt_grouplist WHERE groupid=".$groupid;
	$result = mysql_query($query);
	
	$groupid="";
}

$filters = ISSET($_SESSION['sb_contact_filters'])?$_SESSION['sb_contact_filters']:array();

// Retrieve listing of user contact elements
$query = "Select * from sb_cnt_fields ORDER BY sequence ASC";
$fld_result = mysql_query($query);

// Retrieve listing of user contact elements
$query = "Select * from sb_cnt_groups ORDER BY name ASC";
$group_result = mysql_query($query);

?><html>
<head>
<title>SiteBuddy - Contact Group Manager</title>
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL) ?>css/sb_general.css" />
<link rel="stylesheet" type="text/css" href="../css/sb_contacts.css" />
<script src="<?php echo($baseURL) ?>scripts/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/jquery.corner.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/jquery.curvycorners.packed.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/jquery.tablesorter.min.js" type="text/javascript"></script>
<SCRIPT TYPE="text/javascript">
<!--
function addContact(){
	window.open("contact_profile.php?action=add", "pb_contact_profile",'location=0,status=0,scrollbars=1,width=620,height=570');
}
function delGroup(grpname){
	alert("sdfasdf");
	var response = confirm("Are you sure you want to delete the group '"+grpname+"'?");
	if(response){
		$('#form_action').val("delete_group");
		$('#group_form').submit();
	}
}
//-->
</SCRIPT>
</head>

<?php
$field_order = "";
$field_array = array();
while($field=mysql_fetch_object($fld_result)){
	if($field->visible){
		$field_order .= ($field_order=="")?$field->name:(", ".$field->name);
		$field_array[] = $field->name;
	}
}
?>

<body bgcolor="#FAF8EB">

<h2 style="width:300px;">Contact Group Manager</h2>
<?php 
if($groupid==""){
	echo("<form id=\"group_form\" action=\"contact_group.php\">\n");
	echo("Please select a group to manage:<br>");
	echo("<select id=\"group_sel\" name=\"group_sel\" style=\"width:150px\">\n");
	echo("	<option value=\"-1\">Select a Group</option>\n");
	while($group=mysql_fetch_object($group_result)){
		echo("		<option value=\"".$group->groupid."\"");
		echo(">".$group->name."</option>\n");
	}
	echo("</select>\n<input type=\"submit\" value=\"Manage\">\n</form>\n");
} else {
	$result = mysql_query("SELECT * FROM sb_cnt_groups WHERE groupid = ".$groupid.";");
	$group = mysql_fetch_object($result);
?>
	<form id="group_form" action="contact_group.php">
	<table cellpadding=5 cellspacing=2>
	<tr><td>Name: </td>
	<td><input type="test" name="group_name" value="<?php echo($group->name); ?>" style="width:300px"></td>
	<td><input type="submit" value="Update"></td>
	</tr><tr valign="top">
	<td>Description:</td>
	<td><textarea name="group_desc" style="width:300px"><?php echo($group->description); ?></textarea></td>
	<td><button type="button" onclick="delGroup('<?php echo($group->name); ?>');return false;">Delete</button></td>
	</tr></table>
	<input type="hidden" name="group_sel" value="<?php echo($group->groupid); ?>">
	<input type="hidden" id="form_action" name="action" value="update_group">
	</form>
<?php
	include "group_results.php";
}?>

</body>
</html>