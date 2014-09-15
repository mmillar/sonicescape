<script type="text/javascript">
function sendTest(){ 
	tinyMCE.triggerSave(true, true);
	//alert($("#email_form").serialize());
	$.post("mailer/send_test_email.php", $("#email_form").serialize(), function(data) {
 		alert(data);
	});
} 
</script>

<form id="email_form" method="post" action="contact_mailer.php">

	<div style="width: 80%">
		<h3>Step 1 - Create E-mail Content</h3>

		Subject: <br />
		<input type="text" name="email_subject" value="<?php echo($email_subject); ?>" style="width:100%;"><br /><br />

		<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
		<div>

			<textarea id="email_body" name="email_body" rows="15" cols="80" style="width:100%"><?php echo($email_body); ?></textarea>
		</div>
		<br />
		<!-- Some integration calls -->
		<div>
			<a href="javascript:;" onmousedown="tinyMCE.execCommand('mceInsertContent',false,'*name*');">[Insert Name]</a>
			<a href="javascript:;" onmousedown="tinyMCE.execCommand('mceInsertContent',false,'*org*');">[Insert Organization]</a>
			<a href="javascript:;" onmousedown="tinyMCE.execCommand('mceInsertContent',false,'*city*');">[Insert City]</a>
			<a href="javascript:;" onmousedown="tinyMCE.execCommand('mceInsertContent',false,'*region*');">[Insert Region]</a>
	
			<input type="hidden" name="step" value="2" />
			<input name="submit" type="submit" name="save" value="Next" style="float:right;" /></form>
			<button type="button" onclick="sendTest()" style="float:right;">Send Test Email</button>
		</div>
	</div>

</body>
</html>
