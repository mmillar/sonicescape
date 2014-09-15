<?php
session_start();

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

include_once($baseURL."includes/access.php");
include_once($baseURL."includes/security.php");

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
$contacts = $_SESSION["email_recipients"];

// loop over the rows, outputting them
for ($i=0; $i<count($contacts); $i++){
	$contact = $contacts[$i];

	if($contact->format==0) $name = $contact->first;
	if($contact->format==1) $name = $contact->pre." ".$contact->last;
	if($contact->format==2) $name = $contact->first." ".$contact->last;

	fputcsv($output, array(add_quotes($name), add_quotes($contact->pre), add_quotes($contact->first), add_quotes($contact->last), add_quotes($contact->org), add_quotes($contact->city), add_quotes($contact->region), add_quotes($contact->email)));
}

function add_quotes($str){
	return str_replace(',', '\\', $str); 
}

?>
