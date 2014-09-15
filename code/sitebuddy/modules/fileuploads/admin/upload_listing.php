<?php

// Database information
include_once($baseURL."includes/mysql_conn.php");
     
require_once($baseURL."includes/security.php");

$baseURL = isset($baseURL)?$baseURL:"../../../";

$query="SELECT * FROM sb_uploads WHERE pageid=".$pageid;
$result=mysql_query($query);
?>
<SCRIPT TYPE="text/javascript">
<!--
function delContent(fn,fi,pi){
	if(confirm("Do you want to delete "+fn+"?")){
		window.open("upload_admin.php?action=del&fileid="+fi+"&pageid="+pi,"_self");
	}
}
function replaceContent(fi){
	alert("worked up to here!");
	var fileForm = document.getElementById("uploadform");
	fileForm.action.value = 'replace';
	fileForm.fileid.value = fi;
	var browserElem = document.getElementById("datafile");
	alert("worked up to here!");
	browserElem.onclick();
}
//-->
</SCRIPT>

<table id="mytable" width="660" cellspacing="0" class="listTable">
  <tr>
    <th scope="col" abbr="File">Filename</th>
    <th scope="col" abbr="Path">Location</th>
    <th scope="col" abbr="Size">Filesize</th>
	<th scope="col" abbr="Type">File Type</th>
	<th scope="col" abbr="Date">Uploaded</th>
	<th scope="col" abbr="Delete">&nbsp;</th>
  </tr>
<?php
while($row=mysql_fetch_object($result)){
?>  <tr>
    <td><?php echo($row->filename); ?></td>
    <td><?php echo($row->path); ?></td>
    <td><?php echo($row->size); ?></td>
    <td><?php echo($row->type); ?></td>
<?php 
	$thisDate = strtotime($row->uploadtime);
	$fmtDate = date("F j, Y, g:i a", $thisDate);    
?>	<td><?php echo($fmtDate); ?></td>
	<td><div class="deleteIcon" onclick="delContent(<?php echo("'".$row->filename."',".$row->fileid.",".$pageid); ?>)"></div></td>
  </tr>
<?php } ?>
</table>
