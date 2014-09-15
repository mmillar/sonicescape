<?php
/*****************************************
 * Contact Manager Administration Screen
 *****************************************/
session_start();

$baseURL = "../../../";
$user = null;

include_once($baseURL."includes/access.php");
include_once($baseURL."includes/security.php");

$action=ISSET($_REQUEST["action"])?$_REQUEST["action"]:"";
$step=ISSET($_REQUEST["step"])?(int)$_REQUEST["step"]:1;

?>
<html>
<head>
<title>SiteBuddy - Contact Mailer</title>
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL) ?>css/sb_general.css" />
<link rel="stylesheet" type="text/css" href="../css/sb_contacts.css" />
<script src="<?php echo($baseURL) ?>scripts/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/jquery.corner.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/jquery.curvycorners.packed.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/jquery.tablesorter.min.js" type="text/javascript"></script>

<!-- TinyMCE -->
<script src="<?php echo($baseURL) ?>scripts/tiny_mce.js" type="text/javascript"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

</head>
<body>

<?php
if($step==1){
	$email_subject=ISSET($_SESSION["email_subject"])?$_SESSION["email_subject"]:"";
	$email_body=ISSET($_SESSION["email_body"])?$_SESSION["email_body"]:"";
	include("./mailer/mailer_step1.php");
} else if($step==2){
	if(ISSET($_REQUEST["email_subject"])) $_SESSION["email_subject"] = $_REQUEST["email_subject"];
	if(ISSET($_REQUEST["email_body"])) $_SESSION["email_body"] = $_REQUEST["email_body"];
	include("./mailer/mailer_step2.php");
} else if($step==3){
	$query = "SELECT * FROM sb_cnt_groups";
	$groups = mysql_query($query);

	include("./mailer/mailer_step3.php");
} else if($step==4){
	$contacts = ISSET($_SESSION["email_recipients"])?$_SESSION["email_recipients"]:array();
	
	if(ISSET($_REQUEST["recipient_groups"])){
		$grpList = $_REQUEST["recipient_groups"];
		$grpQuery = "(";
		for($i=0; $i<count($grpList); $i++){
			if($i>0) $grpQuery .= ",";
			$grpQuery .= $grpList[$i];
		}
		$grpQuery .= ")";
		
		$query = "SELECT * FROM (SELECT DISTINCT contactid FROM sb_cnt_grouplist WHERE groupid IN ".$grpQuery." ORDER BY contactid ASC) cl LEFT JOIN sb_contacts c using(contactid)";
		$cntList = mysql_query($query);
		
		$contacts = array();
		while($contact=mysql_fetch_object($cntList)){
			$contacts[] = $contact;
		}
		
		$_SESSION["email_recipients"] = $contacts;
	}
	
	if($action=="remove_contact"){
		$contacts = $_SESSION["email_recipients"];
		$remid = $_REQUEST["contactid"];
	
		$i=$j=0;
		while($i<count($contacts)){
			if(!empty($contacts[$j])){
				$i++;
				if($contacts[$j]->contactid == (int)$remid) unset($contacts[$j]);
			}
			$j++;
		}
		
		$_SESSION["email_recipients"] = $contacts;
	}

	$filters = ISSET($_SESSION['sb_contact_filters'])?$_SESSION['sb_contact_filters']:array();
	
	// Retrieve listing of user contact elements
	$query = "Select * from sb_cnt_fields ORDER BY sequence ASC";
	$fld_result = mysql_query($query);
	
	$field_order = "";
	$field_array = array();
	while($field=mysql_fetch_object($fld_result)){
		if($field->visible){
			$field_order .= ($field_order=="")?$field->name:(", ".$field->name);
			$field_array[] = $field->name;
		}
	}

	include("./mailer/mailer_step4.php");
} else if($step==5){
	$contacts = ISSET($_SESSION["email_recipients"])?$_SESSION["email_recipients"]:array();

	include("./mailer/mailer_step5.php");
}
?>
