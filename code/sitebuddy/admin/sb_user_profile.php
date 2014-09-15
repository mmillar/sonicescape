<?php
/*****************************************
 * SiteBuddy User Profile Screen
 *****************************************/

$action = ISSET($_REQUEST["action"])?$_REQUEST["action"]:"";
$userid = ISSET($_REQUEST["uid"])?$_REQUEST["uid"]:"";

include_once("../includes/mysql_conn.php");

$user = null;

if($userid>0){
	$sql = "SELECT * from sb_users u left join sb_userauth ua using (userid) where userid=".$userid;
	$result = mysql_query($sql);
	$user = mysql_fetch_object($result);
}

?>


<html>
<head>
<title>SiteBuddy - User Management</title>
<link rel="stylesheet" type="text/css" href="../css/sb_general.css" />
<script src="../scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="../scripts/AC_ActiveX.js" type="text/javascript"></script>
</head>

<body>

<div id="page_title">
<div id="top_logo"><img src="../images/titles/sb_user_management.png"></div>
<div id="section_title">- <?php echo($action=="add")?"Add User":"Edit User"; ?></div>
</div>

<SCRIPT TYPE="text/javascript">
<!--
function checkSubmit(commentForm){
	if(commentForm.first_nm.value == ""){
		document.getElementById("error_post").innerHTML = "You need to enter a first name.";
		return false;
	} else if(commentForm.last_nm.value == ""){
		document.getElementById("error_post").innerHTML = "You need to enter a last name.";
		return false;
	} else if(commentForm.password.value == ""){
		document.getElementById("error_post").innerHTML = "You need to enter in a password";
		return false;
	} else if(commentForm.password.value != commentForm.verify.value){
		document.getElementById("error_post").innerHTML = "Your passwords do not match, please re-enter.";
		return false;
	} else if(!isValidEmail(commentForm.email.value)){
		document.getElementById("error_post").innerHTML = "Please enter a valid Email.";
		return false;
	} else {
	   return true;
	}
}

//function to check valid email address
function isValidEmail(strEmail){
  validRegExp = /^[^@]+@[^@]+.[a-z]{2,}$/i;

   // search email text for regular exp matches
    if (strEmail.search(validRegExp) == -1) 
   {
      //alert('A valid e-mail address is required.\nPlease amend and retry');
      return false;
    } 
    return true; 
}
//-->
</SCRIPT>

<form id="user_profile" action="sb_user_admin.php" onsubmit="return checkSubmit(this)" method="post">

<div class="input_area"><input type="text" name="username" size="30" class="text_input" value="<?php echo(($user!=null)?$user->username:""); ?>">Username</div>

<div class="input_area"><input type="text" name="first_nm" size="30" class="text_input" value="<?php echo(($user!=null)?$user->firstname:""); ?>">First Name*</div>

<div class="input_area"><input type="text" name="last_nm" size="30" class="text_input" value="<?php echo(($user!=null)?$user->lastname:""); ?>">Last Name*</div>

<div class="input_area"><input type="text" name="company" size="30" class="text_input" value="<?php echo(($user!=null)?$user->company:""); ?>">Company</div>

<div class="input_area"><input type="text" name="email" size="30" class="text_input" value="<?php echo(($user!=null)?$user->email:""); ?>">E-mail*</div>

<div class="input_area"><input type="password" name="password" size="30" class="text_input" value="<?php echo(($user!=null)?"undefined":""); ?>">Password*</div>

<div class="input_area"><input type="password" name="verify" size="30" class="text_input" value="<?php echo(($user!=null)?"undefined":""); ?>">Verify Password*</div>

<div class="input_area" style="text-align:center;"><input type="submit" value="<?php echo($action=="add")?"Add User":"Update User"; ?>" class="submit_btn" onsubmit="return checkSubmit(this.form)"></div>

<div class="input_area" style="text-align:center;"><div id="error_post"></div></div>

<input type="hidden" name="action" value="<?php echo($action=="add")?"add":"edit"; ?>">
<input type="hidden" name="userid" value="<?php echo(($user!=null)?$user->userid:""); ?>">

</form>

</body>
</html>