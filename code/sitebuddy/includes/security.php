<?php

function sanitize($input){
    if(is_array($input)){
        foreach($input as $k=>$i){
            $output[$k]=sanitize($i);
        }
    }
    else{
        if(get_magic_quotes_gpc()){
            $input=stripslashes($input);
        }       
        $output=mysql_real_escape_string($input);
    }   
    return $output;
}


mysql_connect('localhost',$username,$password);
@mysql_select_db($database) or die("Unable to select database");

if(isset($_SESSION['login'])){
	$login = $_SESSION['login'];
	$expire_time = $_SESSION['expire_time'];
} else {
	$login = $_POST['login'];
	$expire_time = time() + 360;
		//TODO: Horrible hardcoding, should be added into user profile settings!!!
		if($login=="shawn@silverrootsmusic.com"||$login=="support@verto.ca"||$login=="shawn@sonicescapemusic.com"){
			$filters = array();
			if(ISSET($_SESSION['sb_contact_filters'])){
				$filters = $_SESSION['sb_contact_filters'];
			} else {
				$filters[] = array("cnd" => "tag", "txt" => "friend", "not" => true, "switch" => false);
				$filters[] = array("cnd" => "tag", "txt" => "teacher", "not" => true, "switch" => false);
				$filters[] = array("cnd" => "tag", "txt" => "audience", "not" => true, "switch" => false);
				$filters[] = array("cnd" => "tag", "txt" => "acquaint", "not" => true, "switch" => false);
				$filters[] = array("cnd" => "tag", "txt" => "mailing", "not" => true, "switch" => false);
				$_SESSION['sb_contact_filters'] = $filters;
			}
		}
}

$query="SELECT * FROM sb_users u LEFT JOIN sb_userauth ua USING(userid) where u.email='$login'";
$result=mysql_query($query);

if(mysql_numrows($result)>0){

	$user = mysql_fetch_object($result);

	if(isset($_SESSION['encrypt_pwd'])){
		$encrypt_pwd = $_SESSION['encrypt_pwd'];
	} else {
		$encrypt_pwd = crypt($_POST['password'],$user->password);
	}

	$login_check = ($encrypt_pwd==$user->password);
}


if($login_check && ($expire_time > time())) {
	$_SESSION['login'] = $login;
	$_SESSION['encrypt_pwd'] = $encrypt_pwd;
	$_SESSION['expire_time'] = time() + 60*30; //Session time of 30 minutes
} else {
  	header("Location: /sitebuddy/index.php?output=Incorrrect%20email%20or%20password,%20please%20try%20again.");
  	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	//echo ($encrypt_pwd." / ".$login_check." / ".$expire_time);
	exit;
}


?>
