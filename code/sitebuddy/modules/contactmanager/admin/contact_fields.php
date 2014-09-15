<?php
/*****************************************
 * Data Manager Administration Screen
 *****************************************/

session_start();

$baseURL = "../../../";
include_once($baseURL."includes/access.php");

include_once($baseURL."includes/security.php");

$action=ISSET($_REQUEST["action"])?$_REQUEST["action"]:"";

if($action=="del_field"){
	$result = mysql_query("ALTER TABLE sb_contacts DROP COLUMN ".$_REQUEST["field_name"]);
	$result = mysql_query("DELETE FROM sb_cnt_fields WHERE fieldid = ".$_REQUEST["field_id"]);
} else if($action=="add_field"){
	$insertSQL = "INSERT INTO sb_cnt_fields (name, display, sequence, type, mandatory, visible) ";
	$insertSQL .= "SELECT '".$_REQUEST["field_name"]."', '".$_REQUEST["display_name"]."', MAX(sequence)+1, '".$_REQUEST["field_type"]."', ".(ISSET($_REQUEST["field_mand"])?"true":"false").", ".(ISSET($_REQUEST["field_visible"])?"true":"false")." FROM sb_cnt_fields";
	//echo($insertSQL);
	$result = mysql_query($insertSQL);
	//Set column type based on field
	$col_type = "";
	if($_REQUEST["field_type"]=="text"){
		$col_type = "VARCHAR(200)";
	} else if($_REQUEST["field_type"]=="textarea"){
		$col_type = "TEXT";
	} else if($_REQUEST["field_type"]=="checkbox"){
		$col_type = "BOOLEAN";
	}
	$result = mysql_query("ALTER TABLE sb_contacts ADD COLUMN ".$_REQUEST["field_name"]." ".$col_type);
} else if($action=="edit"){
	$elemid = $_REQUEST["elemid"];
	$elemname = $_REQUEST["elemname"];

	$result = mysql_query("SELECT * FROM ".$tableName." LIMIT 1",$conn);
	
	$updateSQL = "UPDATE ".$tableName." SET ";
	$i=$j=0;
	while ($i < mysql_num_fields($result)) {  
		$fieldObj = mysql_fetch_field($result, $i);         
		if($fieldObj->primary_key!=1){
			$strCatch = ($fieldObj->type=="string")?"'":"";
			$updateSQL .= (($j>0)?",":"").$fieldObj->name." = ".$strCatch.$_REQUEST[$fieldObj->name].$strCatch." ";
			$j++;
		}
		$i++;
	}
	$updateSQL .= "WHERE ".$elemname."=".$elemid;
	$result = mysql_query($updateSQL,$conn);
	//echo($updateSQL);
}

// Retrieve filter values if present
$search_txt=ISSET($_REQUEST["search_txt"])?$_REQUEST["search_txt"]:"";
$search_cnd=ISSET($_REQUEST["search_cnd"])?$_REQUEST["search_cnd"]:"";

// Retrieve listing of user contact elements
$query = "Select * from sb_cnt_fields order by sequence ASC";
$fld_result = mysql_query($query);

?><html>
<head>
<title>SiteBuddy - Contacts Manager</title>
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL) ?>css/sb_general.css" />
<link rel="stylesheet" type="text/css" href="../css/sb_contacts.css" />
<script src="<?php echo($baseURL) ?>scripts/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
<SCRIPT TYPE="text/javascript">
<!--
function delField(disp,name,id){
	if(confirm("Do you want to delete "+disp+"("+name+")?")){
	if(confirm("Are you absolutely sure you want to delete "+disp+"("+name+")?")){
	if(confirm("Are you super-duper absolutely sure and forever able hold your peace about deleting "+disp+"("+name+")?")){
		window.open("contact_fields.php?action=del_field&field_name="+name+"&field_id="+id,"_self");
	}
	}
	}
}
function toggleField(id,attrib,val,hide,show){
	$(hide).css('display','none');
	$(show).css('display','block');
    $("#info").html("<font color='blue'>Processing....</font>"); 
    $("#info").load("process-updateval.php?fieldid="+id+"&attrib="+attrib+"&value="+val); 
}
//-->
</SCRIPT>
</head>

<body bgcolor="#FAF8EB">

<h2 style="width:300px;">Contact Settings</h2>

<div id="contact_fields">
	
	<h3>Contact Fields</h3>
	
    <div id="add_container">
    	<h5>Add a New Field</h5>
		<form action="contact_fields.php" method="get"> 
		<table width="100%">
		<tr><td>Name: <input type="text" name="field_name" size="10" /></td>
		<td>Disp: <input type="text" name="display_name" /></td>
		<td>Type: <select name="field_type">
		<option>text</option>
		<option>textarea</option>
		</select>
		</td>
		<td><input type="submit" value="Submit" /></td>
		</table>
		<input type="hidden" name="field_visible" value="true" /> 
		<input type="hidden" name="action" value="add_field" /> 
		</form>
    </div> 
	<ul id="field-list"> 
<?php
while($field=mysql_fetch_object($fld_result)){
echo("	  <li id=\"listItem_".$field->name."\">\n");
echo("	    <img src=\"".$baseURL."/images/arrow.png\" alt=\"move\" width=\"16\" height=\"16\" class=\"handle\" />\n");
echo("	    <strong>".$field->display." (".$field->name.")</strong>\n"); 
if(!$field->mandatory) echo("<div class=\"deleteIcon\" onclick=\"delField('".$field->display."','".$field->name."',".$field->fieldid.");\" style=\"float:right\"></div>\n");
echo("<div id=\"visIcon".$field->fieldid."\" class=\"visibleIcon\" onclick=\"toggleField(".$field->fieldid.",'visible',0,$('#visIcon".$field->fieldid."')[0],$('#visIconFade".$field->fieldid."')[0]);\" style=\"float:right".((!$field->visible)?"; display:none":"")."\"></div>\n");
echo("<div id=\"visIconFade".$field->fieldid."\" class=\"visibleIconFade\" onclick=\"toggleField(".$field->fieldid.",'visible',1,$('#visIconFade".$field->fieldid."')[0],$('#visIcon".$field->fieldid."')[0]);\" style=\"float:right".(($field->visible)?"; display:none":"")."\"></div>\n");
echo("	  </li>\n");
}?>	</ul> 
    <div id="info">Waiting for update</div> 
</div>

<script type="text/javascript"> 
// When the document is ready set up our sortable with it's inherant function(s) 
$(document).ready(function() { 
  $("#field-list").sortable({ 
    handle : '.handle', 
    update : function () { 
      var order = $('#field-list').sortable('serialize'); 
      $("#info").html("<font color='blue'>Processing....</font>"); 
      $("#info").load("process-fieldsort.php?"+order); 
    } 
  }); 
}); 
</script>

<div id="contact_tags">
	
	<h3>Contact Tags</h3>
	
    <div id="add_container">
    	<h5>Add a New Tag</h5>
		<form action="contact_fields.php" method="get"> 
		<table width="100%">
		<tr><td>Tag Name: <input type="text" name="field_name" /></td>
		<td><input type="submit" value="Submit" /></td>
		</table>
		<input type="hidden" name="action" value="add_tag" /> 
		</form>
    </div> 
	
</div>

</body>
</html>