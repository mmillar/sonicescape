<?php
/*****************************************
 * SiteBuddy XML Editor Screen
 *****************************************/

$action=$_REQUEST["action"];
$subDate = $_REQUEST["subDate"];
$pageid = $_REQUEST["pageid"];
$baseURL = "../../../";

include_once($baseURL."includes/mysql_conn.php");

//mysql_query("SET NAMES 'utf8'");

if($action=="del"){
	$submitted = date( 'Y-m-d H:i:s', $subDate );
	$result = mysql_query("DELETE from sb_xml_history WHERE pageid=".$pageid." AND submitted='".$submitted."';");
} else if($action=="submit"){
	$content = $_REQUEST["xml_content"];
	$newcontent = str_replace(array('<PRE>','</PRE>'), '', $content);
	$sql = "INSERT INTO sb_xml_history (`pageid`,`submitted`,`content`) values ('".$pageid."',NOW(),'".$newcontent."');";
	$result = mysql_query($sql);
}	

$sql = "SELECT * FROM sb_xml_history sxh left join sb_xml_conf sxc using(pageid) left join sb_page p using(pageid) where pageid=".$pageid." ORDER BY submitted DESC";
$result = mysql_query($sql);
$row = mysql_fetch_object($result);

$tmpContent = $row->content;

$tmpContent = preg_replace("/<a/", '<font color="#299ee0"><a', $tmpContent);
$tmpContent = preg_replace("/<(\/)a>/", "</a></font>", $tmpContent);

$tmpContent = str_replace(array("<",">"), array("[","]"), $tmpContent);

$outXML = str_replace("%XML_CONTENT%", $tmpContent, $row->template);

//$htmlbits = preg_split('/(\[FONT color=#[-:a-z0-9 ]+?\]|\[\/FONT\])/', $outXML , -1,  PREG_SPLIT_DELIM_CAPTURE);
//print_r($htmlbits);
$outXML = preg_replace("/ color=(#[-:A-Za-z0-9]+)/", " color='$1'", $outXML);
$outXML = preg_replace("/ size=1/", " size='4'", $outXML);
$outXML = preg_replace("/ size=2/", " size='8'", $outXML);
$outXML = preg_replace("/ size=3/", " size='12'", $outXML);
$outXML = preg_replace("/ size=4/", " size='16'", $outXML);
$outXML = preg_replace("/ size=5/", " size='20'", $outXML);
$outXML = preg_replace("/ size=6/", " size='24'", $outXML);
$outXML = preg_replace("/ size=7/", " size='28'", $outXML);
$outXML = preg_replace('/ size="1"/', " size='4'", $outXML);
$outXML = preg_replace('/ size="2"/', " size='8'", $outXML);
$outXML = preg_replace('/ size="3"/', " size='12'", $outXML);
$outXML = preg_replace('/ size="4"/', " size='16'", $outXML);
$outXML = preg_replace('/ size="5"/', " size='20'", $outXML);
$outXML = preg_replace('/ size="6"/', " size='24'", $outXML);
$outXML = preg_replace('/ size="7"/', " size='28'", $outXML);
$outXML = preg_replace("/ target=([-:A-Za-z0-9_]+)/", " target='$1'", $outXML);

//$outXML = strtr($outXML, get_html_translation_table_CP1252());
$outXML = str_replace( array("\x82", "\x84", "\x85", "\x91", "\x92", "\x93", "\x94", "\x95", "\x96",  "\x97"), array("&#8218;", "&#8222;", "&#8230;", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8226;", "&#8211;", "&#8212;"),$outXML);
//echo($outXML);

$myFile = $baseURL."../".$row->filename;
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, utf8_decode($outXML));
fclose($fh);

?><html>
<head>
<title>SiteBuddy - XML Editor</title>
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL) ?>css/sb_general.css" />
<link rel="stylesheet" type="text/css" href="<?php echo($baseURL) ?>css/wysiwyg.css" />
<script src="<?php echo($baseURL) ?>scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="<?php echo($baseURL) ?>scripts/AC_ActiveX.js" type="text/javascript"></script>
<!-- 
	Include the WYSIWYG javascript files
-->
<script type="text/javascript" src="<?php echo($baseURL) ?>scripts/wysiwyg.js"></script>
<script type="text/javascript" src="<?php echo($baseURL) ?>scripts/wysiwyg-settings.js"></script>

<!-- 
	Attach the editor on the textareas
-->
<script type="text/javascript">
	var mysettings = new WYSIWYG.Settings();

	// Use it to attach the editor to all textareas with full featured setup
	WYSIWYG.attach('xml_content', mysettings);
	
	mysettings.ImagesDir = "<?php echo($baseURL) ?>images/"; 
	mysettings.PopupsDir = "<?php echo($baseURL) ?>popups/"; 
	mysettings.CSSFile = "<?php echo($baseURL) ?>css/wysiwyg.css"; 
	mysettings.Width = "600px";
	mysettings.Height = "400px"; 
		
	// Use it to attach the editor directly to a defined textarea
	//WYSIWYG.attach('xml_content'); // default setup
	
	// Use it to display an iframes instead of a textareas
	//WYSIWYG.display('all', full);  
</script>

<SCRIPT TYPE="text/javascript">
<!--
function delContent(ft,dt){
	if(confirm("Do you want to delete "+ft+"?")){
		window.open("xml_admin.php?action=del&pageid=<?php echo($pageid); ?>&subDate="+dt,"_self");
	}
}
function openContent(dt){
	window.open("xml_admin.php?action=load&pageid=<?php echo($pageid); ?>&subDate="+dt,"_self");
}
//-->
</SCRIPT>
</head>

<body>

<h2>XML Editor</h2>

<?php
$sql = "SELECT pageid, submitted FROM sb_xml_history WHERE pageid=".$pageid." ORDER BY submitted DESC";
$result = mysql_query($sql);

?><div id="xml_version_pane">
<div class="section_title">
	<div class="left_item">Version</div>
	<div class="right_item">Del</div>
</div>
<div class="version_listing">
<?php
while($row = mysql_fetch_object($result)){
	$thisDate = strtotime($row->submitted);
	$fmtDate = date("F j, Y, g:i a", $thisDate);
?>	<div class="ver_item">
	<div class="left_item"><a hrev="Javascript:void(0);" onclick="openContent(<?php echo($thisDate); ?>)"><?php echo($fmtDate) ?></a></div>
	<div class="right_item"><div class="deleteIcon" onclick="delContent(<?php echo("'".$fmtDate."',".$thisDate); ?>)"></div></div>
	</div>
<?php } ?></div>
</div>

<?php
$sql = "SELECT * FROM sb_xml_history WHERE pageid=".$pageid." ";
if($action=="load"){
	$submitted = date( 'Y-m-d H:i:s', $subDate );
	$sql .= " AND submitted='".$submitted."';";
} else {
	$sql .= "ORDER BY submitted DESC LIMIT 1";
}
$result = mysql_query($sql);
//echo($sql);
$cur_cont = mysql_fetch_object($result);

?><div id="xml_editor_pane">

<div class="section_title">XML Editor</div>

<form action="xml_admin.php" method="post">
<textarea id="xml_content" name="xml_content"><pre><?php echo(str_replace(array("<pre>","<(\/)pre>"), array("",""), $cur_cont->content)) ?></pre></textarea>

<input type="hidden" name="pageid" value="<?php echo($pageid) ?>">
<input type="hidden" name="action" value="submit">
<br>
<input type="submit" value="Submit Content">
</form>
</div>

</body>
</html>
