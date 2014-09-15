<?php
session_start();

$baseURL = "../../../../";
$user = null;

include_once($baseURL."includes/access.php");
include_once($baseURL."includes/security.php");

function sendmail($recName,$recEmail,$ccName,$ccEmail,$subject,$mailbody){
	$delimiter = "\n";
	
	// Specify Variable elements
	$fromname = "SiteBuddy Automailer";
	$replyTo = $returnTo = $fromemail = ISSET($_REQUEST["email_sender"])?$_REQUEST["email_sender"]:"no-reply@verto.ca";
	$toname = $recName;
	$toemail = $recEmail;
	$domain = "sonicescapemusic.com";
	
	ini_set("SMTP","mail.".$domain);
	ini_set("smtp_port",26);
	ini_set("sendmail_from",$returnTo);
	
	// To send HTML mail, the Content-type header must be set
	// Generate HTML anti-spam header
	$msgid = '<' . gmdate('YmdHs') . '.' . substr(md5($mailbody . microtime()), 0, 6) . rand(100000, 999999) . '@' . $domain . '>';
	$headers = 'Message-ID: ' . $msgid . $delimiter;
	$headers .= 'X-Mailer: PHP/' . phpversion() . $delimiter;
	$headers .= 'X-Priority: 3' . $delimiter;
	$headers .= 'Content-Type: text/html' . $delimiter;
	$headers .= 'Content-Transfer-Encoding: 8bit' . $delimiter;
	$headers .= 'From: "' . $fromname . '" <' . $fromemail . '>' . $delimiter;
	$headers .= 'To: "' . $toname . '" <' . $toemail . '>' . $delimiter;
	if(!empty($ccEmail)){
		$headers .= 'Cc: '. $ccEmail . $delimiter;
	}
	//$headers .= 'Bcc: support@verto.ca' . $delimiter;
	$headers .= 'Reply-To: <' . $replyTo . '>' . $delimiter;
	$headers .= 'Return-Path: '.$fromemail . $delimiter;
	$headers .= 'MIME-Version: 1.0' . $delimiter;
	
	mail($toemail,$subject,$mailbody,$headers);
}

sendmail(ISSET($_REQUEST["email_recipient_name"])?$_REQUEST["email_recipient_name"]:($user->firstname." ".$user->lastname),ISSET($_REQUEST["email_recipient"])?$_REQUEST["email_recipient"]:$user->email,"","",ISSET($_REQUEST["email_subject"])?$_REQUEST["email_subject"]:$_SESSION["email_subject"], ISSET($_REQUEST["email_body"])?$_REQUEST["email_body"]:$_SESSION["email_body"]);?>Mail sent to <?php echo($user->email); ?>
