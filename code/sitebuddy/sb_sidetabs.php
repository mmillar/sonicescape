<?php
session_start();

// Database information
include("includes/access.php");

require("includes/security.php");

?><html>

<head>
<title>SiteBuddy - Side Tabs</title>
<script src="scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="scripts/AC_ActiveX.js" type="text/javascript"></script>
</head>

<body>

<table width=100% cellpadding=0 cellspacing=0>
<tr><td width=45>
<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','45','height','1500','src','flash/sb_sidetabs','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','flash/sb_sidetabs', 'bgcolor', '#EACA6A', 'mySession', '<?php echo(session_id()); ?>'  ); //end AC code
</script><noscript>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="45" height="1500" id="SiteBuddy - Side Tabs" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="flash/PB_TabMenu.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#EACA6A" /><embed src="flash/sb_sidetabs.swf" quality="high" bgcolor="#EACA6A" width="45" height="1500" name="SiteBuddy - Side Tabs" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object></noscript>
</td></table>

</body>
</html>
