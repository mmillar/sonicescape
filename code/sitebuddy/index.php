<?php
session_start();

if(isset($_SESSION['login'])) unset($_SESSION['login']);
if(isset($_SESSION['encrypt_pwd'])) unset($_SESSION['encrypt_pwd']);
?>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SiteBuddy - 1237west.com</title>

<link rel="stylesheet" type="text/css" href="css/class.css" />

<script language="JavaScript"><!--
if (self != top)
	parent.location='./index.php?output=<?php echo $_REQUEST['output']; ?>';
//--></script></head>

<body onLoad="document.forms[0].login.focus()" style="background-color:white";>



<form method="POST" action="sb_makeframes.php">

<table align="center" width="100%" cellspacing=0 cellpadding=0>

<tr>

<td colspan="4" align="center"><br><img src="images/sb_logo.jpg"></td>

</tr>

<tr>

<td colspan="4"><br><br></td>

</tr>

<tr>

<td width="50%"></td>

<td align="right" valign="top">E-mail:&nbsp;&nbsp;</td>

<td valign="top"><input type="text" name="login" size="30"></td>

<td width="50%"></td>

</tr>

<tr>

<td width="50%"></td>

<td align="right" valign="top">Password:&nbsp;&nbsp;</td>

<td valign="top"><input type="password" name="password" size="30"><br><br></td>

<td width="50%"></td>

</tr>

<tr>

<td colspan="4" align=center><input type="submit" value="Log in" size="30"></td>

</tr>

<tr>

<td colspan="4" align=center><br><br></td>

</tr>

<?php if(ISSET($_GET['output'])) echo("<tr><td colspan=\"4\" align=\"center\"><br><font color=red>".$_GET['output']."</font></td></tr>"); ?>

</table>

</form>



</body>



</html>