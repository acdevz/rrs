<?php
    session_start();
    unset($_SESSION['user_id']);
    session_destroy();
    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra="user-login.php";
    if($host == 'localhost')
		header("Location: user-login.php");
    else
		header("Location: https://$host$uri/$extra");
    exit;
?>
