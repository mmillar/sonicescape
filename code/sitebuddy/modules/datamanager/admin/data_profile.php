<?php
/*****************************************
 * Data Manager Profile Screen
 *****************************************/

$baseURL = "../../../";
$action = $_REQUEST["action"];
$pageid = $_REQUEST["pid"];
$elemid = $_REQUEST["eid"];
$elemname = $_REQUEST["ename"];

include_once($baseURL."includes/mysql_conn.php");

$username="west_datauser";
$password="Wre4pA2r";
$database="west_data";
$conn = mysql_connect(localhost,$username,$password);
mysql_select_db($database,$conn);

//Determine the table that needs to be selected
$tableName = "1237west";
$user = null;

if($elemid>0 && $action="edit"){
	$sql = "SELECT * from ".$tableName." WHERE ".$elemname."=".$elemid;
	$result = mysql_query($sql,$conn);
} else {
	$sql = "SELECT * from ".$tableName." LIMIT 1";
	$result = mysql_query($sql,$conn);
}

?>
<html>
<head>
<title>SiteBuddy - User Management</title>
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL); ?>/css/sb_general.css" />
<script src="<?php echo($baseURL); ?>/scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="<?php echo($baseURL); ?>/scripts/AC_ActiveX.js" type="text/javascript"></script>
</head>

<body>

<div id="page_title">
<h2><?php echo("Table '".$tableName."' Element"); ?></h2>
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
//-->
</SCRIPT>

<form id="data_profile" action="data_manager.php" onsubmit="return checkSubmit(this)" method="post">

<?php
$i=0;
$row=mysql_fetch_row($result);

if($elemid>0 && $action="edit"){
	for($i=0;$i<count($row);$i++){
		$fieldObj = mysql_fetch_field($result, $i);
		if($fieldObj->primary_key!=1){
			echo '<div class="input_area"><input type="text" name="'.$fieldObj->name.'" class="text_input"  value="'.$row[$i].'">'.$fieldObj->name."</div>\n";
		} else {
			echo '<div class="input_area"><div class="text_input">'.$row[$i].'</div>'.$fieldObj->name."</div>\n";
		}
	}
} else {
	for($i=0;$i<count($row);$i++){
		$fieldObj = mysql_fetch_field($result, $i);
		if($fieldObj->primary_key!=1){
			echo '<div class="input_area"><input type="text" name="'.$fieldObj->name.'" class="text_input">'.$fieldObj->name."</div>\n";
		} else {
			echo '<div class="input_area"><div class="text_input">auto-assigned</div>'.$fieldObj->name."</div>\n";
		}
	}
}
?>
<div class="input_area" style="text-align:center;"><input type="submit" value="<?php echo($action=="add")?"Add Element":"Update Element"; ?>" class="submit_btn" onsubmit="return checkSubmit(this.form)"></div>

<div class="input_area" style="text-align:center;"><div id="error_post"></div></div>

<input type="hidden" name="action" value="<?php echo($action=="add")?"add":"edit"; ?>">
<input type="hidden" name="elemid" value="<?php echo($elemid) ?>">
<input type="hidden" name="elemname" value="<?php echo($elemname); ?>">
<input type="hidden" name="pageid" value="<?php echo($pageid) ?>">

</form>

</body>
</html>