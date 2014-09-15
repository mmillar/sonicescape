<?php
session_start();

$baseURL = "../../../../";
$user = null;

include_once($baseURL."includes/access.php");
include_once($baseURL."includes/security.php");

function sendmail($recName,$recEmail,$ccName,$ccEmail,$subject,$mailbody,$user){
	$delimiter = "\n";
	
	// Specify Variable elements
	$fromname = $user->firstname." ".$user->lastname;
	$replyTo = $returnTo = $fromemail = $user->email;
	$toname = $recName;
	$toemail = $recEmail;
	$domain = "sonicescapemusic.com";
	
	ini_set("SMTP","mail.".$domain);
	ini_set("smtp_port",25);
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
	//$headers .= 'To: "' . $toname . '" <' . $toemail . '>' . $delimiter;
	if(!empty($ccEmail)){
		$headers .= 'Cc: '. $ccEmail . $delimiter;
	}
	//$headers .= 'Bcc: support@verto.ca' . $delimiter;
	$headers .= 'Reply-To: <' . $replyTo . '>' . $delimiter;
	$headers .= 'Return-Path: '.$fromemail . $delimiter;
	$headers .= 'MIME-Version: 1.0' . $delimiter;
	
	return mail($toname.' <'. $toemail. '>',$subject,$mailbody,$headers);
}

if(ISSET($_REQUEST["contact_index"])){
	$cidx = (int)$_REQUEST["contact_index"];
	$contacts = $_SESSION["email_recipients"];
	
	$contact = $contacts[$cidx];
	
	$bodytmp = $_SESSION["email_body"];

	if($contact->format==0) $name = $contact->first;
	if($contact->format==1) $name = $contact->pre." ".$contact->last;
	if($contact->format==2) $name = $contact->first." ".$contact->last;
	$bodytmp = stripslashes($bodytmp);
	$bodytmp = str_replace("*name*", $name, $bodytmp);
	$bodytmp = str_replace("*prefix*", $contact->pre, $bodytmp);
	$bodytmp = str_replace("*first*", $contact->first, $bodytmp);
	$bodytmp = str_replace("*last*", $contact->last, $bodytmp);
	$bodytmp = str_replace("*org*", $contact->org, $bodytmp);
	$bodytmp = str_replace("*city*", $contact->city, $bodytmp);
	$bodytmp = str_replace("*region*", $contact->region, $bodytmp);
	
	if(!empty($contact->email)) {
		if(sendmail($contact->first." ".$contact->last,$contact->email,"","",$_SESSION["email_subject"], $bodytmp, $user)){
			echo("E-mail has been sent to '".$contact->first." ".$contact->last."' @ ".$contact->email."<br>");
		} else {
			echo("*There was a problem sending the e-mail to '".$contact->first." ".$contact->last."' @ ".$contact->email."*<br>");
		}
	} else {
		echo("*No e-mail address for '".$contact->firstname." ".$contact->last."' @ ".$contact->email.", send aborted*<br>");
	}
}
?>
