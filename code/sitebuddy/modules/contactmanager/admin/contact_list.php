<?php
/*****************************************
 * Contact Manager Administration Screen
 *****************************************/
session_start();

$baseURL = "../../../";

include_once($baseURL."includes/access.php");

include_once($baseURL."includes/security.php");

$action=ISSET($_REQUEST["action"])?$_REQUEST["action"]:"";

$groupid="";
$tableName = "sb_contacts";

if($action=="set_filter"){
	$filters = ISSET($_SESSION['sb_contact_filters'])?$_SESSION['sb_contact_filters']:array();
	$filters[] = array("cnd" => $_REQUEST["search_cnd"], "txt" => $_REQUEST["search_txt"], "not" => ISSET($_REQUEST["search_not"]), "switch" => ISSET($_REQUEST["search_or"]));
	$_SESSION['sb_contact_filters'] = $filters;
} else if($action=="remove_filter"){
	$filters = ISSET($_SESSION['sb_contact_filters'])?$_SESSION['sb_contact_filters']:array();
	unset($filters[(int)$_REQUEST["filterid"]]);
	$_SESSION['sb_contact_filters'] = $filters;
} else if($action=="del_contact"){
	$query = "DELETE FROM sb_contacts WHERE contactid = ".$_REQUEST['contactid'];
	$result = mysql_query($query);
} else if($action=="add_to_group"){
	$groupid = ISSET($_REQUEST["group_sel"])?$_REQUEST["group_sel"]:"";
} else if($action=="create_group"){
	$query = "INSERT INTO sb_cnt_groups (`name`) values ('".$_REQUEST['group_name']."');";
	$result = mysql_query($query);
	$groupid = mysql_insert_id();
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
<title>SiteBuddy - Data Manager</title>
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
function addContactsToGroup(){
	var selGroup = $("#group_sel").val();
	if(selGroup == "-1") {
		alert("Please select a group to add these contacts to");
	} else {
		window.location = "contact_list.php?action=add_to_group&group_sel="+selGroup;
	}
}
function createContactsGroup(){
	var reply = prompt("Please enter a name for the new group", "")
	window.location = "contact_list.php?action=create_group&group_name="+reply;
}
//-->
</SCRIPT>
</head>

<body bgcolor="#FAF8EB">

<div style="position:absolute;top:7px;right:20px;">
	<form id="list_actions">
	<button onclick="createContactsGroup();return false;">Create Group</button>
	<select id="group_sel" name="group_sel">
		<option value="-1">Select a Group</option>
<?php
while($group=mysql_fetch_object($group_result)){
	echo("		<option value=\"".$group->groupid."\"");
	echo(">".$group->name."</option>\n");
}
?>		
	</select>
	<button onclick="addContactsToGroup();return false;">Add to Group</button>
	<button onclick="addContact();return false;">Add Contact</button>
	</form>
</div>
<h2 style="width:330px;">Contacts List</h2>
<div id="contact_search">
	<form action="contact_list.php">
	<table width="100%">
	<tr><td>Filter By</td>
	<td><input type="text" name="search_txt" size="20" /></td>
	<td><input type="checkbox" name="search_or" size="20" />OR</td>
	<td><input type="checkbox" name="search_not" size="20" />Not</td>
	<td><select name="search_cnd">
<?php
$field_order = "";
$field_array = array();
while($field=mysql_fetch_object($fld_result)){
	if($field->visible){
		$field_order .= ($field_order=="")?$field->name:(", ".$field->name);
		$field_array[] = $field->name;
	}
	echo("	<option value=\"".$field->name."\"");
	echo(">".$field->name."</option>\n");
}
?>	</select></td>
	<td><input type="submit" value="Set Filter" /></td>
	<input type="hidden" name="action" value="set_filter">
	</form>
<!--	<td><button type="button" onclick="window.location='contact_list.php?id=0';">Reset</button></td> -->
	</tr></table>
</div>

<?php
foreach($filters as $key => $value){
	echo("<div class=\"contact_filter\">".($value["switch"]?"*":"").($value["not"]?"!":"").(($value["txt"]!="")?$value["txt"]:"empty")."<div class=\"removeIcon\" onclick=\"window.location='contact_list.php?action=remove_filter&filterid=".$key."';\" style=\"float:right\"></div></div>");
}
?>
<script type="text/javascript">
$(document).ready(function() 
    { 
        $(".contact_filter").corner("round 6px"); 
    } 
); 
</script>

<?php include "list_results.php"; ?>

</body>
</html>
