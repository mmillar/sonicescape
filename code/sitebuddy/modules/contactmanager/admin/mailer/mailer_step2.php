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
		<h3>Step 2 - Send a Test-Email</h3>

		<div style="text-align:center;">
			<button type="button" onclick="sendTest()" style="font-size:25pt">Send Test Email</button>
			<br />		
			<div id="info">Be sure to test the e-mail to ensure it is formatted correctly<br><Br></div>
			
			<input type="hidden" name="step" id="mailer_step" value="3">
			<button type="button" onclick="gotoStep(1);return false;" style="float:left;">Previous</button>
			<button type="button" onclick="gotoStep(3);return false;" style="float:right;">Next</button>
		</div>
	</div>
</form>

</body>
</html>
