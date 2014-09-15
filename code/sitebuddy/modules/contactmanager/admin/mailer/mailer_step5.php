<div>
<h3>Step 5 - Send e-mails</h3>
		
<?php	
$i=$j=0;
while($j<count($contacts)){
	if(!empty($contacts[$i])){
		$contact = $contacts[$i];
		if($j!=0) echo("\", function(){ setTimeout(function(){ sendContact".$i."();},2000); });\n}</SCRIPT>\n");
		echo("<div id=\"results_".$i."\"></div>\n");
		echo("<SCRIPT TYPE=\"text/javascript\">\n");
		if($j==0) echo("sendContact".$i."();\n");?>
function sendContact<?php echo($i); ?>(){
    $("#results_<?php echo($i); ?>").html("<font color='blue'>Processing....</font>"); 
    $("#results_<?php echo($i); ?>").load("./mailer/download_list.php?contact_index=<?php echo($i); 	
		$j++;
	}
	$i++;
}
?>");
}</SCRIPT>
		
</div>

</body>
</html>
