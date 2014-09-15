<?php
session_start();

// Database information
include("includes/access.php");

require("includes/security.php");

?><html>
<head>
<title>SiteBuddy - Logo</title>
<STYLE type="text/css">
body { 
	background: #FFFFFF; 
	margin: 0px;
}
</STYLE>
</head>
<body>
<div style="right:0px;float:right;"><a href="./index.php" target="_parent">Logout</a></div>
<img src="./images/sb_logo.jpg">
</body>
</html>