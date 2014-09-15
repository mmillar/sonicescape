<?php
session_start();

// Database information
include("includes/access.php");

require("includes/security.php");

?><HTML>

<HEAD>

<TITLE>SiteBuddy</TITLE>

</HEAD>



<FRAMESET cols="45,*" scrolling="no" frameborder="no" framespacing="0" border="0">

  <FRAME name="sb_sidetabs" src="sb_sidetabs.php" scrolling="no" MARGINWIDTH="0" MARGINHEIGHT="0">

  <FRAMESET rows="1,*" scrolling="no" frameborder="no" framespacing="0" border="0">
    
    <FRAME name="sb_tabborder" src="grey_spacer.html" scrolling="no" MARGINWIDTH="0" MARGINHEIGHT="0">

    <FRAME name="sb_modulepage" src="empty.html" scrolling="yes" MARGINWIDTH="0" MARGINHEIGHT="0">

  </FRAMESET>

</FRAMESET>

</HTML>
