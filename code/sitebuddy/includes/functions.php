<?php
function generateSearchSQL($field,$str,$rev,$switch){
	$newSearchSQL ="";
	if($str!="") {
	  $pieces = explode(" ", $str);
	  foreach($pieces as $piece){
		if($newSearchSQL!="") $newSearchSQL .= " ".(($switch)?"OR":"AND")." ";
		$newSearchSQL .= "(".$field.(($rev)?" NOT":"")." LIKE '%".$piece."%')";
	  }
	  if($rev) $newSearchSQL .= " OR (".$field." is null)";
	} else {
	  $newSearchSQL = "(".$field." IS ".(($rev)?"NOT ":"")."null ".($rev?"AND":"OR")." ".$field.(($rev)?" <> ":" = ")."'')";
	}
	return $newSearchSQL;
}
?>
