<?php

// Database information
include_once($baseURL."includes/mysql_conn.php");

include_once($baseURL."includes/functions.php");
     
//require($baseURL."includes/security.php");

?>
<SCRIPT TYPE="text/javascript">
<!--
function delContact(str,id){
	if(confirm("Do you want to remove '"+str+"' from the list?")){
		window.open("contact_mailer.php?step=4&action=remove_contact&contactid="+id, "_self");
	}
}
//-->
</SCRIPT>

<?php if(!empty($contacts)){?>
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
$i=$j=0;
while($i<count($contacts)){
if(!empty($contacts[$j])){
	$i++;
	$contact = $contacts[$j];
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
?>    <td><div class="removeIcon" onclick="delContact(<?php echo("'".addslashes($contact->pre)." ".addslashes($contact->first)." ".addslashes($contact->last)."',".$contact->contactid); ?>)"></div></td>
  </tr>
<?php } 
$j++;
	}
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
