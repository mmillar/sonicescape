<?php

// Database information
include_once($baseURL."includes/mysql_conn.php");
     
//require($baseURL."includes/security.php");

$search_str = $_REQUEST["s"];

$query="SELECT unitid,UnitType, RoomTypeAbbr, SquareFeet, NumberOfOccupants, Bedrooms, Bathrooms FROM ".$tableName.";";
$result=mysql_query($query,$conn);
?>
<SCRIPT TYPE="text/javascript">
<!--
function delUser(str,id,ename,pi){
	if(confirm("Do you want to delete "+str+"?")){
		window.open("data_manager.php?action=del&eid="+id+"&ename="+ename+"&pid="+pi,"_self");
	}
}
function editUser(id,ename,pi){
	window.open("data_profile.php?action=edit&eid="+id+"&ename="+ename+"&pid="+pi,"_self");
}
//-->
</SCRIPT>

<table id="mytable" width="900" cellspacing="0" class="listTable">
<caption>Ref Table: '<?php echo($tableName); ?>'</caption>
  <tr>
<?php
$i=0;
while ($i < mysql_num_fields($result)) {  
	$fieldObj = mysql_fetch_field($result, $i);         
	echo('	    <th scope="col">'.$fieldObj->name."</th>\n");
	if($fieldObj->primary_key==1){
		$priCol=$i;
		$priColName=$fieldObj->name;
	}
	$i++;
} 
?>	<th scope="col" abbr="Edit">&nbsp;</th>
	<th scope="col" abbr="Delete">&nbsp;</th>
  </tr>
<?php
while($row=mysql_fetch_row($result)){ 
?>  <tr>
<?php
	foreach($row as $val){
		echo("    <td>".(($val==null)?"&nbsp;":$val)."</td>\n");
	}
?>    <td><div class="editIcon" onclick="editUser(<?php echo($row[$priCol].",'".$priColName."',".$pageid); ?>)"></div></td>
    <td><div class="deleteIcon" onclick="delUser(<?php echo("'".$row[$priCol]."',".$row[$priCol].",'".$priColName."',".$pageid); ?>)"></div></td>
  </tr>
<?php } ?>
</table>
