<?php
session_start();

// Database information
include("includes/access.php");

require("includes/security.php");

?><html>
<head>
<title>SiteBuddy</title>
<script src="scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="scripts/AC_ActiveX.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/class.css" />
</head>

<body>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td width=1500>
<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','1500','height','45','src','flash/sb_topmenu','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','flash/sb_topmenu', 'bgcolor', '#ffffff', 'mySession', '<?php echo(session_id()); ?>' ); //end AC code
</script><noscript>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="1500" height="45" id="Project Buddy - Tab Menu" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="flash/sb_topmenu.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="flash/sb_topmenu.swf" quality="high" bgcolor="#ffffff" width="1500" height="45" name="SiteBuddy - Top Menu" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object></noscript>
</td>
</table>
</body>

</html>
