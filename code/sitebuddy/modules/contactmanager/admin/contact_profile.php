<?php
/*****************************************
 * Data Manager Profile Screen
 *****************************************/

session_start();

$baseURL = "../../../";
$action = ISSET($_REQUEST["action"])?$_REQUEST["action"]:"";
$contactid = ISSET($_REQUEST["contactid"])?$_REQUEST["contactid"]:"";

include_once($baseURL."includes/mysql_conn.php");

$tableName = "sb_contacts";

$close_win = false;

if(ISSET($_REQUEST["submit"])){
	if($action=="add"){
		$result = mysqli_query($conn, "SELECT * FROM sb_contacts LIMIT 1");
		
		$insertSQL = "INSERT INTO ".$tableName." (";
		$dataSQL = "";
		$i=$j=0;
		while ($i < mysqli_num_fields($result)) {  
			$fieldObj = mysqli_fetch_field($result);         
			if(!($fieldObj->flags & PRI_KEY_FLAG)){
				if(!empty($_REQUEST[$fieldObj->name])){
					$strCatch = ($fieldObj->type==MYSQLI_TYPE_VAR_STRING || $fieldObj->type==MYSQLI_TYPE_BLOB)?"'":"";
					$insertSQL .= (($j>0)?",":"")."`".$fieldObj->name."`"." ";
					$dataSQL .= (($j>0)?",":"").$strCatch.mysqli_real_escape_string($conn, $_REQUEST[$fieldObj->name]).$strCatch;
					$j++;
				}
			}
			$i++;
		}
		// Add in contact creation/modified date
		$insertSQL .= (($j>0)?",":"")."`modified`"." ";
		$dataSQL .= (($j>0)?",":"")."NOW()";
		$j++;
		$insertSQL .= (($j>0)?",":"")."`created`"." ";
		$dataSQL .= (($j>0)?",":"")."NOW()";
	
		$insertSQL .= ") values (".$dataSQL.");";
		$result = mysqli_query($conn, $insertSQL);
		$contactid = mysqli_insert_id($conn); 
		//echo($insertSQL);
	} else if($action=="edit"){
		$result = mysqli_query($conn, "SELECT * FROM sb_contacts LIMIT 1");
		
		$updateSQL = "UPDATE ".$tableName." SET ";
		$i=$j=0;
		while ($i < mysqli_num_fields($result)) {  
			$fieldObj = mysqli_fetch_field($result);         
			if(!($fieldObj->flags & MYSQLI_PRI_KEY_FLAG) && $fieldObj->type!=MYSQLI_TYPE_DATETIME){
				$strCatch = ($fieldObj->type==MYSQLI_TYPE_VAR_STRING || $fieldObj->type==MYSQLI_TYPE_BLOB)?"'":"";
				$updateSQL .= (($j>0)?",":"").$fieldObj->name." = ".$strCatch.mysqli_real_escape_string($conn, $_REQUEST[$fieldObj->name]).$strCatch." ";
				$j++;
			}
			$i++;
		}
		// Update contact modified date
		$updateSQL .= (($j>0)?",":"")."modified=NOW() ";
	
		$updateSQL .= "WHERE contactid=".$_REQUEST["contactid"];
		$result = mysqli_query($conn,$updateSQL);
		//echo($updateSQL);
		//echo(fieldObj-type);
	}
	if($_REQUEST["submit"]=="Save Contact"){
		$close_win = true;
	} else {
		$action = "add";
	}
}

$sql = "SELECT * from sb_cnt_fields ORDER BY sequence ASC";
$field_result = mysqli_query($conn, $sql);

$contact="";
if($action=="edit" || (ISSET($_REQUEST["submit"]) && $_REQUEST["submit"]=="Create Duplicate")){
	$sql = "SELECT * from sb_contacts WHERE contactid=".$contactid;
	$cnt_result = mysqli_query($conn, $sql);
	$contact = mysqli_fetch_object($cnt_result);
}
?>
<html>
<head>
<title>SiteBuddy - Contact Profile - <?php echo($contactid); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL); ?>/css/sb_general.css" />
<script src="<?php echo($baseURL); ?>/scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="<?php echo($baseURL); ?>/scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/jquery-1.4.2.min.js" type="text/javascript"></script>
</head>

<body>

<div id="page_title">
<h2><?php echo("Contact Details"); ?></h2>
</div>

<SCRIPT TYPE="text/javascript">
<!--
function checkSubmit(commentForm){
   return true;
}

//function to check valid email address
function isValidEmail(strEmail){
  validRegExp = /^[^@]+@[^@]+.[a-z]{2,}$/i;

   // search email text for regular exp matches
    if (strEmail.search(validRegExp) == -1) 
   {
      //alert('A valid e-mail address is required.\nPlease amend and retry');
      return false;
    } 
    return true; 
}

function colorSelect(){
	$('#highlight').css('background-color',$('#highlight').val());
}
//-->
</SCRIPT>

<form id="contact_profile" action="contact_profile.php" onsubmit="return checkSubmit(this)" method="post">

<table width="550px">
<tr><td colspan="2" align="center">
<input name="submit" type="submit" value="Save Contact" onsubmit="return checkSubmit(this.form)">
<input name="submit" type="submit" value="Add Another Contact" onsubmit="return checkSubmit(this.form)">
<input name="submit" type="submit" value="Create Duplicate" onsubmit="return checkSubmit(this.form)">
</td></tr>
<tr><td width="150px">Contact ID</td>
<td width="450px"><?php echo(($contact!="")?$contact->contactid:""); ?></td></tr>
<?php
//List of elements that should be copied over in a duplication
$dupl_list = array("format","org","email","website","address","city","region","country","zipcode","tag","phone","initial","notes");

while($field=mysqli_fetch_object($field_result)){
	//clear contact value if duplicate contact
	if(ISSET($_REQUEST["submit"]) && $_REQUEST["submit"]=="Create Duplicate") {
		$inList=false;
		foreach($dupl_list as $val)
			if($field->name == $val)
				$inList=true;

		if(!$inList)
			$contact->{$field->name}="";
	}

	if($field->name=="highlight"){
		$colors = array("#FFF","#EFE","#9F9","#EEF","#99F","#FEE","#F99","#CFF","#6FF","#FCF","#F6F","#FFC","#FF6");
		echo("<tr><td>".$field->display."</td>\n");
		echo("<td><select id=\"highlight\" name=\"highlight\" onChange=\"colorSelect();\" style=\"width: 200px\">\n");
		foreach($colors as $value){
			echo("<option value=\"".$value."\"".(($contact!="" && $contact->{"highlight"}==$value)?" selected=\"true\"":"")." style=\"background-color: ".$value.";\">&nbsp;</option>");
		}
		echo("</select></td></tr>\n");
	} else if($field->name=="pre"){
		$prefixes = array("Mr.","Mrs.","Miss.","Ms.","Prof.","PhD.","Dr.");
		echo("<tr><td>".$field->display."</td>\n");
		echo("<td><select name=\"".$field->name."\">\n");
		echo("<option value=\"\"".(($contact!="" && $contact->{$field->name}!="")?"":" selected=\"true\"").">Choose a prefix</option>");
		foreach($prefixes as $value){
			echo("<option value=\"".$value."\"".(($contact!="" && $contact->{$field->name}==$value)?" selected=\"true\"":"").">".$value."</option>");
		}
		echo("</select></td></tr>\n");
	} else if($field->name=="format"){
		$prefixes = array("First","Prefix.Last","First Last");
		echo("<tr><td>".$field->display."</td>\n");
		echo("<td>");
		foreach($prefixes as $key => $value){
			echo("<input type=\"radio\" name=\"format\" value=\"".$key."\"".((($contact!="" && $contact->{$field->name}==$key)||($contact=="" && $key=0))?" checked":"")." />".$value."&nbsp;&nbsp;");
		}
		echo("<br /></td></tr>\n");
	} else {
		if($field->type=="text"){
			echo("<tr><td>".$field->display."</td>\n");
			echo("<td><input type=\"text\" name=\"".$field->name."\" value=\"".(($contact!="")?$contact->{$field->name}:"")."\" style=\"width:100%;\" /></td></tr>\n");
		} else if($field->type=="textarea"){
			echo("<tr><td valign=\"top\">".$field->name."</td>\n");
			echo("<td><textarea name=\"".$field->name."\" rows=\"5\" style=\"width:100%;\">".(($contact!="")?$contact->{$field->name}:"")."</textarea></td></tr>\n");
		} else if($field->type=="checkbox"){
			echo("<tr><td>".$field->name."</td>\n");
			echo("<td><input type=\"checkbox\" name=\"".$field->name."\"".(($contact!="" && $contact->{$field->name})?" checked":"")."\" style=\"width:100%;\" /></td></tr>\n");
		}
	}
}
?>
<tr><td>Last Modified</td>
<td><?php echo(($contact!="")?$contact->modified:""); ?></td></tr>
<tr><td>Created</td>
<td><?php echo(($contact!="")?$contact->created:""); ?></td></tr>

<tr><td colspan="2" align="center">
<input name="submit" type="submit" value="Save Contact" onsubmit="return checkSubmit(this.form)">
<input name="submit" type="submit" value="Add Another Contact" onsubmit="return checkSubmit(this.form)">
<input name="submit" type="submit" value="Create Duplicate" onsubmit="return checkSubmit(this.form)">
</td></tr></table>

<input type="hidden" name="action" value="<?php echo($action=="add")?"add":"edit"; ?>">
<input type="hidden" name="contactid" value="<?php echo($contact->contactid) ?>">

</form>

<script type="text/javascript">
$(document).ready(function() 
    { 
    	colorSelect(); 
<?php //if(ISSET($_REQUEST["submit"])) echo("	window.open(\"contact_list.php\",\"sb_modulepage\");\n"); 
if($close_win) echo("	window.close();\n"); ?>
    } 
); 
</script>
</body>
</html>
