<?php
    session_start();
    unset($_SESSION['user_id']);
    session_destroy();
    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    if($host == 'localhost')
		header("Location: index.php");
    else
		header("Location: http://$host$uri/");
    exit;
?>
