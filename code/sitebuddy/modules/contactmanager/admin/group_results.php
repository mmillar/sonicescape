<?php

// Database information
include_once($baseURL."includes/access.php");

include_once($baseURL."includes/security.php");

include_once($baseURL."includes/functions.php");
     
$query="SELECT contactid, highlight, format, tag, ".(ISSET($field_order)?$field_order:"*")." FROM (SELECT * FROM sb_cnt_grouplist WHERE groupid=".$groupid.") gl LEFT JOIN sb_contacts c using(contactid);";
//echo($query);
$result=mysql_query($query);

?>
<SCRIPT TYPE="text/javascript">
<!--
function delContact(str,id){
	if(confirm("Do you want to delete '"+str+"' from the group?")){
		window.open("contact_group.php?action=del_contact_from_group&contactid="+id+"&group_sel="+<?php echo($groupid); ?>, "_self");
	}
}
//-->
</SCRIPT>
<?php if($result!=null){?>
<table id="myTable" width="100%" cellspacing="0" class="tablesorter">
  <thead><tr>
<?php
//Value of i is shifted by two due to the permanent fields contactid and highlight
foreach($field_array as $val){
	echo("	    <th scope=\"col\">". $val."</th>\n");
} 
?>	<th scope="col" abbr="Delete">&nbsp;</th>
  </tr></thead>
  <tbody>
<?php
while($contact=mysql_fetch_object($result)){ 
	echo("<tr style=\"background-color:".(($contact->highlight!="")?$contact->highlight:"#FFF").";\">\n");
	foreach($field_array as $val){
		if($val=="first") {
			echo("    <td>".(($contact->format!=1)?"<b style=\"color:black\">":"")."".(($contact->{$val}==null)?"&nbsp;":$contact->{$val})."".(($contact->format!=2)?"</b>":"")."</td>\n");
		} else if($val=="last") {
			echo("    <td>".(($contact->format>0)?"<b style=\"color:black\">":"")."".(($contact->{$val}==null)?"&nbsp;":$contact->{$val})."".(($contact->format>0)?"</b>":"")."</td>\n");
		} else if($val=="pre") {
			echo("    <td>".(($contact->format==1)?"<b style=\"color:black\">":"")."".(($contact->{$val}==null)?"&nbsp;":$contact->{$val})."".(($contact->format==1)?"</b>":"")."</td>\n");
		} else if($val=="email") {
			echo("    <td>".(($contact->email!="")?"<a href=\"mailto:".$contact->email."\">":"")."".(($contact->{$val}==null)?"&nbsp;":$contact->{$val})."".(($contact->email!="")?"</a>":"")."</td>\n");
		} else if($val=="website") {
			echo("    <td>".(($contact->website!="")?"<a href=\"".$contact->website."\" target=\"_blank\">":"")."".(($contact->{$val}==null)?"&nbsp;":$contact->{$val})."".(($contact->website!="")?"</a>":"")."</td>\n");
		} else if($val!="contactid") {
			echo("    <td>".(($contact->{$val}==null)?"&nbsp;":$contact->{$val})."</td>\n");
		} 
	}
?>    <td><div class="removeIcon" onclick="delContact(<?php echo("'".$contact->pre." ".$contact->first." ".$contact->last."',".$contact->contactid); ?>)"></div></td>
  </tr>
<?php }
} else {?>
No Results Found
<?php }?>
	</tbody>
</table>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
</script>
