<?php
/*****************************************
 * Data Manager Administration Screen
 *****************************************/

$baseURL = "../../../";
$action=$_REQUEST["action"];
$pageid = $_REQUEST['pageid'];

include_once($baseURL."includes/mysql_conn.php");

$username="west_datauser";
$password="Wre4pA2r";
$database="west_data";
$conn = mysql_connect(localhost,$username,$password);
mysql_select_db($database,$conn);

//Determine the table that needs to be selected
$tableName = "1237west";

if($action=="del"){
	$elemid = $_REQUEST["eid"];
	$pageid = $_REQUEST["pid"];
	$elemname = $_REQUEST["ename"];
	$result = mysql_query("DELETE FROM ".$tableName." WHERE ".$elemname."=".$elemid,$conn);
} else if($action=="add"){
	$result = mysql_query("SELECT * FROM ".$tableName." LIMIT 1",$conn);
	
	$insertSQL = "INSERT INTO ".$tableName." (";
	$dataSQL = "";
	$i=$j=0;
	while ($i < mysql_num_fields($result)) {  
		$fieldObj = mysql_fetch_field($result, $i);         
		if($fieldObj->primary_key!=1){
			if(!empty($_REQUEST[$fieldObj->name])){
				$strCatch = ($fieldObj->type=="string")?"'":"";
				$insertSQL .= (($j>0)?",":"")."`".$fieldObj->name."`"." ";
				$dataSQL .= (($j>0)?",":"").$strCatch.$_REQUEST[$fieldObj->name].$strCatch;
				$j++;
			}
		}
		$i++;
	}
	$insertSQL .= ") values (".$dataSQL.");";
	$result = mysql_query($insertSQL,$conn);
	//echo($insertSQL);
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
?><html>
<head>
<title>SiteBuddy - Data Manager</title>
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL) ?>css/sb_general.css" />
<script src="<?php echo($baseURL) ?>scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/AC_ActiveX.js" type="text/javascript"></script>
</head>

<body bgcolor="#FAF8EB">

<div style="position:absolute;top:7px;width:250px;left:655px;text-align:right;"><a href="data_profile.php?action=add&pid=<?php echo($pageid); ?>" target="_self"><img src="../images/add_elem_icon.png" style="border-style: none;"></a></div>
<h2 style="width:300px;">Data Manager</h2>

<?php include "data_result.php"; ?>

</body>
</html>