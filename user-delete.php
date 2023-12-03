<?php
    session_start();
    include('assets/inc/config.php');
    include('assets/inc/checklogin.php');
    check_login();
    $aid=$_SESSION['user_id'];
    
    // delete from user 
    $stmt = $mysqli->prepare("delete from USER where username = ?");
    $stmt->bind_param('s', $aid);
    $stmt->execute();
    // delete from passenger
    $stmt = $mysqli->prepare("delete from PASSENGER where username = ?");
    $stmt->bind_param('s', $aid);
    $stmt->execute();
    // delete from ticket
    $stmt = $mysqli->prepare("delete from TICKET where username = ?");
    $stmt->bind_param('s', $aid);
    $stmt->execute();
    // delete from cancel
    $stmt = $mysqli->prepare("delete from CANCEL where username = ?");
    $stmt->bind_param('s', $aid);
    $stmt->execute();
    $stmt->close();

    unset($_SESSION['user_id']);
    session_destroy();
    $host = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

	header("Location: http://$host$uri/");
    exit;
?>