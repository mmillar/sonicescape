<SCRIPT TYPE="text/javascript">
<!--
function sendTest(id,attrib,val,hide,show){
    $("#info").html("<font color='blue'>Processing....</font>"); 
    $("#info").load("./mailer/send_test_email.php"); 
}
function gotoStep(pagenum){
	$("#mailer_step").val(pagenum);
	$("#mailer_form").submit();
}
//-->
</SCRIPT>

<form id="mailer_form" method="post" action="contact_mailer.php">

	<div style="width: 80%">
		<h3>Step 3 - Select the Contact Group(s)</h3>
		
		<table cellpadding=4 cellspacing=10>
		<thead>
		<tr ><th scope="col">&nbsp</th>
		<th scope="col">Name</th>
		<th scope="col">Description</th></tr>
		</thead>
		<tbody>
<?php
while($group=mysql_fetch_object($groups)){
	echo("<tr valign=\"top\"><td><input type=\"checkbox\" name=\"recipient_groups[]\" value=\"".$group->groupid."\"  /></td>\n");
	echo("<td><b>".$group->name."</b></td>\n");
	echo("<td>".$group->description."</td></tr>\n");
}
?>
		</tbody>
		</table>
		<br>
		
		<input type="hidden" name="step" id="mailer_step">
		<button type="button" onclick="gotoStep(2);return false;" style="float:left;">Previous</button>
		<button type="button" onclick="gotoStep(4);return false;" style="float:right;">Next</button>
	</div>
</form>

</body>
</html>
