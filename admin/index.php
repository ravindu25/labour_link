<?php
    session_start();
    //if not logged in redirect to login page
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Admin') {
        header("Location: admin-login.php");
    }else{
        header("Location: dashboard.php");
    }

?>