<?php
/*****************************************
 * SiteBuddy File Upload Manager Screen
 *****************************************/
session_start();

$action = $_REQUEST['action'];
$fileid = $_REQUEST['fileid'];
$pageid = $_REQUEST['pageid'];
$baseURL = "../../../";

include_once($baseURL."includes/mysql_conn.php");

require_once($baseURL."includes/security.php");

$result = mysql_query("SELECT settings FROM sb_section where pageid=".$pageid." AND moduleid=7");
$row=mysql_fetch_object($result);
$newdir = $row->settings;

function mkdir_recursive($pathname, $mode)
{
    is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
    return is_dir($pathname) || @mkdir($pathname, $mode);
}

if($action == "upload") {
	unset($filename);
	
	if(!isset($_FILES) && isset($HTTP_POST_FILES))
	$_FILES = $HTTP_POST_FILES;
	
	if(!isset($_FILES['datafile']))
	$error["datafile"] = "A file was not found.";
	
	$filename = basename($_FILES['datafile']['name']);
	
	if(empty($filename)) $error["filename"] = "The name of the file was not found.";
	
	if(empty($error))
	{
		if(!mkdir_recursive($baseURL."../".$newdir, 0777)){
	  		$error["directory"] = "The upload directory could not be created.";
		}
	
		$result = @move_uploaded_file($_FILES['datafile']['tmp_name'], $baseURL."../".$newdir.$filename);
		if(empty($error) && !$result){
			$error["result"] = "There was an error moving the uploaded file.";
		}else{
			$query="SELECT * FROM sb_uploads WHERE filename='".$filename."' AND path='".$newdir."'";
			$result=mysql_query($query);
			
			if(mysql_num_rows($result)>0){
				$tmpRow = mysql_fetch_object($result);
				
				$query="UPDATE sb_uploads SET size=".$_FILES['datafile']['size'].", type='".$_FILES['datafile']['type']."', uploadtime=NOW() WHERE fileid=".$tmpRow->fileid;
				$result=mysql_query($query);
			} else {
				$query="INSERT INTO sb_uploads (`filename`,`path`,`size`,`type`,`uploadtime`,`pageid`) values ('".$filename."','".$newdir."',".$_FILES['datafile']['size'].",'".$_FILES['datafile']['type']."', NOW(), ".$pageid.")";
				$result=mysql_query($query);
			}
		}
	}
} else if($action == "upload" || $action == "del"){
	$query="SELECT * FROM sb_uploads WHERE fileid=".$fileid;
	$result=mysql_query($query);
	$file=mysql_fetch_object($result);
	
	$myFile = $baseURL."../".$file->path.$file->filename;
	$fh = fopen($myFile, 'w') or die("can't open file");
	fclose($fh);
	unlink($myFile);
	
	if($action == "upload"){
		$query="UPDATE sb_uploads set size=".$_FILES['datafile']['size'].", type='".$_FILES['datafile']['type']."', uploadtime = NOW() WHERE fileid = ".$fileid.";";
		$result=mysql_query($query);
	}else if($action == "del"){
		$query="DELETE FROM sb_uploads WHERE fileid = ".$fileid.";";
		$result=mysql_query($query);
	}
}	
?><html>
<head>
<title>SiteBuddy - Upload Manager</title>
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL) ?>css/sb_general.css" />
<SCRIPT TYPE="text/javascript">
<!--
function checkSubmit(tf){
	if(tf.action.value=='replace'){
		tf.submit();
	}
}
//-->
</SCRIPT>
</head>

<body>

<h2>Upload File</h2>

<div id="upload_file_pane">

<form id="uploadform" action="upload_admin.php" method="post" enctype="multipart/form-data">
<input type="file" id="datafile" name="datafile" onchange="checkSubmit(this.form);" />
<input type="hidden" id="action" name="action" value="upload" />
<input type="hidden" id="fileid" name="fileid" value="" />
<input type="hidden" id="pageid" name="pageid" value="<?php echo($pageid) ?>" />
<input type="submit" value="Upload" />
</form>
</div>

<h2>Uploaded Files</h2>

<?php print_r ($error); ?>

<?php include "upload_listing.php"; ?>

</body>
</html>
