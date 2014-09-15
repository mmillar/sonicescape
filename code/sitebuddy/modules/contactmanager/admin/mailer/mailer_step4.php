<SCRIPT TYPE="text/javascript">
<!--
function sendTest(id,attrib,val,hide,show){
    $("#info").html("<font color='blue'>Processing....</font>"); 
    $("#info").load("./mailer/send_test_email.php"); 
}
function gotoStepAndAlert(pagenum,alert_txt){
	if(confirm(alert_txt)){
		$("#mailer_step").val(pagenum);
		$("#mailer_form").submit();
	}
}
//-->
</SCRIPT>

<form id="mailer_form" method="post" action="contact_mailer.php">

	<div>
		<h3>Step 4 - Verify the Recipient List</h3>
		
<?php include("./mailer/contact_listing.php"); ?>
		<br>
		
		<input type="hidden" name="step" id="mailer_step">
		<button type="button" onclick="gotoStepAndAlert(3,'Going back will clear the list of any changes you have made. Proceed?');return false;" style="float:left;">Previous</button>
		<button type="button" onclick="gotoStepAndAlert(5,'Clicking yes will send your e-mail to all of the recipients on this list');return false;" style="float:right;">Next</button>
	</div>
</form>

</body>
</html>
