<?php
session_start();

// Database information
include("includes/access.php");

require("includes/security.php");

?><HTML>

<HEAD>

<TITLE>SiteBuddy</TITLE>

</HEAD>



<FRAMESET rows="70,45,*" scrolling="no" frameborder="no" framespacing="0" border="0">

  <FRAME name="sb_logopage" src="sb_logo.php" scrolling="no" MARGINWIDTH="0" MARGINHEIGHT="0">

  <FRAME name="sb_topmenu" src="sb_topmenu.php" scrolling="no" MARGINWIDTH="0" MARGINHEIGHT="0">

  <FRAME name="sb_mainpage" src="sb_mainpage.php" scrolling="yes" MARGINWIDTH="0" MARGINHEIGHT="0">

</FRAMESET>

</HTML>

