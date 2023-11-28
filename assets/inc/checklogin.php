<?php
function check_login()
{
if(strlen($_SESSION['user_id'])==0)
	{
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="user-login.php";
		$_SESSION["user_id"]="";
		if($host == 'localhost')
			header("Location: user-login.php");
		else
			header("Location: http://$host$uri/$extra");
	}
}
?>
